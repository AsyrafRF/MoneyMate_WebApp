<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran kadaluwarsa!</title>

    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            line-height: 1.6; 
            color: #333; 
        }
        .container { 
            width: 80%; 
            margin: 20px auto; 
            border: 1px solid #eee; 
            padding: 20px; 
            border-radius: 10px; 
        }
        .wrapper {
            width: 100%;
            max-width: 620px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e4e6e8;
            box-shadow: 0 4px 18px rgba(0,0,0,0.07);
        }
        .logo-area {
            text-align: center;
            padding: 30px 20px 15px;
        }
        .logo-area img {
            width: 140px;
            max-width: 100%;
        }
        .header { 
            border-bottom: 2px solid #f8d7da; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #2d2f36;
            font-weight: 600;
        }
        .card {
            margin: 0 25px 25px;
            padding: 20px 22px;
            background: #f8f9fc;
            border-radius: 12px;
            border: 1px solid #e2e5e9;
        }
        .content {
            color: #333;
            line-height: 1.65;
            font-size: 15px;
        }
        .invoice-box { 
            background: #f9f9f9; 
            padding: 15px; 
            border-radius: 5px; 
            margin: 20px 0; 
            border-left: 4px solid #dc3545; 
        }
        .sender {
            margin-top: 25px;
            font-style: italic;
            font-size: 14px;
            color: #444;
        }
        .footer { 
            font-size: 0.8em; 
            color: #888; 
            margin-top: 30px; 
            border-top: 1px solid #eee; 
            padding-top: 10px; 
        }

        /* Dark Mode */
        @media (prefers-color-scheme: dark) {
            body {
                background: #1f1f1f;
            }
            .wrapper {
                background: #2a2a2a;
                border-color: #444;
                box-shadow: none;
            }
            .header h2 {
                color: #eaeaea;
            }
            .card {
                background: #333;
                border-color: #555;
            }
            .content {
                color: #eaeaea;
            }
            .sender {
                color: #ddd;
            }
            .footer {
                color: #aaa;
                border-color: #444;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <!-- Logo -->
        <div class="logo-area">
            <!-- GANTI LOGO DI SINI -->
            <img src="https://moneymate.id/images/moneymate-original.png" alt="MoneyMate">
        </div>

        <div class="container">
            <!-- Header -->
            <div class="header">
                <h2 style="color: #dc3545;">Update Status Transaksi</h2>
            </div>

            <!-- Card Content -->
            <div class="card">
                <div class="content">
                    <p>Halo, <strong>{{ $transaction->user->name }}</strong>,</p>

                    <p>Kami ingin menginformasikan bahwa batas waktu pembayaran untuk pesanan Anda telah berakhir. Karena kami tidak menerima unggahan bukti pembayaran dalam waktu 24 jam, maka sistem kami telah <strong>membatalkan</strong> transaksi tersebut secara otomatis.</p>

                    <div class="invoice-box">
                        <strong>Detail Transaksi:</strong><br>
                        No. Invoice: #{{ $transaction->invoice_number }}<br>
                        Paket: {{ ucfirst($transaction->plan) }}<br>
                        Total Bayar: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                    </div>

                    <p><strong>Kenapa ini terjadi?</strong><br>
                    Sistem kami memerlukan bukti pembayaran untuk memverifikasi pesanan Anda secara manual agar fitur <em>Premium</em> dapat segera diaktifkan pada akun Anda.</p>

                    <p>Jika Anda masih ingin menikmati fitur unggulan (tanpa limit saldo dan akses eksklusif lainnya), silakan ajukan pesanan ulang melalui aplikasi.</p>

                    <p style="margin-top: 30px;">
                        <a 
                            href="{{ url('/plans') }}" 
                            style="background: linear-gradient(135deg, #74b9ff, #0984e3); color: #fff; padding: 10px 16px;
                                        text-decoration: none; border-radius: 6px; display: inline-block;">
                                Pesan Kembali Sekarang
                        </a>
                    </p>
                </div>

                <p class="sender">
                    — MoneyMate ID
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Pesan ini dikirim secara otomatis oleh sistem <strong>MoneyMate</strong>. Mohon tidak membalas email ini.</p>
            <p>Saldo saat ini: <strong>{{ $transaction->user->saldo_rupiah }}</strong></p>
        </div>

    </div>
</body>
</html>
