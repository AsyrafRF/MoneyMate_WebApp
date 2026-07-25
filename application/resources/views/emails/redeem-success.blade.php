<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Aktif - MoneyMate</title>
    <style>
        /* Reset & Base Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333333;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-collapse: collapse;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f6f8;
            padding: 40px 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        /* Header */
        .header {
            padding: 32px 40px 20px 40px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        .logo {
            max-width: 90px;
            height: auto;
        }

        /* Content */
        .content {
            padding: 40px;
        }
        h2 {
            margin-top: 0;
            color: #111111;
            font-size: 22px;
            font-weight: 700;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #555555;
            margin: 16px 0;
        }

        /* Detail Card */
        .detail-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            margin: 28px 0;
        }
        .detail-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 16px;
            font-weight: 700;
        }
        .detail-table {
            width: 100%;
        }
        .detail-table td {
            padding: 8px 0;
            font-size: 15px;
            vertical-align: top;
        }
        .detail-label {
            color: #64748b;
            width: 35%;
        }
        .detail-value {
            color: #1e293b;
            font-weight: 600;
        }

        /* CTA / Footer Text */
        .success-text {
            font-weight: 500;
            color: #0f172a;
        }

        /* Footer */
        .footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 32px 40px;
            text-align: center;
            font-size: 13px;
        }
        .footer a {
            color: #38bdf8;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .social-links {
            margin-bottom: 16px;
        }
        .social-links a {
            margin: 0 8px;
            color: #ffffff;
            font-weight: 500;
        }
        .copyright {
            margin-top: 16px;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #334155;
            padding-top: 16px;
        }
    </style>
</head>
<body>

    <center class="wrapper">
        <div class="container">
            
            <!-- Header Logo -->
            <div class="header">
                <img src="https://moneymate.id/images/moneymate-original.png" alt="MoneyMate ID Logo" class="logo">
            </div>

            <!-- Main Content -->
            <div class="content">
                <h2>Halo, {{ $user->name }} 👋</h2>
                <p>Selamat! Trial premium Anda telah berhasil diaktifkan. Sekarang Anda memiliki akses penuh ke fitur eksklusif kami untuk membantu mengelola finansial Anda dengan lebih cerdas.</p>

                <!-- Detail Plan -->
                <div class="detail-card">
                    <div class="detail-title">Detail Premium Anda</div>
                    <table class="detail-table">
                        <tr>
                            <td class="detail-label">Plan</td>
                            <td class="detail-value">{{ $plan }}</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Durasi</td>
                            <td class="detail-value">{{ $duration }} Hari</td>
                        </tr>
                        <tr>
                            <td class="detail-label">Berlaku Sampai</td>
                            <td class="detail-value">{{ $expirationDate->translatedFormat('d F Y H:i') }} WIB</td>
                        </tr>
                    </table>
                </div>

                <p class="success-text">Yuk, langsung eksplorasi dan nikmati seluruh fitur premium yang tersedia! 🚀</p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="social-links">
                    <!-- Silakan sesuaikan link sosial media resmi MoneyMate -->
                    <a href="https://instagram.com/moneymate_id" target="_blank">Instagram</a> • 
                    <a href="https://linkedin.com/company/moneymate-id" target="_blank">LinkedIn</a> • 
                    <a href="https://moneymate.id" target="_blank">Website</a>
                </div>
                
                <p style="margin: 5px 0;">Butuh bantuan? Hubungi tim support kami di <a href="mailto:support@moneymate.id">support@moneymate.id</a></p>
                
                <div class="copyright">
                    &copy; {{ date('Y') }} MoneyMate ID. All rights reserved.<br>
                    Batam City, Indonesia.
                </div>
            </div>

        </div>
    </center>

</body>
</html>