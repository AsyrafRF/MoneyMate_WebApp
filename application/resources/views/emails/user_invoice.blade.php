<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Berhasil - MoneyMate</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f5;
        }
        .header {
            background-color: #ffffff;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .logo {
            max-width: 70px;
            height: auto;
        }
        .body-content {
            padding: 40px 30px;
        }
        h2 {
            color: #1a1a1a;
            margin-top: 0;
            font-size: 22px;
            font-weight: 600;
        }
        p {
            margin: 0 0 16px;
            color: #555555;
            font-size: 15px;
        }
        .highlight-box {
            background-color: #f4f7ff;
            border-left: 4px solid #0052cc;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 0 6px 6px 0;
        }
        .highlight-box p {
            margin: 0;
            color: #243b53;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        .signature {
            color: #888888;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="header">
            <img src="https://moneymate.id/images/moneymate-original.png" alt="MoneyMate Logo" class="logo">
        </div>

        <div class="body-content">
            <h2>Halo, {{ $transaction->user->name }}!</h2>
            
            <p>Terima kasih telah melakukan pembayaran.</p>
            <p>Kami informasikan bahwa pembayaran Anda untuk paket <strong>{{ strtoupper($transaction->plan) }}</strong> telah berhasil diterima dan diverifikasi oleh sistem kami.</p>
            
            <div class="highlight-box">
                <p>Selamat! Akun Anda kini aktif sebagai anggota <strong>PREMIUM</strong> hingga tanggal <strong>{{ \Carbon\Carbon::parse($transaction->user->subscription_until)->format('d F Y') }}</strong>.</p>
            </div>
            
            <p>Detail invoice resmi telah kami lampirkan dalam format PDF bersama dengan email ini sebagai bukti pembayaran yang sah.</p>
            
            <div class="footer">
                <p class="signature">
                    Salam hangat,<br>
                    <strong>MoneyMate Team</strong>
                </p>
            </div>
        </div>
    </div>

</body>
</html>