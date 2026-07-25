<!-- resources/views/emails/notifikasi.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atur Ulang Password</title> 

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f1f3f5;
            font-family: Arial, Helvetica, sans-serif;
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
            text-align: center;
            padding: 0 20px 25px;
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
        .sender {
            margin-top: 25px;
            font-style: italic;
            font-size: 14px;
            color: #444;
        }
        .footer {
            padding: 18px 25px 25px;
            color: #777;
            font-size: 12px;
            text-align: center;
            border-top: 1px solid #eaeaea;
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

        <!-- Header -->
        <div class="header">
            <h2>Permintaan Atur Ulang Password</h2>
        </div>

        <!-- Card Content -->
        <div class="card">
            <div class="content">
                <p>Halo {{ $user->name ?? 'Pengguna Terhormat' }},</p>

                <p>
                    Kami menerima permintaan untuk mengatur ulang password akun Anda di <strong>MoneyMate</strong>.
                </p>

                <p>
                    Untuk melanjutkan proses ini, silakan klik tombol di bawah ini:
                </p>

                <p style="text-align:center; margin: 25px 0;">
                    <a href="{{ $url }}" style="
                        display:inline-block;
                        padding:12px 22px;
                        background:#65abe6;
                        color:#ffffff;
                        text-decoration:none;
                        border-radius:8px;
                        font-weight:600;
                    ">
                        Atur Ulang Password
                    </a>
                </p>

                <p style="word-break: break-all; font-size: 13px; color:#666;">
                    Jika tombol tidak berfungsi, salin dan buka link berikut di browser Anda:<br>
                    {{ $url }}
                </p>

                <p>
                    Link ini hanya berlaku dalam waktu terbatas demi keamanan akun Anda.
                </p>

                <p>
                    Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan email ini. Tidak ada perubahan yang akan terjadi pada akun Anda.
                </p>

                <p>
                    Demi keamanan, jangan pernah membagikan link ini kepada siapa pun.
                </p>
            </div>

            <p class="sender">
                Hormat kami,<br>
                Tim MoneyMate
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            Email ini dikirim otomatis oleh <strong>MoneyMate</strong>.<br>
            Mohon untuk tidak membalas email ini.
        </div>

    </div>
</body>
</html>