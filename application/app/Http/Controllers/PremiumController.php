<?php

namespace App\Http\Controllers;

use Barrier; // Import facade PDF di bagian atas
use App\Mail\AdminPaymentNotification; 
use App\Mail\UserInvoiceNotification;
use App\Models\PremiumTransaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PremiumController extends Controller
{
    public function price()
    {
        return view('premium.upgrade');
    }

    // Tahap 1: Halaman Checkout
    public function checkout(Request $request)
    {
        $plan = $request->query('plan'); // Mengambil dari URL ?plan=monthly
        $user = auth()->user();

        // Tentukan harga dasar
        $baseAmount = ($plan == 'monthly') ? 19900 : 219900;

        // CEK: Apakah ini transaksi pertama user?
        $isFirstTransaction = !PremiumTransaction::where('user_id', $user->id)
                                ->where('status', 'success')
                                ->exists();

        $discount = 0;
        if ($isFirstTransaction && $plan == 'monthly') {
            $discount = 10000; // Diskon 50,25% menjadi 9900
        }

        // Generate kode unik 2 digit
        $uniqueCode = rand(10, 99);
        // Nominal yang dibayarkan
        $totalAmount = ($baseAmount - $discount) + $uniqueCode;

        // Hasil: INV-20260405-A7B2X
        $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(str()->random(5));

        return view('premium.checkout', compact('plan', 'baseAmount', 'discount', 'uniqueCode', 'totalAmount', 'invoice', 'isFirstTransaction'));
    }

    // Tahap 2: Simpan Transaksi & Arahkan ke Upload
    public function store(Request $request)
    {
        // Tambahkan validasi agar aplikasi tidak crash jika input kosong
        $request->validate([
            'invoice' => 'required|string',
            'plan' => 'required',
            'baseAmount' => 'required|numeric',
            'uniqueCode' => 'required',
            'totalAmount' => 'required|numeric',
        ]);

        $plan = $request->plan;
        // Tentukan durasi berdasarkan paket
        $days = ($plan == 'monthly') ? 30 : 365;

        $baseAmount = ($plan == 'monthly') ? 19900 : 219900;
        
        // Validasi ulang diskon di server
        $isFirstTransaction = !PremiumTransaction::where('user_id', auth()->id())
                                ->where('status', 'success')
                                ->exists();

        $discount = ($isFirstTransaction && $plan == 'monthly') ? 10000 : 0;
        
        $uniqueCode = $request->uniqueCode;
        $totalAmount = ($baseAmount - $discount) + $uniqueCode;

        $transaction = PremiumTransaction::create([
            'user_id' => auth()->id(),
            'invoice_number' => $request->invoice,
            'plan' => $plan,
            'amount' => $baseAmount,
            'discount_amount' => $discount,
            'unique_code' => $uniqueCode,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('premium.upload', $transaction->id)
            ->with('warning', 'Mohon pembayaran disesuaikan hingga 3 digit terakhir agar bisa diverifikasi 🙏');
    }

    // Tahap 3: Halaman Upload Bukti
    public function uploadPage($id)
    {
        $transaction = PremiumTransaction::findOrFail($id);

        // Cek jika sudah expired
        if ($transaction->status === 'rejected') {
            return redirect()->route('keuangan.index')
                ->with('alert', 'Transaksi ini sudah kadaluarsa. Silahkan buat pesanan baru.');
        }

        return view('premium.upload', compact('transaction'));
    }

    // Tahap 4: Proses Upload & Kirim Email ke Admin
    public function processUpload(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'proof.required' => 'Mohon unggah bukti transfer Anda.',
            'proof.image' => 'File harus berupa gambar.',
            'proof.max' => 'Ukuran gambar maksimal adalah 2MB.'
        ]);

        try {
            $transaction = PremiumTransaction::with('user')->findOrFail($id);

            // 2. Proses Simpan File
            if ($request->hasFile('proof')) {
                $path = $request->file('proof')->store('payment_proofs', 'public');
            } else {
                throw new \Exception("Gagal membaca file gambar.");
            }

            // 3. Update Database
            $transaction->update([
                'proof_path' => $path,
                'status' => 'verifying'
            ]);

            // 4. Kirim Email
            // Gunakan Mail::queue jika ingin proses lebih cepat bagi user
            Mail::to('moneymate.app.id@gmail.com')->queue(new AdminPaymentNotification($transaction->fresh(['user'])));

            return redirect()->route('premium.status', $transaction->id)
                            ->with('success', 'Bukti pembayaran berhasil dikirim!');

        } catch (\Exception $e) {
            // Log error untuk kebutuhan internal admin
            \Log::error("Gagal Upload/Kirim Email: " . $e->getMessage());

            // Kembalikan ke halaman sebelumnya dengan pesan error yang jelas
            return back()->withInput()
                        ->with('error', 'Terjadi kesalahan teknis: ' . $e->getMessage());
        }
    }

    // Tahap 5: Halaman Status
    // Dipindahkan ke LiveWire

    public function confirmPayment($id)
    {
        $transaction = PremiumTransaction::findOrFail($id);
        $user = $transaction->user;

        $days = ($transaction->plan == 'monthly') ? 30 : 365;

        // Logika akumulasi masa aktif
        if ($user->is_premium && $user->subscription_until && $user->subscription_until->isFuture()) {
            $newSubscriptionUntil = \Carbon\Carbon::parse($user->subscription_until)->addDays($days);
        } else {
            $newSubscriptionUntil = now()->addDays($days);
        }

        // 1. Update User Jadi Premium
        $user->update([
            'is_premium' => true,
            'subscription_plan' => $transaction->plan,
            'subscription_until' => $newSubscriptionUntil
        ]);

        // 2. Update Status Transaksi
        $transaction->update(['status' => 'success']);

        // 3. KIRIM EMAIL INVOICE KE USER
        // Menggunakan .fresh() agar data 'user' yang terikat sudah membawa data tanggal 'subscription_until' terbaru
        Mail::to($user->email)->queue(new UserInvoiceNotification($transaction->fresh(['user'])));

        return redirect()->route('admin.dashboard')->with('success', 'User telah berhasil diupgrade dan email invoice telah dikirim!');
    }

    public function history()
    {
        $transactions = PremiumTransaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Gunakan pagination agar rapi jika transaksi banyak

        return view('premium.history', compact('transactions'));
    }

    public function downloadInvoice($id)
    {
        $transaction = PremiumTransaction::with('user')
            ->where('user_id', auth()->id())
            ->where('status', 'success') // Hanya bisa download jika sudah sukses
            ->findOrFail($id);

        $data = [
            'transaction' => $transaction,
            'date' => now()->format('d/m/Y'),
        ];

        // Load view khusus invoice dan convert ke PDF
        $pdf = Pdf::loadView('partials.pdf.premium.invoice_pdf', $data)->setPaper('a4', 'portrait')->setOption(['enable_php' => true]);

        // Download file dengan nama invoice_INV-XXXXX.pdf
        return $pdf->stream('invoice_' . $transaction->invoice_number . '.pdf');
    }
}