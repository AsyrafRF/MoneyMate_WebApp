<!-- resources/views/legal/privacy.blade.php -->
@extends('layouts.legal')

@section('title', 'Kebijakan Privasi & Pelindungan Data Pribadi')

@section('content')
<div class="onboarding-content">
    <div class="onboarding-card">

        <div class="legal-document">
            <p class="doc-meta">
                Dokumen: Kebijakan Privasi &amp; Pelindungan Data Pribadi MoneyMate<br>
                Versi: 1.0 &middot; Berlaku Efektif: 1 Mei 2026<br>
                Dasar Hukum: UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi<br>
                Pengendali Data Pribadi: MoneyMate ID
            </p>

            <h2>PASAL 1 — PENDAHULUAN</h2>
            <p>MoneyMate berkomitmen untuk melindungi Data Pribadi Pengguna. Kebijakan Privasi &amp; Pelindungan Data Pribadi ini ("Kebijakan") menjelaskan bagaimana MoneyMate mengumpulkan, menggunakan, menyimpan, mengungkapkan, dan melindungi Data Pribadi Pengguna, sebagaimana diwajibkan oleh Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi ("UU PDP") dan peraturan pelaksananya.</p>

            <h2>PASAL 2 — IDENTITAS PENGELOLA DATA PRIBADI</h2>
            <p>Dalam konteks Kebijakan ini, MoneyMate ID bertindak sebagai Pengendali Data Pribadi sebagaimana dimaksud dalam UU PDP. Pengendali Data Pribadi bertanggung jawab atas penentuan tujuan dan kendali pengolahan Data Pribadi.</p>

            <h2>PASAL 3 — DATA PRIBADI YANG DIKUMPULKAN</h2>
            <p>MoneyMate mengumpulkan Data Pribadi berikut:</p>

            <h3>a. Data Pribadi yang Diberikan Secara Langsung</h3>
            <ul>
                <li><strong>Data Identitas:</strong> Nama lengkap, alamat email, nomor telepon seluler;</li>
                <li><strong>Data Autentikasi:</strong> Kata sandi (disimpan dalam bentuk terenkripsi/hash), foto profil;</li>
                <li><strong>Data Demografis:</strong> Pekerjaan, negara, provinsi, kota/kabupaten, kecamatan;</li>
                <li><strong>Data Keuangan:</strong> Data pencatatan keuangan (pemasukan, pengeluaran, anggaran, tujuan finansial, saldo awal) yang diinput oleh Pengguna;</li>
                <li><strong>Data Transaksi Premium:</strong> Bukti pembayaran, nominal transaksi, status transaksi (untuk Pengguna yang berlangganan Premium).</li>
            </ul>

            <h3>b. Data Pribadi yang Dikumpulkan Secara Otomatis</h3>
            <ul>
                <li><strong>Data Perangkat:</strong> Jenis perangkat, sistem operasi, jenis browser, alamat IP;</li>
                <li><strong>Data Penggunaan:</strong> Riwayat login (waktu dan frekuensi), fitur yang digunakan, interaksi dengan notifikasi;</li>
                <li><strong>Data Cookies &amp; Teknologi Serupa:</strong> Cookie untuk autentikasi sesi dan preferensi pengguna;</li>
                <li><strong>Data Push Notification:</strong> Endpoint dan kunci enkripsi untuk pengiriman notifikasi push web.</li>
            </ul>

            <h3>c. Data Pribadi dari Pihak Ketiga</h3>
            <ul>
                <li><strong>Google OAuth:</strong> Nama, alamat email Google, dan foto profil (jika Pengguna memilih login dengan Google);</li>
                <li><strong>Penyedia Layanan Pembayaran:</strong> Informasi yang diperlukan untuk verifikasi pembayaran Premium.</li>
            </ul>

            <h2>PASAL 4 — SUMBER DATA PRIBADI</h2>
            <p>Data Pribadi dikumpulkan dari:</p>
            <ol>
                <li>Pengguna secara langsung pada saat pendaftaran, pengisian profil, dan penggunaan fitur Layanan;</li>
                <li>Sistem otomatis MoneyMate pada saat Pengguna mengakses atau berinteraksi dengan Layanan;</li>
                <li>Penyedia layanan pihak ketiga (Google, penyedia pembayaran) dengan persetujuan Pengguna;</li>
                <li>Sumber lain yang sah berdasarkan ketentuan peraturan perundang-undangan.</li>
            </ol>

            <h2>PASAL 5 — TUJUAN PENGOLAHAN</h2>
            <p>Data Pribadi Pengguna diolah untuk tujuan berikut:</p>
            <ol>
                <li><strong>Penyediaan Layanan:</strong> Memfasilitasi pendaftaran, autentikasi, dan penggunaan seluruh fitur MoneyMate;</li>
                <li><strong>Keamanan Akun:</strong> Verifikasi identitas, pemulihan akun, dan pencegahan penyalahgunaan;</li>
                <li><strong>Peningkatan Layanan:</strong> Analisis penggunaan untuk pengembangan dan peningkatan fitur;</li>
                <li><strong>Komunikasi:</strong> Mengirimkan notifikasi terkait Layanan, peringatan anggaran, pengingat pencatatan keuangan, dan informasi penting lainnya;</li>
                <li><strong>Transaksi Premium:</strong> Memproses pembayaran, verifikasi, dan pengelolaan langganan berbayar;</li>
                <li><strong>Kepatuhan Hukum:</strong> Memenuhi kewajiban hukum, perintah instansi pemerintah, atau proses hukum yang berlaku;</li>
                <li><strong>Laporan Keuangan:</strong> Menghasilkan laporan dan visualisasi data keuangan untuk keperluan pribadi Pengguna;</li>
                <li><strong>Push Notification:</strong> Mengirimkan notifikasi push web sesuai preferensi Pengguna.</li>
            </ol>

            <h2>PASAL 6 — DASAR HUKUM PENGOLAHAN</h2>
            <p>Pengolahan Data Pribadi didasarkan pada:</p>
            <ol>
                <li><strong>Persetujuan Subjek Data Pribadi (Pasal 7 ayat 1 UU PDP):</strong> Pengguna memberikan persetujuan melalui mekanisme checklist dan tombol "Terima &amp; Lanjutkan" pada saat onboarding;</li>
                <li><strong>Pelaksanaan Perjanjian (Pasal 7 ayat 1 huruf b UU PDP):</strong> Pengolahan yang diperlukan untuk memenuhi kewajiban berdasarkan <a href="{{ route('legal.agreement') }}">Perjanjian Pengguna</a>;</li>
                <li><strong>Kewajiban Hukum (Pasal 7 ayat 1 huruf c UU PDP):</strong> Pemenuhan kewajiban berdasarkan peraturan perundang-undangan;</li>
                <li><strong>Kepentingan Sah (Pasal 7 ayat 2 UU PDP):</strong> Untuk keamanan sistem dan pencegahan penipuan, dengan mempertimbangkan hak-hak Pengguna.</li>
            </ol>

            <h2>PASAL 7 — PIHAK YANG MENERIMA DATA</h2>
            <p>Data Pribadi dapat diungkapkan kepada pihak berikut:</p>
            <ol>
                <li><strong>Penyedia Layanan Infrastruktur:</strong> Penyedia server, database, dan layanan cloud hosting yang terikat perjanjian kerahasiaan;</li>
                <li><strong>Penyedia Autentikasi:</strong> Google LLC, sepanjang diperlukan untuk layanan login dengan Google;</li>
                <li><strong>Penyedia Layanan Notifikasi:</strong> Penyedia layanan push notification web;</li>
                <li><strong>Penyedia Layanan Pembayaran:</strong> Pihak yang terlibat dalam pemrosesan pembayaran Premium;</li>
                <li><strong>Instansi Pemerintah:</strong> Apabila diwajibkan berdasarkan peraturan perundang-undangan yang berlaku atau perintah sah dari instansi yang berwenang.</li>
            </ol>
            <p>MoneyMate tidak menjual, menyewakan, atau memperdagangkan Data Pribadi Pengguna kepada pihak mana pun.</p>

            <h2>PASAL 8 — TRANSFER DATA</h2>
            <p>Data Pribadi dapat dialihkan ke luar yurisdiksi Republik Indonesia sepanjang:</p>
            <ol>
                <li>Negara tujuan transfer memiliki tingkat perlindungan Data Pribadi yang setara atau memadai;</li>
                <li>Transfer dilakukan berdasarkan persetujuan Pengguna setelah diberitahu mengenai risiko transfer;</li>
                <li>Terdapat mekanisme perlindungan yang memadai, seperti perjanjian standar klausul kontraktual;</li>
                <li>Transfer memenuhi ketentuan sebagaimana diatur dalam Pasal 37–40 UU PDP.</li>
            </ol>

            <h2>PASAL 9 — PENYIMPANAN DAN RETENSI DATA</h2>
            <p>Data Pribadi disimpan sesuai dengan prinsip minimasi data dan retensi terbatas:</p>
            <ul>
                <li><strong>Data Akun &amp; Profil:</strong> Disimpan selama Akun aktif dan hingga 30 hari kalender setelah penghapusan Akun (periode grace) untuk keperluan pemulihan;</li>
                <li><strong>Data Keuangan:</strong> Disimpan selama Akun aktif dan dapat dihapus sesuai permintaan Pengguna;</li>
                <li><strong>Data Transaksi Premium:</strong> Disimpan minimal 5 (lima) tahun sesuai ketentuan perpajakan yang berlaku;</li>
                <li><strong>Data Log &amp; Keamanan:</strong> Disimpan selama 90 (sembilan puluh) hari kalender;</li>
                <li><strong>Data OTP:</strong> Disimpan selama 10 (sepuluh) menit dan dihapus otomatis setelah kadaluwarsa atau digunakan;</li>
                <li><strong>Data Riwayat Kata Sandi:</strong> Disimpan selama Akun aktif untuk mencegah penggunaan kata sandi yang sama berulang;</li>
                <li><strong>Data Push Subscription:</strong> Disimpan selama Pengguna tidak berhenti berlangganan (unsubscribe);</li>
                <li><strong>Data Persetujuan:</strong> Disimpan secara permanen sebagai bukti persetujuan Pengguna sesuai Pasal 13 UU PDP.</li>
            </ul>
            <p>Setelah masa retensi berakhir, Data Pribadi akan dihapus atau dianonimkan secara permanen, kecuali jika penyimpanan lebih lanjut diperlukan berdasarkan peraturan perundang-undangan.</p>

            <h2>PASAL 10 — KEAMANAN DATA</h2>
            <p>MoneyMate menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai, meliputi:</p>
            <ol>
                <li><strong>Enkripsi:</strong> Kata sandi disimpan menggunakan algoritma hashing (bcrypt/Argon2); komunikasi data menggunakan protokol HTTPS/TLS;</li>
                <li><strong>Kontrol Akses:</strong> Penerapan prinsip least privilege; autentikasi berlapis untuk akses data sensitif;</li>
                <li><strong>Pemantauan Keamanan:</strong> Pencatatan (logging) aktivitas sistem untuk deteksi anomali;</li>
                <li><strong>Manajemen Kerentanan:</strong> Pembaruan rutin terhadap dependensi perangkat lunak untuk mengatasi kerentanan keamanan;</li>
                <li><strong>Pelatihan:</strong> Penyediaan pemahaman terkait perlindungan Data Pribadi kepada pihak yang terlibat dalam pengolahan;</li>
                <li><strong>Backup:</strong> Pencadangan data secara berkala dengan enkripsi untuk pemulihan bencana;</li>
                <li><strong>Penanganan Insiden:</strong> Prosedur penanganan dan pelaporan insiden kebocoran Data Pribadi sesuai Pasal 64–66 UU PDP.</li>
            </ol>

            <h2>PASAL 11 — HAK SUBJEK DATA PRIBADI</h2>
            <p>Sesuai dengan UU PDP, Pengguna memiliki hak-hak berikut terhadap Data Pribadinya:</p>
            <ol>
                <li><strong>Hak untuk Mengakses (Pasal 8 UU PDP):</strong> Memperoleh salinan Data Pribadi yang disimpan oleh MoneyMate;</li>
                <li><strong>Hak untuk Memperbaiki (Pasal 9 UU PDP):</strong> Meminta perbaikan Data Pribadi yang tidak akurat atau tidak lengkap;</li>
                <li><strong>Hak untuk Memperbarui (Pasal 9 UU PDP):</strong> Memperbarui Data Pribadi yang telah berubah;</li>
                <li><strong>Hak untuk Menghapus (Pasal 10 UU PDP):</strong> Meminta penghapusan Data Pribadi dalam kondisi tertentu sebagaimana diatur dalam UU PDP;</li>
                <li><strong>Hak untuk Menghentikan Pengolahan (Pasal 11 UU PDP):</strong> Menghentikan pengolahan Data Pribadi yang melanggar hukum;</li>
                <li><strong>Hak untuk Menarik Persetujuan (Pasal 12 UU PDP):</strong> Mencabut persetujuan yang telah diberikan, dengan konsekuensi tertentu terhadap penggunaan Layanan;</li>
                <li><strong>Hak untuk Mengajukan Keberatan (Pasal 46 UU PDP):</strong> Mengajukan keberatan atas pengolahan Data Pribadi dalam kondisi tertentu;</li>
                <li><strong>Hak untuk Memperoleh Pemulihan (Pasal 68 UU PDP):</strong> Memperoleh pemulihan dalam bentuk ganti rugi apabila menderita kerugian akibat pelanggaran UU PDP;</li>
                <li><strong>Hak untuk Portabilitas (Pasal 10 ayat 3 UU PDP):</strong> Memperoleh dan memindahkan Data Pribadi ke Pengendali lain dalam format yang terstruktur dan dapat dibaca mesin.</li>
            </ol>
            <p>Untuk mengajukan permintaan terkait hak-hak di atas, Pengguna dapat menghubungi MoneyMate melalui informasi kontak yang tercantum dalam Kebijakan ini atau mengajukan permintaan melalui fitur penghapusan akun di dalam aplikasi.</p>

            <h2>PASAL 12 — COOKIE DAN TEKNOLOGI PELACAKAN</h2>
            <p>MoneyMate menggunakan cookie dan teknologi serupa untuk:</p>
            <ul>
                <li>Autentikasi sesi (session cookie);</li>
                <li>Menyimpan preferensi pengguna (theme, bahasa);</li>
                <li>Keamanan (proteksi CSRF);</li>
                <li>Analitik dasar penggunaan Layanan.</li>
            </ul>
            <p>Pengguna dapat mengatur preferensi cookie melalui pengaturan browser. Perlu diperhatikan bahwa menonaktifkan cookie tertentu dapat mempengaruhi fungsionalitas Layanan. MoneyMate tidak menggunakan cookie pihak ketiga untuk tujuan periklanan.</p>

            <h2>PASAL 13 — PERUBAHAN KEBIJAKAN</h2>
            <p>MoneyMate dapat memperbarui Kebijakan ini sewaktu-waktu. Perubahan akan diberitahukan melalui:</p>
            <ol>
                <li>Notifikasi in-app paling lambat 14 (empat belas) hari kalender sebelum perubahan berlaku;</li>
                <li>Email ke alamat yang terdaftar pada Akun Pengguna;</li>
                <li>Pembaruan tanggal "Berlaku Efektif" pada halaman Kebijakan ini.</li>
            </ol>
            <p>Penggunaan Layanan secara berkelanjutan setelah perubahan berlaku dianggap sebagai persetujuan terhadap Kebijakan yang diperbarui. Apabila Pengguna tidak menyetujui perubahan, Pengguna berhak menghapus Akun.</p>

            <h2>PASAL 14 — PENGADUAN</h2>
            <p>Pengguna dapat mengajukan pengaduan terkait pengolahan Data Pribadi melalui:</p>
            <ol>
                <li>Mekanisme pengaduan internal: melalui fitur di dalam aplikasi atau email ke <strong>support@moneymate.id</strong> dengan subjek "Pengaduan Data Pribadi";</li>
                <li>MoneyMate akan merespons pengaduan dalam jangka waktu paling lambat 14 (empat belas) hari kerja sebagaimana diatur dalam Pasal 51 UU PDP;</li>
                <li>Apabila pengaduan tidak diselesaikan secara memadai, Pengguna berhak mengajukan pengaduan kepada Lembaga Pengawas Data Pribadi sebagaimana diatur dalam UU PDP.</li>
            </ol>

            <h2>PASAL 15 — INFORMASI KONTAK</h2>
            <p>Untuk pertanyaan, permintaan, atau pengaduan terkait Kebijakan Privasi &amp; Pelindungan Data Pribadi ini, silakan hubungi:</p>
            <p>
                <strong>Pengendali Data Pribadi:</strong> MoneyMate ID<br>
                <strong>Email:</strong> support@moneymate.id<br>
                <strong>Waktu Respons:</strong> Senin–Jumat, pukul 09.00–17.00 WIB (hari kerja)
            </p>
        </div>

        {{-- Bottom Navigation --}}
        <div class="legal-page-bottom-nav d-flex flex-column flex-sm-row justify-content-between gap-2 pt-4 mt-4 border-top">
            <a href="{{ route('legal.agreement') }}" class="btn btn-outline-secondary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                Perjanjian Pengguna
            </a>
            <span></span>
        </div>

    </div>
</div>
@endsection