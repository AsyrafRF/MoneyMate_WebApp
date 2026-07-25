<!-- resources\views\components\content-terms.blade.php -->

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        prefix: 'tw-',
        corePlugins: { preflight: false },
        theme: {
            extend: {
                fontFamily: { inter: ['Inter', 'sans-serif'] }
            }
        }
    }
</script>
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<link href="{{ asset('css/auth/terms/content.css') }}" rel="stylesheet">
<style>
    /* ── Light-mode overrides for external CSS classes ── */
    .glass-light {
        background: rgba(255,255,255,.72);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(228,228,231,.6);
    }
    .article-card {
        background: #fff;
        border-left: 3px solid rgba(59,130,246,.35);
    }
    .legal-list {
        list-style: disc;
    }
    .legal-list li::marker {
        color: #a1a1aa;
        font-size: .65em;
    }
    .legal-table thead { background: #f9fafb; }
    .legal-table tbody tr:hover { background: #f9fafb; }
    .no-print { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
</style>
@endpush

<!-- ============================================================
     CONTENT COLUMN
     ============================================================ -->
<div class="tw-flex-1 tw-min-w-0 tw-max-w-3xl">

    <!-- ── Effective Date Banner ── -->
    <div data-aos="fade-up" class="glass-light tw-rounded-2xl tw-p-4 md:tw-p-5 tw-mb-10 tw-flex tw-items-start tw-gap-3.5">
        <div class="tw-w-9 tw-h-9 tw-rounded-xl tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
            <iconify-icon icon="lucide:calendar-check" width="18" style="color:#3b82f6"></iconify-icon>
        </div>
        <div>
            <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-1">Berlaku Efektif: 1 Mei 2026</div>
            <div class="tw-text-[12px] tw-text-zinc-500 tw-leading-relaxed">Seluruh dokumen di bawah ini berlaku efektif sejak tanggal tersebut dan mengikat semua Pengguna MoneyMate.</div>
        </div>
    </div>

    <!-- ============================================================
         DOKUMEN 1 — Syarat & Ketentuan Layanan
         ============================================================ -->
    <section id="dokumen-1" class="tw-scroll-mt-24 tw-mb-20">

        <!-- Doc Header -->
        <div data-aos="fade-up" class="tw-mb-10">
            <div class="tw-flex tw-items-center tw-gap-2.5 tw-mb-4">
                <span class="tw-inline-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-bg-blue-50 tw-text-blue-600 tw-text-xs tw-font-bold">01</span>
                <span class="tw-text-[10px] tw-font-bold tw-uppercase tw-tracking-[0.15em] tw-text-zinc-400">Dokumen 1</span>
            </div>
            <h2 class="tw-text-2xl md:tw-text-3xl tw-font-medium tw-tracking-tight tw-text-zinc-900 tw-mb-3">Syarat & Ketentuan Layanan</h2>
            <p class="tw-text-sm tw-text-zinc-500 tw-font-light tw-leading-relaxed">Mengatur hubungan antara Pengelola MoneyMate dan Pengguna dalam penggunaan seluruh layanan aplikasi.</p>
        </div>

        <!-- Metadata Card -->
        <div data-aos="fade-up" class="glass-light tw-rounded-xl tw-p-4 tw-mb-8 tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4 tw-text-[12px]">
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Versi</div>
                <div class="tw-text-zinc-800 tw-font-medium">{{ $version }}</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Efektif</div>
                <div class="tw-text-zinc-800 tw-font-medium">1 Mei 2026</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Pengelola</div>
                <div class="tw-text-zinc-800 tw-font-medium">MoneyMate ID</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Status</div>
                <div class="tw-text-emerald-600 tw-font-medium tw-flex tw-items-center tw-gap-1">
                    <span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-emerald-500 tw-inline-block"></span> Berlaku
                </div>
            </div>
        </div>

        <!-- Pasal 1 -->
        <article id="skt-pasal-1" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 1</span>
                <span class="tw-text-zinc-300">—</span>
                Ketentuan Umum
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">
                Syarat dan Ketentuan Layanan ini (<strong class="tw-text-zinc-800 tw-font-medium">"SKT"</strong>) mengatur hubungan antara Pengelola MoneyMate (<strong class="tw-text-zinc-800 tw-font-medium">"Pengelola"</strong>) dan Pengguna (<strong class="tw-text-zinc-800 tw-font-medium">"Anda"</strong>) dalam penggunaan aplikasi MoneyMate yang dapat diakses melalui platform digital.
            </p>
            <div class="tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-rounded-lg tw-p-3.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                <iconify-icon icon="lucide:info" width="14" style="color:#3b82f6" class="tw-mr-1 tw-align-[-2px]"></iconify-icon>
                Dengan menggunakan Layanan, Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat dengan SKT ini.
            </div>
        </article>

        <!-- Pasal 2 -->
        <article id="skt-pasal-2" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 2</span>
                <span class="tw-text-zinc-300">—</span>
                Definisi
            </h3>
            <div class="tw-space-y-3 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Layanan"</span>
                    <span>mencakup seluruh fitur yang disediakan oleh MoneyMate, termasuk namun tidak terbatas pada pencatatan keuangan, pengelolaan anggaran, visualisasi data keuangan, pengelolaan tujuan finansial, dan notifikasi.</span>
                </div>
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Pengguna"</span>
                    <span>adalah setiap individu yang telah mendaftar dan/atau menggunakan Layanan.</span>
                </div>
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Akun"</span>
                    <span>adalah identitas digital yang diberikan kepada Pengguna untuk mengakses Layanan.</span>
                </div>
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Data Pribadi"</span>
                    <span>adalah setiap data tentang individu yang teridentifikasi atau dapat diidentifikasi sebagaimana dimaksud dalam <strong class="tw-text-zinc-800 tw-font-medium">UU No. 27 Tahun 2022</strong> tentang Pelindungan Data Pribadi.</span>
                </div>
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Konten"</span>
                    <span>adalah segala informasi, data, teks, gambar, atau materi lain yang diunggah atau dimasukkan oleh Pengguna ke dalam Layanan.</span>
                </div>
                <div class="tw-flex tw-gap-3">
                    <span class="tw-text-blue-600 tw-font-medium tw-flex-shrink-0 tw-w-28 tw-text-right">"Premium"</span>
                    <span>merupakan fitur berbayar tambahan yang disediakan oleh MoneyMate dengan manfaat yang lebih luas.</span>
                </div>
            </div>
        </article>

        <!-- Pasal 3 -->
        <article id="skt-pasal-3" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 3</span>
                <span class="tw-text-zinc-300">—</span>
                Pendaftaran Akun
            </h3>
            <ol class="tw-space-y-2.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-list-decimal tw-list-outside tw-ml-4">
                <li>Anda wajib berusia minimal <strong class="tw-text-zinc-800 tw-font-medium">13 (tiga belas) tahun</strong> untuk mendaftar Akun. Jika Anda berusia di bawah 17 tahun dan belum memiliki kartu identitas resmi (KTP), Anda menyatakan bahwa pendaftaran ini telah diketahui dan disetujui oleh orang tua atau wali hukum Anda.</li>
                <li>Anda bertanggung jawab untuk memberikan informasi yang <strong class="tw-text-zinc-800 tw-font-medium">benar, akurat, dan terkini</strong> pada saat pendaftaran dan selama penggunaan Layanan.</li>
                <li>Setiap Akun hanya boleh digunakan oleh <strong class="tw-text-zinc-800 tw-font-medium">satu individu</strong>. Anda dilarang membuat atau menggunakan satu Akun untuk beberapa individu tanpa persetujuan tertulis dari Pengelola.</li>
                <li>Anda wajib menjaga kerahasiaan informasi akun, termasuk kata sandi, dan bertanggung jawab penuh atas segala aktivitas yang terjadi pada Akun Anda.</li>
                <li>Pengelola berhak menangguhkan atau menutup Akun yang diduga digunakan secara tidak sah.</li>
            </ol>
        </article>

        <!-- Pasal 4 -->
        <article id="skt-pasal-4" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 4</span>
                <span class="tw-text-zinc-300">—</span>
                Penggunaan Layanan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-4">
                Anda setuju untuk menggunakan Layanan hanya untuk tujuan yang sah dan sesuai dengan fungsi yang disediakan.
            </p>
            <div class="tw-bg-red-50 tw-border tw-border-red-200/60 tw-rounded-xl tw-p-4 tw-mb-4">
                <div class="tw-flex tw-items-center tw-gap-2 tw-mb-3">
                    <iconify-icon icon="lucide:alert-triangle" width="15" style="color:#ef4444"></iconify-icon>
                    <span class="tw-text-xs tw-font-semibold tw-text-red-600 tw-uppercase tw-tracking-wider">Aktivitas yang Dilarang</span>
                </div>
                <ul class="legal-list tw-space-y-2 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                    <li>Menggunakan Layanan untuk kegiatan yang melanggar hukum perdata atau pidana yang berlaku di Republik Indonesia;</li>
                    <li>Melakukan reverse engineering, dekompilasi, atau membongkar kode sumber aplikasi;</li>
                    <li>Mengganggu atau mencoba mengganggu operasional Layanan;</li>
                    <li>Menggunakan robot, spider, scraper, atau alat otomatis lainnya untuk mengakses Layanan;</li>
                    <li>Menyebarkan konten yang bersifat menyesatkan, memfitnah, atau melanggar hak kekayaan intelektual pihak lain;</li>
                    <li>Mencoba mengakses data Pengguna lain tanpa otorisasi.</li>
                </ul>
            </div>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                Pengelola berhak membatasi, menangguhkan, atau menghentikan akses Anda terhadap Layanan jika terjadi pelanggaran terhadap ketentuan ini.
            </p>
        </article>

        <!-- Pasal 5 -->
        <article id="skt-pasal-5" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 5</span>
                <span class="tw-text-zinc-300">—</span>
                Fitur Layanan
            </h3>
            <div class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-space-y-3 tw-mb-4">
                <p>MoneyMate menyediakan fitur:</p>
                <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-2 tw-ml-1">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-zinc-700">
                        <iconify-icon icon="lucide:pencil-line" width="14" style="color:#3b82f6"></iconify-icon>
                        <span class="tw-text-sm">Pencatatan keuangan pribadi</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-zinc-700">
                        <iconify-icon icon="lucide:pie-chart" width="14" style="color:#3b82f6"></iconify-icon>
                        <span class="tw-text-sm">Pengelolaan anggaran</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-zinc-700">
                        <iconify-icon icon="lucide:bar-chart-3" width="14" style="color:#3b82f6"></iconify-icon>
                        <span class="tw-text-sm">Visualisasi data</span>
                    </div>
                    <div class="tw-flex tw-items-center tw-gap-2 tw-text-zinc-700">
                        <iconify-icon icon="lucide:target" width="14" style="color:#3b82f6"></iconify-icon>
                        <span class="tw-text-sm">Pengelolaan tujuan finansial</span>
                    </div>
                </div>
            </div>
            <div class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-space-y-2">
                <p>Fitur <strong class="tw-text-zinc-800 tw-font-medium">Premium</strong> tersedia dengan berlangganan berbayar. Detail harga, durasi, dan manfaat Premium diatur dalam halaman terpisah yang merupakan bagian tidak terpisahkan dari SKT ini.</p>
                <p>Pengelola berhak mengubah, menambah, atau mengurangi fitur Layanan sewaktu-waktu dengan pemberitahuan yang memadai.</p>
            </div>
            <div class="tw-mt-4 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-rounded-lg tw-p-3.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-flex tw-items-start tw-gap-2.5">
                <iconify-icon icon="lucide:landmark" width="16" style="color:#71717a" class="tw-mt-0.5 tw-flex-shrink-0"></iconify-icon>
                <span>Layanan MoneyMate <strong class="tw-text-zinc-800 tw-font-medium">bukan</strong> merupakan layanan perbankan, investasi, atau lembaga keuangan. MoneyMate tidak menyimpan dana, memberikan bunga, atau melakukan transaksi keuangan atas nama Pengguna.</span>
            </div>
        </article>

        <!-- Pasal 6 -->
        <article id="skt-pasal-6" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 6</span>
                <span class="tw-text-zinc-300">—</span>
                Hak Kekayaan Intelektual
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">
                Seluruh hak kekayaan intelektual yang terkait dengan Layanan, termasuk namun tidak terbatas pada desain, logo, merek dagang, kode sumber, dan konten asli, merupakan milik Pengelola dan dilindungi oleh <strong class="tw-text-zinc-800 tw-font-medium">Undang-Undang Nomor 28 Tahun 2014</strong> tentang Hak Cipta serta peraturan pelaksananya.
            </p>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                Anda tidak diperkenankan mereproduksi, mendistribusikan, atau membuat karya turunan dari bagian mana pun dari Layanan tanpa izin tertulis dari Pengelola.
            </p>
        </article>

        <!-- Pasal 7 -->
        <article id="skt-pasal-7" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 7</span>
                <span class="tw-text-zinc-300">—</span>
                Batasan Tanggung Jawab
            </h3>
            <div class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-space-y-3">
                <p>Layanan disediakan <strong class="tw-text-zinc-800 tw-font-medium">"sebagaimana adanya" (as is)</strong> tanpa jaminan apapun, baik tersurat maupun tersirat.</p>
                <p>Pengelola tidak menjamin bahwa Layanan akan selalu tersedia, bebas dari kesalahan, atau aman dari ancaman pihak ketiga.</p>
                <p>Pengelola tidak bertanggung jawab atas:</p>
                <ul class="legal-list tw-space-y-1.5 tw-ml-4">
                    <li>Kerugian yang timbul dari ketidakakurasi data yang diinput oleh Pengguna;</li>
                    <li>Kegagalan Layanan yang disebabkan oleh faktor di luar kendali Pengelola (force majeure);</li>
                    <li>Kerugian tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan Layanan.</li>
                </ul>
            </div>
            <div class="tw-mt-4 tw-bg-amber-50 tw-border tw-border-amber-200/60 tw-rounded-lg tw-p-3.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-flex tw-items-start tw-gap-2.5">
                <iconify-icon icon="lucide:triangle-alert" width="16" style="color:#d97706" class="tw-mt-0.5 tw-flex-shrink-0"></iconify-icon>
                <span>Pengelola tidak bertanggung jawab atas keputusan keuangan yang dibuat oleh Pengguna berdasarkan data atau informasi yang ditampilkan dalam Layanan. <strong class="tw-text-zinc-800 tw-font-medium">Pengguna bertanggung jawab penuh atas keputusan keuangan mereka sendiri.</strong></span>
            </div>
        </article>

        <!-- Pasal 8 -->
        <article id="skt-pasal-8" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 8</span>
                <span class="tw-text-zinc-300">—</span>
                Modifikasi Layanan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">
                Pengelola berhak mengubah atau memodifikasi Layanan, termasuk SKT ini, sewaktu-waktu.
            </p>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-2">Perubahan material akan diberitahukan melalui:</p>
            <div class="tw-flex tw-flex-wrap tw-gap-2 tw-mb-3">
                <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-text-xs tw-text-zinc-700 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">
                    <iconify-icon icon="lucide:bell" width="12" style="color:#3b82f6"></iconify-icon> Notifikasi in-app
                </span>
                <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-text-xs tw-text-zinc-700 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">
                    <iconify-icon icon="lucide:mail" width="12" style="color:#3b82f6"></iconify-icon> Email
                </span>
            </div>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                paling lambat <strong class="tw-text-zinc-800 tw-font-medium">14 (empat belas) hari kalender</strong> sebelum berlaku efektif. Penggunaan Layanan secara berkelanjutan setelah perubahan berlaku dianggap sebagai persetujuan Anda terhadap perubahan tersebut.
            </p>
        </article>

        <!-- Pasal 9 -->
        <article id="skt-pasal-9" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 9</span>
                <span class="tw-text-zinc-300">—</span>
                Penghentian Akun
            </h3>
            <div class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-space-y-3">
                <p>Anda dapat menghentikan Akun kapan saja melalui fitur penghapusan akun yang tersedia di dalam Layanan, dengan mempertimbangkan periode retensi data sebagaimana diatur dalam Kebijakan Privasi.</p>
                <p>Pengelola berhak menangguhkan atau menghentikan Akun Anda jika:</p>
                <ul class="legal-list tw-space-y-1.5 tw-ml-4">
                    <li>Anda melanggar SKT ini;</li>
                    <li>Akun Anda digunakan untuk aktivitas yang mencurigakan atau melanggar hukum;</li>
                    <li>Diperintahkan oleh instansi yang berwenang berdasarkan peraturan perundang-undangan yang berlaku.</li>
                </ul>
            </div>
        </article>

        <!-- Pasal 10 -->
        <article id="skt-pasal-10" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 10</span>
                <span class="tw-text-zinc-300">—</span>
                Ganti Rugi
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                Anda setuju untuk membebaskan Pengelola, beserta direksi, karyawan, dan afiliasinya, dari segala tuntutan, klaim, kerugian, biaya (termasuk biaya hukum) yang timbul akibat pelanggaran Anda terhadap SKT ini atau penggunaan Layanan yang tidak sesuai ketentuan.
            </p>
        </article>

        <!-- Pasal 11 -->
        <article id="skt-pasal-11" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 11</span>
                <span class="tw-text-zinc-300">—</span>
                Force Majeure
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">
                Pengelola tidak bertanggung jawab atas keterlambatan atau kegagalan dalam menjalankan kewajibannya yang disebabkan oleh keadaan di luar kendali yang wajar:
            </p>
            <div class="tw-flex tw-flex-wrap tw-gap-2">
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Bencana alam</span>
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Perang</span>
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Pandemi</span>
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Kebijakan pemerintah</span>
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Gangguan telekomunikasi</span>
                <span class="tw-text-xs tw-text-zinc-600 tw-bg-zinc-100 tw-px-3 tw-py-1.5 tw-rounded-lg">Serangan siber</span>
            </div>
        </article>

        <!-- Pasal 12 -->
        <article id="skt-pasal-12" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 12</span>
                <span class="tw-text-zinc-300">—</span>
                Penyelesaian Sengketa
            </h3>
            <div class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-space-y-3">
                <div class="tw-flex tw-gap-3 tw-items-start">
                    <span class="tw-w-6 tw-h-6 tw-rounded-full tw-bg-zinc-100 tw-flex tw-items-center tw-justify-center tw-text-[10px] tw-font-bold tw-text-zinc-500 tw-flex-shrink-0 tw-mt-0.5">1</span>
                    <p>Para Pihak akan terlebih dahulu berupaya menyelesaikan secara <strong class="tw-text-zinc-800 tw-font-medium">musyawarah untuk mufakat</strong> dalam jangka waktu 30 (tiga puluh) hari kalender.</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start">
                    <span class="tw-w-6 tw-h-6 tw-rounded-full tw-bg-zinc-100 tw-flex tw-items-center tw-justify-center tw-text-[10px] tw-font-bold tw-text-zinc-500 tw-flex-shrink-0 tw-mt-0.5">2</span>
                    <p>Jika musyawarah tidak menghasilkan kesepakatan, sengketa akan diselesaikan melalui <strong class="tw-text-zinc-800 tw-font-medium">BPSK</strong> sesuai UU No. 8 Tahun 1999 tentang Perlindungan Konsumen.</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start">
                    <span class="tw-w-6 tw-h-6 tw-rounded-full tw-bg-zinc-100 tw-flex tw-items-center tw-justify-center tw-text-[10px] tw-font-bold tw-text-zinc-500 tw-flex-shrink-0 tw-mt-0.5">3</span>
                    <p>SKT ini tunduk pada <strong class="tw-text-zinc-800 tw-font-medium">hukum Negara Republik Indonesia</strong>.</p>
                </div>
            </div>
        </article>

        <!-- Pasal 13 -->
        <article id="skt-pasal-13" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 13</span>
                <span class="tw-text-zinc-300">—</span>
                Ketentuan Lain-lain
            </h3>
            <ul class="legal-list tw-space-y-2 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-ml-4">
                <li>Jika salah satu ketentuan dalam SKT ini dinyatakan tidak sah atau tidak dapat dilaksanakan, ketentuan lainnya tetap berlaku sepenuhnya.</li>
                <li>Kelalaian Pengelola dalam menegakkan suatu ketentuan tidak berarti Pengelola melepaskan haknya atas ketentuan tersebut.</li>
                <li>SKT ini merupakan perjanjian lengkap antara Anda dan Pengelola terkait penggunaan Layanan dan menggantikan seluruh kesepakatan sebelumnya.</li>
            </ul>
        </article>
    </section>

    <!-- ── Divider ── -->
    <div class="tw-relative tw-h-px tw-mb-20">
        <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-r tw-from-transparent tw-via-zinc-200 tw-to-transparent"></div>
        <div class="tw-absolute tw-left-1/2 tw-top-1/2 -tw-translate-x-1/2 -tw-translate-y-1/2 tw-w-8 tw-h-8 tw-rounded-full tw-bg-white tw-border tw-border-zinc-200 tw-flex tw-items-center tw-justify-center">
            <iconify-icon icon="lucide:chevron-down" width="14" style="color:#a1a1aa"></iconify-icon>
        </div>
    </div>

    <!-- ============================================================
         DOKUMEN 2 — Perjanjian Pengguna
         ============================================================ -->
    <section id="dokumen-2" class="tw-scroll-mt-24 tw-mb-20">

        <div data-aos="fade-up" class="tw-mb-10">
            <div class="tw-flex tw-items-center tw-gap-2.5 tw-mb-4">
                <span class="tw-inline-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-bg-blue-50 tw-text-blue-600 tw-text-xs tw-font-bold">02</span>
                <span class="tw-text-[10px] tw-font-bold tw-uppercase tw-tracking-[0.15em] tw-text-zinc-400">Dokumen 2</span>
            </div>
            <h2 class="tw-text-2xl md:tw-text-3xl tw-font-medium tw-tracking-tight tw-text-zinc-900 tw-mb-3">Perjanjian Pengguna</h2>
            <p class="tw-text-sm tw-text-zinc-500 tw-font-light tw-leading-relaxed">Mengatur hak, kewajiban, dan tanggung jawab masing-masing pihak dalam penyediaan dan penggunaan Layanan.</p>
        </div>

        <!-- Metadata -->
        <div data-aos="fade-up" class="glass-light tw-rounded-xl tw-p-4 tw-mb-8 tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4 tw-text-[12px]">
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Versi</div>
                <div class="tw-text-zinc-800 tw-font-medium">{{ $version }}</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Efektif</div>
                <div class="tw-text-zinc-800 tw-font-medium">1 Mei 2026</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Pengelola</div>
                <div class="tw-text-zinc-800 tw-font-medium">MoneyMate ID</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Status</div>
                <div class="tw-text-emerald-600 tw-font-medium tw-flex tw-items-center tw-gap-1">
                    <span class="tw-w-1.5 tw-h-1.5 tw-rounded-full tw-bg-emerald-500 tw-inline-block"></span> Berlaku
                </div>
            </div>
        </div>

        <!-- Pasal 1 — Pihak -->
        <article id="pp-pasal-1" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 1</span>
                <span class="tw-text-zinc-300">—</span>
                Pihak-pihak
            </h3>
            <div class="tw-grid md:tw-grid-cols-2 tw-gap-4">
                <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4 tw-border tw-border-zinc-200/60">
                    <div class="tw-text-[10px] tw-font-bold tw-uppercase tw-tracking-widest tw-text-blue-600 tw-mb-2">Pihak Pertama</div>
                    <div class="tw-text-sm tw-font-semibold tw-text-zinc-900 tw-mb-1">Pengelola</div>
                    <div class="tw-text-xs tw-text-zinc-500 tw-font-light tw-leading-relaxed">MoneyMate ID, pengelola aplikasi pencatatan dan pengelolaan keuangan pribadi berbasis digital.</div>
                </div>
                <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4 tw-border tw-border-zinc-200/60">
                    <div class="tw-text-[10px] tw-font-bold tw-uppercase tw-tracking-widest tw-text-blue-600 tw-mb-2">Pihak Kedua</div>
                    <div class="tw-text-sm tw-font-semibold tw-text-zinc-900 tw-mb-1">Pengguna</div>
                    <div class="tw-text-xs tw-text-zinc-500 tw-font-light tw-leading-relaxed">Anda, individu yang mendaftar dan menggunakan Layanan MoneyMate.</div>
                </div>
            </div>
        </article>

        <!-- Pasal 2 -->
        <article id="pp-pasal-2" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 2</span>
                <span class="tw-text-zinc-300">—</span>
                Ruang Lingkup
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                Perjanjian ini mengatur hak, kewajiban, dan tanggung jawab masing-masing Pihak dalam rangka penyediaan dan penggunaan Layanan MoneyMate. Perjanjian ini merupakan <strong class="tw-text-zinc-800 tw-font-medium">pelengkap</strong> dari Syarat dan Ketentuan Layanan yang telah disepakati bersama.
            </p>
        </article>

        <!-- Pasal 3 -->
        <article id="pp-pasal-3" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 3</span>
                <span class="tw-text-zinc-300">—</span>
                Hak Pengguna
            </h3>
            <div class="tw-space-y-2.5">
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:layout-dashboard" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Mengakses dan menggunakan seluruh fitur Layanan sesuai jenis akun (Dasar atau Premium);</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:database" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Mendapatkan akses terhadap data keuangan pribadi yang telah diinput ke dalam sistem;</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:download" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Mengunduh, mengekspor, atau meminta salinan data pribadi sesuai ketentuan yang berlaku;</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:pencil" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Memperbarui atau memperbaiki data pribadi yang tidak akurat melalui fitur yang tersedia;</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:trash-2" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Menghapus Akun dan meminta penghapusan Data Pribadi sesuai ketentuan UU PDP;</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:bell-ring" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Menerima pemberitahuan atas setiap perubahan material terhadap Perjanjian ini;</p>
                </div>
                <div class="tw-flex tw-gap-3 tw-items-start tw-p-3 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-blue-50 tw-flex tw-items-center tw-justify-center tw-flex-shrink-0 tw-mt-0.5">
                        <iconify-icon icon="lucide:message-square-warning" width="13" style="color:#3b82f6"></iconify-icon>
                    </div>
                    <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">Mengajukan keberatan atau pengaduan terkait pengolahan Data Pribadi.</p>
                </div>
            </div>
        </article>
    </section>

    <!-- ── Divider ── -->
    <div class="tw-relative tw-h-px tw-mb-20">
        <div class="tw-absolute tw-inset-0 tw-bg-gradient-to-r tw-from-transparent tw-via-zinc-200 tw-to-transparent"></div>
        <div class="tw-absolute tw-left-1/2 tw-top-1/2 -tw-translate-x-1/2 -tw-translate-y-1/2 tw-w-8 tw-h-8 tw-rounded-full tw-bg-white tw-border tw-border-zinc-200 tw-flex tw-items-center tw-justify-center">
            <iconify-icon icon="lucide:chevron-down" width="14" style="color:#a1a1aa"></iconify-icon>
        </div>
    </div>

    <!-- ============================================================
         DOKUMEN 3 — Kebijakan Privasi
         ============================================================ -->
    <section id="dokumen-3" class="tw-scroll-mt-24 tw-mb-20">

        <div data-aos="fade-up" class="tw-mb-10">
            <div class="tw-flex tw-items-center tw-gap-2.5 tw-mb-4">
                <span class="tw-inline-flex tw-items-center tw-justify-center tw-w-8 tw-h-8 tw-rounded-lg tw-bg-blue-50 tw-text-blue-600 tw-text-xs tw-font-bold">03</span>
                <span class="tw-text-[10px] tw-font-bold tw-uppercase tw-tracking-[0.15em] tw-text-zinc-400">Dokumen 3</span>
            </div>
            <h2 class="tw-text-2xl md:tw-text-3xl tw-font-medium tw-tracking-tight tw-text-zinc-900 tw-mb-3">Kebijakan Privasi & Pelindungan Data Pribadi</h2>
            <p class="tw-text-sm tw-text-zinc-500 tw-font-light tw-leading-relaxed">Menjelaskan bagaimana MoneyMate mengumpulkan, menggunakan, menyimpan, mengungkapkan, dan melindungi Data Pribadi Pengguna.</p>
        </div>

        <!-- Metadata -->
        <div data-aos="fade-up" class="glass-light tw-rounded-xl tw-p-4 tw-mb-8 tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-4 tw-text-[12px]">
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Versi</div>
                <div class="tw-text-zinc-800 tw-font-medium">{{ $version }}</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Efektif</div>
                <div class="tw-text-zinc-800 tw-font-medium">1 Mei 2026</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Dasar Hukum</div>
                <div class="tw-text-zinc-800 tw-font-medium">UU PDP No. 27/2022</div>
            </div>
            <div>
                <div class="tw-text-zinc-400 tw-mb-0.5">Pengendali Data</div>
                <div class="tw-text-zinc-800 tw-font-medium">MoneyMate ID</div>
            </div>
        </div>

        <!-- Pasal 1 -->
        <article id="kp-pasal-1" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 1</span>
                <span class="tw-text-zinc-300">—</span>
                Pendahuluan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">MoneyMate berkomitmen untuk melindungi Data Pribadi Pengguna. Kebijakan ini menjelaskan bagaimana MoneyMate:</p>
            <div class="tw-flex tw-flex-wrap tw-gap-2">
                <span class="tw-text-xs tw-text-zinc-700 tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-px-3 tw-py-1.5 tw-rounded-lg">Mengumpulkan</span>
                <span class="tw-text-xs tw-text-zinc-700 tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-px-3 tw-py-1.5 tw-rounded-lg">Menggunakan</span>
                <span class="tw-text-xs tw-text-zinc-700 tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-px-3 tw-py-1.5 tw-rounded-lg">Menyimpan</span>
                <span class="tw-text-xs tw-text-zinc-700 tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-px-3 tw-py-1.5 tw-rounded-lg">Mengungkapkan</span>
                <span class="tw-text-xs tw-text-zinc-700 tw-bg-blue-50 tw-border tw-border-blue-200/60 tw-px-3 tw-py-1.5 tw-rounded-lg">Melindungi</span>
            </div>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mt-3">Data Pribadi Pengguna sesuai dengan ketentuan UU PDP.</p>
        </article>

        <!-- Pasal 2 -->
        <article id="kp-pasal-2" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 2</span>
                <span class="tw-text-zinc-300">—</span>
                Identitas Pengelola Data Pribadi
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed">
                Dalam konteks Kebijakan ini, <strong class="tw-text-zinc-800 tw-font-medium">MoneyMate ID</strong> bertindak sebagai <strong class="tw-text-zinc-800 tw-font-medium">Pengendali Data Pribadi</strong> sebagaimana dimaksud dalam UU PDP. Pengendali Data Pribadi bertanggung jawab atas penentuan tujuan dan kendali pengolahan Data Pribadi.
            </p>
        </article>

        <!-- Pasal 3 -->
        <article id="kp-pasal-3" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 3</span>
                <span class="tw-text-zinc-300">—</span>
                Data Pribadi yang Dikumpulkan
            </h3>

            <!-- 3a — Langsung -->
            <div class="tw-mb-5">
                <h4 class="tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wider tw-text-blue-600 tw-mb-3">a. Data yang Diberikan Secara Langsung</h4>
                <div class="tw-space-y-4">
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:user" width="13" style="color:#3b82f6"></iconify-icon> Data Identitas
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Nama lengkap</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Alamat email</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Nomor telepon</span>
                        </div>
                    </div>
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:key-round" width="13" style="color:#3b82f6"></iconify-icon> Data Autentikasi
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Kata sandi (terenkripsi)</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Foto profil</span>
                        </div>
                    </div>
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:map-pin" width="13" style="color:#3b82f6"></iconify-icon> Data Demografis
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Pekerjaan</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Negara</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Provinsi</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Kota/Kabupaten</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Kecamatan</span>
                        </div>
                    </div>
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:wallet" width="13" style="color:#3b82f6"></iconify-icon> Data Keuangan
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Pemasukan</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Pengeluaran</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Anggaran</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Tujuan finansial</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Saldo awal</span>
                        </div>
                    </div>
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:credit-card" width="13" style="color:#3b82f6"></iconify-icon> Data Transaksi Premium
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Bukti pembayaran</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Nominal transaksi</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Status transaksi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3b — Otomatis -->
            <div class="tw-mb-5">
                <h4 class="tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wider tw-text-blue-600 tw-mb-3">b. Data yang Dikumpulkan Secara Otomatis</h4>
                <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Jenis perangkat</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Sistem operasi</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Jenis browser</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Alamat IP</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Riwayat login</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Interaksi fitur</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Cookie</span>
                    <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Push notification endpoint</span>
                </div>
            </div>

            <!-- 3c — Pihak Ketiga -->
            <div>
                <h4 class="tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wider tw-text-blue-600 tw-mb-3">c. Data dari Pihak Ketiga</h4>
                <div class="tw-grid sm:tw-grid-cols-2 tw-gap-3">
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="logos:google-icon" width="13"></iconify-icon> Google OAuth
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Nama</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Email Google</span>
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Foto profil</span>
                        </div>
                    </div>
                    <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4">
                        <div class="tw-text-xs tw-font-semibold tw-text-zinc-800 tw-mb-2 tw-flex tw-items-center tw-gap-2">
                            <iconify-icon icon="lucide:building-2" width="13" style="color:#3b82f6"></iconify-icon> Penyedia Pembayaran
                        </div>
                        <div class="tw-flex tw-flex-wrap tw-gap-1.5">
                            <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-white tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Info verifikasi pembayaran</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Pasal 4 -->
        <article id="kp-pasal-4" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 4</span>
                <span class="tw-text-zinc-300">—</span>
                Sumber Data Pribadi
            </h3>
            <ul class="legal-list tw-space-y-1.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-ml-4">
                <li>Pengguna secara langsung;</li>
                <li>Sistem otomatis MoneyMate;</li>
                <li>Penyedia layanan pihak ketiga;</li>
                <li>Sumber lain yang sah berdasarkan hukum.</li>
            </ul>
        </article>

        <!-- Pasal 5 -->
        <article id="kp-pasal-5" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 5</span>
                <span class="tw-text-zinc-300">—</span>
                Tujuan Pengolahan
            </h3>
            <div class="tw-grid sm:tw-grid-cols-2 tw-gap-2">
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Penyediaan layanan</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Keamanan akun</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Peningkatan layanan</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Komunikasi & notifikasi</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Transaksi Premium</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Kepatuhan hukum</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Laporan keuangan</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg hover:tw-bg-zinc-50 tw-transition-colors">
                    <iconify-icon icon="lucide:check-circle-2" width="15" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Push notification</span>
                </div>
            </div>
        </article>

        <!-- Pasal 6 -->
        <article id="kp-pasal-6" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 6</span>
                <span class="tw-text-zinc-300">—</span>
                Dasar Hukum Pengolahan
            </h3>
            <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-4 tw-gap-3">
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:check-check" width="20" style="color:#3b82f6" class="tw-mb-1.5"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-700 tw-font-medium">Persetujuan</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:file-signature" width="20" style="color:#3b82f6" class="tw-mb-1.5"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-700 tw-font-medium">Perjanjian</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:scale" width="20" style="color:#3b82f6" class="tw-mb-1.5"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-700 tw-font-medium">Kewajiban Hukum</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:shield" width="20" style="color:#3b82f6" class="tw-mb-1.5"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-700 tw-font-medium">Kepentingan Sah</div>
                </div>
            </div>
        </article>

        <!-- Pasal 7 -->
        <article id="kp-pasal-7" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 7</span>
                <span class="tw-text-zinc-300">—</span>
                Pihak yang Menerima Data
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">Data Pribadi dapat diungkapkan kepada:</p>
            <ul class="legal-list tw-space-y-1.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-ml-4 tw-mb-4">
                <li>Penyedia infrastruktur;</li>
                <li>Google LLC;</li>
                <li>Penyedia notifikasi;</li>
                <li>Penyedia pembayaran;</li>
                <li>Instansi pemerintah.</li>
            </ul>
            <div class="tw-bg-emerald-50 tw-border tw-border-emerald-200/60 tw-rounded-lg tw-p-3.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-flex tw-items-start tw-gap-2.5">
                <iconify-icon icon="lucide:shield-check" width="16" style="color:#059669" class="tw-mt-0.5 tw-flex-shrink-0"></iconify-icon>
                <span>MoneyMate <strong class="tw-text-zinc-800 tw-font-medium">tidak menjual atau memperdagangkan</strong> Data Pribadi Pengguna.</span>
            </div>
        </article>

        <!-- Pasal 8 -->
        <article id="kp-pasal-8" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 8</span>
                <span class="tw-text-zinc-300">—</span>
                Transfer Data
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">Transfer data ke luar Indonesia dilakukan apabila:</p>
            <ul class="legal-list tw-space-y-1.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-ml-4">
                <li>Negara tujuan memiliki perlindungan memadai;</li>
                <li>Terdapat persetujuan pengguna;</li>
                <li>Terdapat mekanisme perlindungan yang sesuai;</li>
                <li>Sesuai UU PDP.</li>
            </ul>
        </article>

        <!-- Pasal 9 -->
        <article id="kp-pasal-9" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 9</span>
                <span class="tw-text-zinc-300">—</span>
                Penyimpanan dan Retensi Data
            </h3>
            <div class="tw-overflow-x-auto -tw-mx-1">
                <table class="legal-table tw-w-full tw-text-sm tw-border tw-border-zinc-200/60 tw-rounded-xl tw-overflow-hidden">
                    <thead>
                        <tr>
                            <th class="tw-text-left tw-px-4 tw-py-2.5 tw-text-xs tw-font-semibold tw-text-zinc-700 tw-uppercase tw-tracking-wider">Jenis Data</th>
                            <th class="tw-text-left tw-px-4 tw-py-2.5 tw-text-xs tw-font-semibold tw-text-zinc-700 tw-uppercase tw-tracking-wider">Masa Retensi</th>
                        </tr>
                    </thead>
                    <tbody class="tw-text-zinc-600 tw-font-light">
                        <tr class="tw-border-t tw-border-zinc-100">
                            <td class="tw-px-4 tw-py-2.5">Data Akun & Profil</td>
                            <td class="tw-px-4 tw-py-2.5">Selama akun aktif + 30 hari</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100 tw-bg-zinc-50/50">
                            <td class="tw-px-4 tw-py-2.5">Data Keuangan</td>
                            <td class="tw-px-4 tw-py-2.5">Selama akun aktif</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100">
                            <td class="tw-px-4 tw-py-2.5">Data Premium</td>
                            <td class="tw-px-4 tw-py-2.5 tw-text-blue-600 tw-font-medium">Minimal 5 tahun</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100 tw-bg-zinc-50/50">
                            <td class="tw-px-4 tw-py-2.5">Log & Keamanan</td>
                            <td class="tw-px-4 tw-py-2.5">90 hari</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100">
                            <td class="tw-px-4 tw-py-2.5">OTP</td>
                            <td class="tw-px-4 tw-py-2.5">10 menit</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100 tw-bg-zinc-50/50">
                            <td class="tw-px-4 tw-py-2.5">Riwayat Password</td>
                            <td class="tw-px-4 tw-py-2.5">Selama akun aktif</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100">
                            <td class="tw-px-4 tw-py-2.5">Push Subscription</td>
                            <td class="tw-px-4 tw-py-2.5">Sampai unsubscribe</td>
                        </tr>
                        <tr class="tw-border-t tw-border-zinc-100 tw-bg-zinc-50/50">
                            <td class="tw-px-4 tw-py-2.5">Data Persetujuan</td>
                            <td class="tw-px-4 tw-py-2.5 tw-text-emerald-600 tw-font-medium">Permanen</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>

        <!-- Pasal 10 -->
        <article id="kp-pasal-10" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 10</span>
                <span class="tw-text-zinc-300">—</span>
                Keamanan Data
            </h3>
            <div class="tw-grid sm:tw-grid-cols-2 tw-gap-2.5">
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:lock" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Enkripsi HTTPS/TLS</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:hash" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Hashing bcrypt/Argon2</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:toggle-right" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Kontrol akses</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:file-text" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Logging keamanan</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:refresh-cw" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Patch & pembaruan rutin</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60">
                    <iconify-icon icon="lucide:hard-drive" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Backup terenkripsi</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5 tw-p-2.5 tw-rounded-lg tw-bg-zinc-50 tw-border tw-border-zinc-200/60 sm:tw-col-span-2">
                    <iconify-icon icon="lucide:siren" width="14" style="color:#3b82f6" class="tw-flex-shrink-0"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600 tw-font-light">Penanganan insiden kebocoran data</span>
                </div>
            </div>
        </article>

        <!-- Pasal 11 -->
        <article id="kp-pasal-11" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-4 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 11</span>
                <span class="tw-text-zinc-300">—</span>
                Hak Subjek Data Pribadi
            </h3>
            <div class="tw-grid tw-grid-cols-3 tw-gap-2.5">
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:eye" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Mengakses</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:wrench" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Memperbaiki</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:refresh-cw" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Memperbarui</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:trash-2" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Menghapus</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:pause-circle" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Menghentikan</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:x-circle" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Menarik persetujuan</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:hand" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Mengajukan keberatan</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:heart-pulse" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Pemulihan</div>
                </div>
                <div class="tw-text-center tw-p-3 tw-rounded-xl tw-bg-zinc-50 tw-border tw-border-zinc-200/60 hover:tw-border-blue-200 hover:tw-bg-blue-50/50 tw-transition-colors">
                    <iconify-icon icon="lucide:arrow-left-right" width="18" style="color:#3b82f6" class="tw-mb-1"></iconify-icon>
                    <div class="tw-text-[11px] tw-text-zinc-600">Portabilitas</div>
                </div>
            </div>
        </article>

        <!-- Pasal 12 -->
        <article id="kp-pasal-12" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 12</span>
                <span class="tw-text-zinc-300">—</span>
                Cookie dan Teknologi Pelacakan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">MoneyMate menggunakan cookie untuk:</p>
            <div class="tw-flex tw-flex-wrap tw-gap-1.5 tw-mb-4">
                <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Autentikasi sesi</span>
                <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Preferensi pengguna</span>
                <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Keamanan</span>
                <span class="tw-text-[11px] tw-text-zinc-600 tw-bg-zinc-50 tw-border tw-border-zinc-200/60 tw-px-2.5 tw-py-1 tw-rounded-md">Analitik dasar</span>
            </div>
            <div class="tw-bg-emerald-50 tw-border tw-border-emerald-200/60 tw-rounded-lg tw-p-3.5 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-flex tw-items-start tw-gap-2.5">
                <iconify-icon icon="lucide:shield-check" width="16" style="color:#059669" class="tw-mt-0.5 tw-flex-shrink-0"></iconify-icon>
                <span>MoneyMate <strong class="tw-text-zinc-800 tw-font-medium">tidak menggunakan cookie pihak ketiga</strong> untuk iklan.</span>
            </div>
        </article>

        <!-- Pasal 13 -->
        <article id="kp-pasal-13" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 13</span>
                <span class="tw-text-zinc-300">—</span>
                Perubahan Kebijakan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">Perubahan Kebijakan akan diberitahukan melalui:</p>
            <ol class="tw-space-y-1.5 tw-ml-4 tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-list-decimal tw-list-outside">
                <li>Notifikasi in-app;</li>
                <li>Email;</li>
                <li>Pembaruan tanggal efektif.</li>
            </ol>
        </article>

        <!-- Pasal 14 -->
        <article id="kp-pasal-14" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 14</span>
                <span class="tw-text-zinc-300">—</span>
                Pengaduan
            </h3>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mb-3">Pengguna dapat mengajukan pengaduan melalui:</p>
            <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4 tw-border tw-border-zinc-200/60">
                <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                    <iconify-icon icon="lucide:mail" width="14" style="color:#3b82f6"></iconify-icon>
                    <span class="tw-text-sm tw-font-medium tw-text-zinc-900">support@moneymate.id</span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2">
                    <iconify-icon icon="lucide:tag" width="14" style="color:#3b82f6"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600">Subjek: <strong class="tw-text-zinc-800 tw-font-medium">Pengaduan Data Pribadi</strong></span>
                </div>
            </div>
            <p class="tw-text-sm tw-text-zinc-600 tw-font-light tw-leading-relaxed tw-mt-3">
                MoneyMate akan merespons paling lambat <strong class="tw-text-zinc-800 tw-font-medium">14 hari kerja</strong>.
            </p>
        </article>

        <!-- Pasal 15 -->
        <article id="kp-pasal-15" data-aos="fade-up" class="article-card tw-rounded-r-xl tw-p-5 md:tw-p-6 tw-mb-4">
            <h3 class="tw-text-base tw-font-semibold tw-tracking-tight tw-text-zinc-900 tw-mb-3 tw-flex tw-items-center tw-gap-2">
                <span class="tw-text-blue-500 tw-text-xs tw-font-mono">PASAL 15</span>
                <span class="tw-text-zinc-300">—</span>
                Informasi Kontak
            </h3>
            <div class="tw-bg-zinc-50 tw-rounded-xl tw-p-4 tw-border tw-border-zinc-200/60 tw-space-y-2">
                <div class="tw-flex tw-items-center tw-gap-2.5">
                    <iconify-icon icon="lucide:building-2" width="14" style="color:#3b82f6"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600">Pengendali Data Pribadi: <strong class="tw-text-zinc-900 tw-font-medium">MoneyMate ID</strong></span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5">
                    <iconify-icon icon="lucide:mail" width="14" style="color:#3b82f6"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600">Email: <strong class="tw-text-zinc-900 tw-font-medium">support@moneymate.id</strong></span>
                </div>
                <div class="tw-flex tw-items-center tw-gap-2.5">
                    <iconify-icon icon="lucide:clock" width="14" style="color:#3b82f6"></iconify-icon>
                    <span class="tw-text-sm tw-text-zinc-600">Waktu Respons: <strong class="tw-text-zinc-900 tw-font-medium">Senin–Jumat, 09.00–17.00 WIB</strong></span>
                </div>
            </div>
        </article>
    </section>

</div>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="tw-border-t tw-border-zinc-200 tw-bg-white tw-mt-16">
    <div class="tw-max-w-6xl tw-mx-auto tw-px-6 tw-py-10 tw-flex tw-flex-col md:tw-flex-row tw-items-center tw-justify-between tw-gap-4">
        <div class="tw-flex tw-items-center tw-gap-2.5">
            <div class="tw-w-6 tw-h-6 tw-rounded-md tw-bg-gradient-to-br tw-from-blue-400 tw-to-blue-500 tw-flex tw-items-center tw-justify-center">
                <img src="{{ asset('images/moneymate-white-notext.png') }}" alt="MoneyMate Logo" class="tw-w-full tw-h-full tw-object-contain">
            </div>
            <span class="tw-text-xs tw-font-medium tw-text-zinc-500">MoneyMate ID</span>
        </div>
        <div class="tw-text-[11px] tw-text-zinc-400 tw-text-center">
            © {{ date('Y') }} MoneyMate ID. Seluruh hak cipta dilindungi undang-undang. Versi {{ $version }}.
        </div>
        <div class="tw-flex tw-items-center tw-gap-4">
            <a href="#dokumen-1" class="tw-text-[11px] tw-text-zinc-400 hover:tw-text-blue-600 tw-transition-colors">SKT</a>
            <a href="#dokumen-2" class="tw-text-[11px] tw-text-zinc-400 hover:tw-text-blue-600 tw-transition-colors">Perjanjian</a>
            <a href="#dokumen-3" class="tw-text-[11px] tw-text-zinc-400 hover:tw-text-blue-600 tw-transition-colors">Privasi</a>
        </div>
    </div>
</footer>