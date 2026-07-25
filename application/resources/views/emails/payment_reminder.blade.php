<h2>Halo, {{ $transaction->user->name }}!</h2>
<p>Kami memperhatikan kamu hampir menjadi member <strong>Premium MoneyMate</strong>.</p>

<div style="background: #f8f9fa; padding: 15px; border-radius: 8px;">
    <p><strong>Invoice:</strong> {{ $transaction->invoice_number }}</p>
    <p><strong>Total Transfer:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
</div>

<p>Segera upload bukti pembayaran kamu sebelum link pembayaran kadaluarsa dalam 12 jam ke depan.</p>

<a href="{{ $url }}" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #74b9ff, #0984e3); color: white; text-decoration: none; border-radius: 5px;">
    Upload Bukti Sekarang
</a>

<p>Jika kamu mengabaikan pesan ini, pesanan akan dibatalkan otomatis oleh sistem.</p>