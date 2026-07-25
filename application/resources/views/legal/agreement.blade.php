<!-- resources/views/legal/agreement.blade.php -->
@extends('layouts.legal')

@section('title', 'Perjanjian Pengguna')

@section('content')
<div class="onboarding-content">
    <div class="onboarding-card">

        <div class="legal-document">
            <p class="doc-meta">
                Dokumen: Perjanjian Pengguna MoneyMate<br>
                Versi: 1.0 &middot; Berlaku Efektif: 1 Mei 2026<br>
                Pengelola: MoneyMate ID
            </p>

            <h2>PASAL 1 — PIHAK-PIHAK</h2>
            <p>Perjanjian ini ("Perjanjian") dibuat antara:</p>
            <ol>
                <li><strong>Pihak Pertama (Pengelola):</strong> MoneyMate ID, pengelola aplikasi pencatatan dan pengelolaan keuangan pribadi berbasis digital;</li>
                <li><strong>Pihak Kedua (Pengguna):</strong> Anda, individu yang mendaftar dan menggunakan Layanan MoneyMate, yang selanjutnya disebut "Pengguna".</li>
            </ol>

            <h2>PASAL 2 — RUANG LINGKUP</h2>
            <p>Perjanjian ini mengatur hak, kewajiban, dan tanggung jawab masing-masing Pihak dalam rangka penyediaan dan penggunaan Layanan MoneyMate. Perjanjian ini merupakan pelengkap dari Syarat dan Ketentuan Layanan yang telah disepakati bersama.</p>

            <h2>PASAL 3 — HAK PENGGUNA</h2>
            <p>Pengguna berhak untuk:</p>
            <ol>
                <li>Mengakses dan menggunakan seluruh fitur Layanan sesuai dengan jenis akun yang dimiliki (Dasar atau Premium);</li>
                <li>Mendapatkan akses terhadap data keuangan pribadi yang telah diinput ke dalam sistem;</li>
                <li>Mengunduh, mengekspor, atau meminta salinan data pribadi sesuai ketentuan yang berlaku;</li>
                <li>Memperbarui atau memperbaiki data pribadi yang tidak akurat melalui fitur yang tersedia;</li>
                <li>Menghapus Akun dan meminta penghapusan Data Pribadi sesuai ketentuan Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi;</li>
                <li>Menerima pemberitahuan atas setiap perubahan material terhadap Perjanjian ini;</li>
                <li>Mengajukan keberatan atau pengaduan terkait pengolahan Data Pribadi.</li>
            </ol>

            <h2>PASAL 4 — KEWAJIBAN PENGGUNA</h2>
            <p>Pengguna wajib untuk:</p>
            <ol>
                <li>Memberikan informasi yang benar, akurat, dan terkini pada saat pendaftaran dan selama penggunaan Layanan;</li>
                <li>Menjaga kerahasiaan kredensial akun dan bertanggung jawab atas segala aktivitas yang terjadi pada Akun;</li>
                <li>Tidak menggunakan Layanan untuk tujuan yang melanggar hukum yang berlaku di Indonesia;</li>
                <li>Tidak mengganggu, merusak, atau mencoba mengakses sistem secara tidak sah;</li>
                <li>Tidak menyebarkan, mengunggah, atau membagikan konten yang melanggar hak pihak lain;</li>
                <li>Mematuhi seluruh ketentuan yang berlaku dalam Syarat dan Ketentuan Layanan serta Kebijakan Privasi;</li>
                <li>Segera melaporkan kepada Pengelola apabila mengetahui adanya penggunaan Akun yang tidak sah;</li>
                <li>Tidak melakukan tindakan yang dapat menimbulkan kerugian bagi Pengelola atau Pengguna lain.</li>
            </ol>

            <h2>PASAL 5 — HAK PENGELOLA</h2>
            <p>Pengelola berhak untuk:</p>
            <ol>
                <li>Mengelola, memelihara, dan mengembangkan Layanan sesuai kebijakan yang ditetapkan;</li>
                <li>Memperbarui, mengubah, atau menambah fitur Layanan dengan pemberitahuan yang memadai;</li>
                <li>Menangguhkan atau menutup Akun yang melanggar ketentuan Perjanjian ini;</li>
                <li>Mengolah Data Pribadi sesuai dengan tujuan yang telah diinformasikan dalam Kebijakan Privasi;</li>
                <li>Mengirimkan notifikasi terkait Layanan melalui mekanisme yang tersedia (in-app, email, push notification);</li>
                <li>Mengambil langkah teknis dan hukum yang diperlukan untuk melindungi Layanan dari penyalahgunaan.</li>
            </ol>

            <h2>PASAL 6 — KEWAJIBAN PENGELOLA</h2>
            <p>Pengelola wajib untuk:</p>
            <ol>
                <li>Menyediakan Layanan yang layak dan berfungsi sebagaimana mestinya;</li>
                <li>Melindungi Data Pribadi Pengguna sesuai dengan ketentuan Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi dan peraturan pelaksananya;</li>
                <li>Menerapkan langkah-langkah keamanan teknis dan organisasi yang memadai untuk melindungi Data Pribadi dari akses tidak sah, pengungkapan, perubahan, atau penghancuran;</li>
                <li>Menyediakan mekanisme pengaduan yang dapat diakses oleh Pengguna;</li>
                <li>Merespons permintaan Pengguna terkait hak-hak atas Data Pribadi dalam jangka waktu yang wajar sesuai ketentuan peraturan perundang-undangan;</li>
                <li>Memberitahukan Pengguna apabila terjadi insiden kebocoran Data Pribadi sesuai ketentuan yang berlaku;</li>
                <li>Menyimpan Data Pribadi hanya selama diperlukan untuk tujuan pengolahan atau sesuai kewajiban hukum yang berlaku.</li>
            </ol>

            <h2>PASAL 7 — PENGOLAHAN DATA PRIBADI</h2>
            <p>Ketentuan terkait pengolahan Data Pribadi diatur secara lengkap dalam <a href="{{ route('legal.privacy') }}">Kebijakan Privasi &amp; Pelindungan Data Pribadi</a> yang merupakan bagian tidak terpisahkan dari Perjanjian ini. Dengan menyetujui Perjanjian ini, Pengguna juga menyetujui pengolahan Data Pribadi sebagaimana diatur dalam Kebijakan Privasi tersebut.</p>

            <h2>PASAL 8 — PEMBATASAN TANGGUNG JAWAB</h2>
            <ol>
                <li>Pengelola tidak bertanggung jawab atas kehilangan data yang disebabkan oleh kelalaian Pengguna dalam menjaga keamanan Akun.</li>
                <li>Pengelola tidak memberikan jaminan bahwa data yang ditampilkan dalam Layanan akurat secara absolut, mengingat data tersebut bergantung pada input Pengguna.</li>
                <li>Pengelola tidak bertanggung jawab atas kerugian yang timbul akibat keputusan keuangan yang dibuat berdasarkan informasi dalam Layanan.</li>
                <li>Total tanggung jawab Pengelola dalam segala keadaan tidak akan melebihi jumlah yang dibayarkan oleh Pengguna untuk berlangganan Premium dalam 12 (dua belas) bulan terakhir.</li>
            </ol>

            <h2>PASAL 9 — JAMINAN</h2>
            <p>Pengguna menjamin bahwa:</p>
            <ol>
                <li>Seluruh informasi yang diberikan pada saat pendaftaran dan penggunaan Layanan adalah benar dan akurat;</li>
                <li>Pengguna memiliki kapasitas hukum untuk mengikatkan diri dalam Perjanjian ini;</li>
                <li>Penggunaan Layanan tidak akan melanggar hak pihak ketiga manapun;</li>
                <li>Pengguna akan mematuhi seluruh peraturan perundang-undangan yang berlaku di Republik Indonesia.</li>
            </ol>

            <h2>PASAL 10 — PENGAKHIRAN</h2>
            <ol>
                <li>Perjanjian ini berlaku sejak Pengguna menyetujui dan berakhir ketika Akun dihapus atau ditutup.</li>
                <li>Pihak manapun dapat mengakhiri Perjanjian ini dengan pemberitahuan tertulis. Pengelola berhak mengakhiri Perjanjian secara sepihak apabila Pengguna melanggar ketentuan yang berlaku.</li>
                <li>Pengakhiran Perjanjian tidak menghapus kewajiban masing-masing Pihak yang telah timbul sebelumnya, termasuk kewajiban terkait retensi data.</li>
            </ol>

            <h2>PASAL 11 — HUKUM YANG BERLAKU</h2>
            <p>Perjanjian ini tunduk pada dan ditafsirkan berdasarkan hukum Negara Republik Indonesia, termasuk namun tidak terbatas pada Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi; Undang-Undang Nomor 11 Tahun 2008 tentang Informasi dan Transaksi Elektronik sebagaimana telah beberapa kali diubah, terakhir dengan Undang-Undang Nomor 1 Tahun 2024; dan Undang-Undang Nomor 8 Tahun 1999 tentang Perlindungan Konsumen.</p>

            <h2>PASAL 12 — LAIN-LAIN</h2>
            <ol>
                <li>Perjanjian ini dibuat dalam bahasa Indonesia dan diterjemahkan jika diperlukan, namun versi bahasa Indonesia yang berlaku sebagai acuan utama.</li>
                <li>Segala hal yang belum diatur dalam Perjanjian ini akan diselesaikan berdasarkan musyawarah mufakat Para Pihak.</li>
            </ol>
        </div>

        {{-- Bottom Navigation --}}
        <div class="legal-page-bottom-nav d-flex flex-column flex-sm-row justify-content-between gap-2 pt-4 mt-4 border-top">
            <a href="{{ route('legal.terms') }}" class="btn btn-outline-secondary btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                </svg>
                Syarat &amp; Ketentuan
            </a>
            <a href="{{ route('legal.privacy') }}" class="btn btn-outline-secondary btn-sm">
                Kebijakan Privasi
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="ms-1">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                </svg>
            </a>
        </div>

    </div>
</div>
@endsection