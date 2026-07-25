<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <link href="{{ public_path('css/app/premium/invoice-pdf.css') }}" rel="stylesheet">
</head>
<body>

<div class="invoice-box">

    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="invoice-title">Invoice</div>
                    <div class="invoice-number">
                        Invoice No. {{ $transaction->invoice_number }}
                    </div>
                </td>

                <td style="text-align:right;">
                    <img src="{{ public_path('images/moneymate-original.png') }}"
                         width="120">
                </td>
            </tr>

            <tr>
                <td></td>
                <td class="invoice-date">
                    Invoice Date :
                    {{ $transaction->created_at->format('d F Y') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- CUSTOMER INFO --}}
    <div class="customer-box">
        <table>
            <tr>
                <td class="label">ID Pemesanan</td>
                <td>: {{ $transaction->invoice_number }}</td>
            </tr>
            <tr>
                <td class="label">Nama</td>
                <td>: {{ $transaction->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>: {{ $transaction->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td>: {{ $transaction->payment_method ?? 'Transfer' }}</td>
            </tr>
        </table>
    </div>

    {{-- GREETING --}}
    <div class="greeting">
        <strong>Dear, {{ $transaction->user->name }}</strong>

        <p>
            Dengan ini kami sampaikan detail langganan Anda sesuai
            dengan permintaan yang telah disampaikan sebelumnya.
            Untuk memudahkan pengecekan, seluruh informasi mengenai
            periode langganan, harga dan status pembayaran telah kami
            rangkum dalam tabel berikut.
        </p>
    </div>

    {{-- TABEL INVOICE --}}
    <table class="table">
        <tr class="heading">
            <td>Deskripsi Layanan</td>
            <td style="text-align:right;">Harga</td>
        </tr>

        <tr>
            <td>
                Langganan Premium ({{ ucfirst($transaction->plan) }})
                {{-- LOGIKAL MASA AKTIF SECARA DINAMIS --}}
                <span class="text-muted">
                    Masa Aktif: {{ $transaction->created_at->format('d M Y') }} - 
                    @if(str_contains(strtolower($transaction->plan), 'year') || str_contains(strtolower($transaction->plan), 'tahunan'))
                        {{ $transaction->created_at->addYear()->format('d M Y') }}
                    @else
                        {{ $transaction->created_at->addMonth()->format('d M Y') }}
                    @endif
                </span>
            </td>

            <td style="text-align:right; vertical-align: top;">
                Rp {{ number_format($transaction->amount,0,',','.') }}
            </td>
        </tr>

        @if($transaction->discount_amount > 0)
        <tr>
            <td>Diskon Member Baru</td>
            <td style="text-align:right;color:green;">
                - Rp {{ number_format($transaction->discount_amount,0,',','.') }}
            </td>
        </tr>
        @endif

        <tr>
            <td>Kode Unik Verifikasi</td>
            <td style="text-align:right;">
                Rp {{ number_format($transaction->unique_code,0,',','.') }}
            </td>
        </tr>

        <tr class="heading">
            <td>Total</td>
            <td style="text-align:right;" class="total">
                Rp {{ number_format($transaction->total_amount,0,',','.') }}
            </td>
        </tr>
    </table>

    {{-- THANK YOU --}}
    <div class="thank-you">
        <p>Terima kasih atas kepercayaan Anda.</p>

        <p>
            Detail pesanan telah kami lampirkan sesuai permintaan.
            Jika terdapat pertanyaan terkait pembayaran atau langganan,
            silakan hubungi tim MoneyMate.
        </p>

        <div class="signature">
            Hormat kami,<br>
            MoneyMate Team
        </div>
    </div>

</div>

{{-- FOOTER --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td class="footer-left">
                © {{ date('Y') }} MoneyMate ID. All Rights Reserved.
            </td>

            <td class="footer-right">
                Payment Invoice
            </td>
        </tr>
    </table>
</div>

</body>
</html>