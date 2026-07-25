<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Event Baru - MoneyMate</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f6f9fc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; -webkit-font-smoothing: antialiased;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f6f9fc; padding: 40px 20px;">
        <tr>
            <td align="center">
                
                <!-- CONTAINER UTAMA -->
                <table width="100%" max-width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                    
                    <!-- HEADER / LOGO -->
                    <tr>
                        <td align="center" style="padding: 30px 40px 20px 40px; border-bottom: 1px solid #f0f0f0;">
                            <img src="https://moneymate.id/images/moneymate-original-notext.png" alt="MoneyMate Logo" style="max-height: 45px; width: auto; display: block;">
                        </td>
                    </tr>

                    <!-- HERO BANNER / IDENTITAS EMAIL -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px;">
                            <span style="display: inline-block; padding: 6px 12px; background-color: #e0f2fe; color: #0369a1; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; border-radius: 20px; margin-bottom: 16px;">
                                Pengumuman & Pemberitahuan
                            </span>
                            <h2 style="margin: 0; font-size: 24px; font-weight: 700; line-height: 1.3; color: #111827;">
                                Halo Sobat MoneyMate! Ada Pemberitahuan dari MoneyMate yang Menantimu ✨
                            </h2>
                        </td>
                    </tr>

                    <!-- BODY TEXT -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px; font-size: 15px; line-height: 1.6; color: #4b5563;">
                            <p style="margin: 0 0 16px 0;">
                                Ada kabar dari MoneyMate hari ini! Tim MoneyMate baru saja merilis Pemberitahuan & Pengumuman baru yang yang berlaku untukmu sebagai pengguna MoneyMate. 
                            </p>
                            <p style="margin: 0;">
                                Yuk, persiapkan diri dan catat detail agendanya di bawah ini agar kamu tidak ketinggalan slot:
                            </p>
                        </td>
                    </tr>

                    <!-- DETAIL EVENT (CARD DI DALAM EMAIL) -->
                    <tr>
                        <td style="padding: 0 40px 30px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;">
                                <tr>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-weight: bold; font-size: 14px; color: #64748b; width: 30%;">
                                        Nama Event
                                    </td>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-size: 15px; font-weight: 600; color: #0f172a;">
                                        {{ $event->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-weight: bold; font-size: 14px; color: #64748b;">
                                        Mulai
                                    </td>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-size: 15px; color: #334155;">
                                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-weight: bold; font-size: 14px; color: #64748b;">
                                        Selesai
                                    </td>
                                    <td style="padding-bottom: 12px; vertical-align: top; font-size: 15px; color: #334155;">
                                        {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top; font-weight: bold; font-size: 14px; color: #64748b;">
                                        Tentang Acara
                                    </td>
                                    <td style="vertical-align: top; font-size: 14px; line-height: 1.5; color: #475569; font-style: italic;">
                                        "{{ Str::limit(strip_tags($event->description), 180) }}"
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CALL TO ACTION ACTION -->
                    <tr>
                        <td align="center" style="padding: 10px 40px 40px 40px;">
                            <p style="margin: 0 0 20px 0; font-size: 14px; color: #6b7280; text-align: center;">
                                Detail lengkap mengenai pembicara, syarat & ketentuan, serta benefit lainnya bisa kamu akses langsung melalui aplikasi atau tautan di bawah ini.
                            </p>
                            <!-- Sesuaikan link url dengan rute detail event web Anda jika ada -->
                            <a href="{{ url('/events') }}" target="_blank" style="display: inline-block; padding: 14px 32px; background-color: #0284c7; color: #ffffff; font-weight: 600; font-size: 15px; text-decoration: none; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(2, 132, 199, 0.2);">
                                Lihat & Amankan Slot Anda 🚀
                            </a>
                        </td>
                    </tr>

                    <!-- PENUTUP -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px; border-bottom: 1px solid #f0f0f0; font-size: 14px; color: #4b5563;">
                            Sampai jumpa di ruang acara, ya! Jika ada pertanyaan, jangan ragu untuk menyapa kami kembali.
                            <br><br>
                            Warm regards,<br>
                            <strong>Tim Manajemen Event MoneyMate</strong>
                        </td>
                    </tr>

                    <!-- FOOTER & SOSIAL MEDIA -->
                    <tr>
                        <td align="center" style="background-color: #fafafa; padding: 30px 40px;">
                            <p style="margin: 0 0 16px 0; font-size: 12px; color: #9ca3af; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px;">
                                Terhubung Bersama Kami
                            </p>
                            
                            <!-- Ikon Sosial Media Menggunakan Text Link yang Rapi -->
                            <div style="margin-bottom: 20px;">
                                <a href="https://www.instagram.com/moneymate_id" target="_blank" style="color: #4b5563; text-decoration: none; margin: 0 10px; font-size: 13px; font-weight: 600;">Instagram</a> •
                                <a href="https://x.com/moneymateid" target="_blank" style="color: #4b5563; text-decoration: none; margin: 0 10px; font-size: 13px; font-weight: 600;">X (Twitter)</a> •
                                <a href="https://www.tiktok.com/@moneymate.id" target="_blank" style="color: #4b5563; text-decoration: none; margin: 0 10px; font-size: 13px; font-weight: 600;">TikTok</a> •
                                <a href="mailto:moneymate.app.id@gmail.com" style="color: #4b5563; text-decoration: none; margin: 0 10px; font-size: 13px; font-weight: 600;">Email</a>
                            </div>

                            <p style="margin: 0; font-size: 12px; color: #9ca3af; line-height: 1.4;">
                                © {{ date('Y') }} MoneyMate ID. All rights reserved.<br>
                                Anda menerima email ini karena Anda adalah member terdaftar dari platform MoneyMate.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- END OF CONTAINER UTAMA -->

            </td>
        </tr>
    </table>

</body>
</html>