<!-- resources/views/emails/notifikasi.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifikasi Admin - Penangguhan Akun</title>

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
            <h2>Notifikasi Admin - Penangguhan Akun</h2>
        </div>

        <!-- Card Content -->
        <div class="card">
            <div class="content">
                <h2>Halo Admin,</h2>
                <p>Sistem mendeteksi bahwa ada pengguna yang telah melakukan proses penghapusan akun. Saat ini akun tersebut masuk ke dalam daftar tunggu (Soft Delete).</p>
                
                <table style="border-collapse: collapse; width: 100%; max-width: 500px; margin-top: 15px;">
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;">Nama Pengguna</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;">Email</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; background-color: #f9f9f9;">Waktu Penangguhan</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ now()->toDayDateTimeString() }}</td>
                    </tr>
                </table>
                
                <p style="margin-top: 15px;">Akun ini akan otomatis dihapus permanen oleh sistem lewat <em>Cron Job</em> setelah melewati masa tenggang (7 hari), kecuali jika pengguna yang bersangkutan melakukan login kembali untuk memulihkan akunnya.</p>
            </div>

            <p class="sender">
                — Sistem MoneyMate
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
