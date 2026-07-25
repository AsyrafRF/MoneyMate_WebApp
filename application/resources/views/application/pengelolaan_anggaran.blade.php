@extends('layouts.app')

@section('title', 'Pengelolaan Anggaran')

@push('styles')
<link href="{{ asset('css/app/anggaran-style.css?v=2') }}" rel="stylesheet">
<link href="{{ asset('css/app/summary-card.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/filter-periode.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class="content">
    {{-- ✅ Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ⚠️ Pesan Peringatan --}}
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria="Close"></button>
        </div>
    @endif

    {{-- ❌ Pesan Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria="Close"></button>
        </div>
    @endif

    {{-- 💡 Alert Notifikasi Batas Anggaran --}}
    @php
        $totalAnggaran = $anggarans->sum(fn($item) => $item->tampilan['jumlah_anggaran_tampilan']);
        $totalTerpakai = $anggarans->sum(fn($item) => $item->tampilan['nominal_yang_terpakai']);
        $totalSisa = $anggarans->sum(fn($item) => $item->tampilan['sisa_anggaran_tampilan']);
        $persentaseTotal = min(round(($totalTerpakai / max($totalAnggaran,1)) * 100, 1), 999);
    @endphp

    @if($totalTerpakai > $totalAnggaran)
        @php
            $kelebihanPersen = $persentaseTotal - 100;
            $saranNaik = ceil($kelebihanPersen / 10) * 10; // contoh saran naik 10% tiap 10% kelebihan
            $nominalSaranNaik = ($saranNaik / 100) * $totalAnggaran;
            $tips = [
                'Coba kurangi pengeluaran kecil yang tidak penting.',
                'Tinjau kembali kebutuhan rutin yang bisa dikurangi.',
                'Gunakan catatan harian keuangan untuk memantau pengeluaran.',
                'Prioritaskan kebutuhan utama dibanding keinginan.'
            ];
            $saranAcak = $tips[array_rand($tips)];
        @endphp
        <div class="alert alert-danger alert-dismissible fade show mt-3 position-relative" role="alert">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong><i class="bi bi-exclamation-triangle-fill text-danger"></i> Anggaran Melebihi Batas!</strong><br>
                    Kamu telah menggunakan <strong>{{ $persentaseTotal }}%</strong> dari total anggaran bulan ini.
                    Itu berarti kamu <strong>melewati {{ number_format($kelebihanPersen, 1, ',', '.') }}%</strong> dari batas.<br><br>
                    <i class="bi bi-lightbulb"></i> Saran: 
                    @if($kelebihanPersen < 20)
                        Pertimbangkan untuk menghemat sekitar 
                        {{ number_format($kelebihanPersen, 1, ',', '.') }}% pengeluaran minggu depan.
                    @else
                        Pertimbangkan untuk menaikkan anggaran sebesar 
                        <strong>{{ $saranNaik }}%</strong>
                        atau sekitar 
                        <strong>Rp. {{ number_format($nominalSaranNaik, 0, ',', '.') }}</strong>.
                    @endif
                    <p class="mb-0"><i class="bi bi-info-square"></i>
                        {{ $saranAcak }}   
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="row text-center mb-4 g-3">

        <!-- Total Anggaran -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-wallet fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Total Anggaran</h6>
                        <h4 class="mb-0 fw-bold summary-nominal text-white">
                            Rp. {{ number_format($anggarans->sum(fn($item) => $item->tampilan['jumlah_anggaran_tampilan']), 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Terpakai -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-arrow-down-circle-fill fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Total Terpakai</h6>
                        <h4 class="mb-0 fw-bold summary-nominal text-white">
                            Rp. {{ number_format($anggarans->sum(fn($item) => $item->tampilan['nominal_yang_terpakai']), 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sisa Anggaran -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center icon justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-chart-line fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Sisa Anggaran</h6>
                        @php
                            $totalSisa = $anggarans->sum(fn($item) => $item->tampilan['sisa_anggaran_tampilan']);
                        @endphp
                        <h4 class="mb-0 fw-bold summary-nominal {{ $totalSisa < 0 ? 'text-danger' : 'text-success-card' }}">
                            Rp. {{ number_format($totalSisa, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <!-- Script untuk penyesuaian ukaran nominal dengan summary card -->
    <script>
        document.querySelectorAll('.summary-nominal').forEach(el => {
            function autoScale() {
                let parentWidth = el.parentElement.clientWidth;
                let fontSize = parseFloat(window.getComputedStyle(el).fontSize);

                el.style.fontSize = ""; 
                while (el.scrollWidth > parentWidth && fontSize > 10) {
                    fontSize -= 1;
                    el.style.fontSize = fontSize + "px";
                }
            }

            autoScale();
            window.addEventListener('resize', autoScale);
        });
    </script>

    {{-- ➕Tombol Tambah Anggaran --}}
    <div class="mb-3 text-end">
        <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah 
        </button>
    </div>


    {{-- Tabel --}}
    <div class="card p-3">
        
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="title-wrapper">
                <h5 class="page-title">
                    <i class="bi bi-calendar-event me-2"></i>
                    @php
                        $tanggal = \Carbon\Carbon::createFromFormat('Y-m-d', $periode);
                    @endphp

                    @if($mode == 'harian')
                        Anggaran Tanggal {{ $tanggal->translatedFormat('d F Y') }}
                    @elseif($mode == 'mingguan')
                        @php
                            $awalMinggu = $tanggal->copy()->startOfWeek(Carbon\Carbon::MONDAY);
                            $akhirMinggu = $tanggal->copy()->endOfWeek(Carbon\Carbon::SUNDAY);
                            $awalBulan = $tanggal->copy()->startOfMonth();
                            $akhirBulan = $tanggal->copy()->endOfMonth();
                            $awalTampil = $awalMinggu->lessThan($awalBulan) ? $awalBulan : $awalMinggu;
                            $akhirTampil = $akhirMinggu->greaterThan($akhirBulan) ? $akhirBulan : $akhirMinggu;
                        @endphp
                        Anggaran Minggu ke-{{ $tanggal->weekOfMonth }}
                        ({{ $awalTampil->translatedFormat('d M') }} - {{ $akhirTampil->translatedFormat('d M Y') }})
                    @else
                        Anggaran Bulan {{ $tanggal->translatedFormat('F Y') }}
                    @endif
                </h5>
            </div>

            <!-- Ikon Filter -->
            <div class="filter-wrapper position-relative">
                <button id="filterToggle" class="checklist-outline shadow-sm" title="Filter Tampilan">
                    <i class="bi bi-funnel-fill"></i>
                </button>

                <!-- Dropdown Filter Card -->
                <div id="filterCard" class="filter-card p-3 shadow-lg rounded-4 glass-form">
                    <form method="GET" action="{{ route('anggaran.index') }}" id="formPeriode">
                        <div id="alertPeriode" class="alert alert-warning d-none"></div>

                        <div class="floating-group mb-3">
                            <select name="mode" id="mode" class="form-select floating-input" required>
                                <option value="harian" {{ $mode == 'harian' ? 'selected' : '' }}>Per Hari</option>
                                <option value="mingguan" {{ $mode == 'mingguan' ? 'selected' : '' }}>Per Minggu</option>
                                <option value="bulanan" {{ $mode == 'bulanan' ? 'selected' : '' }}>Per Bulan</option>
                            </select>
                            <label for="mode">Tampilan</label>
                        </div>

                        <div class="floating-group mb-3">
                            <input 
                                type="text"
                                inputmode="none"
                                autocomplete="off"
                                readonly
                                name="periode"
                                id="periode"
                                value="{{ $periode }}"
                                class="form-control floating-input"
                                placeholder="Pilih tanggal"
                                required
                            >
                            <label for="periode">Pilih Periode</label>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn checklist rounded-pill px-3">
                                <i class="bi bi-check2-square me-1"></i> 
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            @if($anggarans->count() > 0)

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Jumlah Anggaran</th>
                            <th>Terpakai</th>
                            <th>Sisa</th>
                            <!-- <th>Persentase</th> -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggarans as $i => $item)
                            <!-- <tr class="{{ $item->sisa_anggaran < 0 ? 'table-danger' : '' }}"> -->
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    <i class="bi {{ $item->kategori->icon ?? 'bi-tag' }} me-1"></i>
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </td>
                                <td>Rp. {{ number_format($item->tampilan['jumlah_anggaran_tampilan'], 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($item->tampilan['nominal_yang_terpakai'], 0, ',', '.') }}</td>
                                <td class="{{ $item->tampilan['sisa_anggaran_tampilan'] < 0 ? 'text-danger fw-bold' : 'text-success' }}">
                                    Rp. {{ number_format($item->tampilan['sisa_anggaran_tampilan'], 0, ',', '.') }}
                                </td>
                                <!-- <td>{{ $item->tampilan['persentase_terpakai'] }}%</td> -->
                                <td>
                                {{-- Edit --}}
                                <button 
                                    class="btn btn-sm bg-general-gradient" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit{{ $item->id_anggaran }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                                {{-- Tombol Hapus (Trigger Modal) --}}
                                <button type="button" 
                                        class="btn btn-sm btn-red" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal" 
                                        onclick="prepareDelete('{{ route('anggaran.destroy', $item->id_anggaran) }}')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </tr>

                            @if($item->tampilan['sisa_anggaran_tampilan'] < 0)
                                @php
                                    $kelebihanPersen = min( round(abs($item->tampilan['sisa_anggaran_tampilan']) / max($item->tampilan['jumlah_anggaran_tampilan'], 1) * 100, 1), 999 );
                                @endphp
                                <tr class="bg-light row-alert">
                                    <td colspan="6">
                                        <div class="alert alert-danger alert-dismissible fade show mb-0 py-2">
                                            <small>
                                                <i class="bi bi-exclamation-circle"></i> Kategori <strong>{{ $item->kategori->nama_kategori }}</strong> telah melewati anggaran sebesar 
                                                <strong>{{ number_format($kelebihanPersen, 1, ',', '.') }}%</strong>.
                                                @if($kelebihanPersen < 15)
                                                    Cobalah mengurangi pengeluaran sekitar {{ number_format($kelebihanPersen, 1, ',', '.') }}% ke depan.
                                                @elseif($kelebihanPersen <= 20)
                                                    Cobalah menghemat sekitar {{ $kelebihanPersen }}% pada minggu berikutnya.
                                                @elseif($kelebihanPersen <= 50)
                                                    @php
                                                        $saranPersen = ceil($kelebihanPersen / 10) * 10;
                                                        $nominalSaran = ($saranPersen / 100) * $item->tampilan['jumlah_anggaran_tampilan'];
                                                    @endphp

                                                    Pertimbangkan untuk menaikkan anggaran kategori ini sebesar 
                                                    <strong>{{ $saranPersen }}%</strong> 
                                                    atau sekitar 
                                                    <strong>Rp. {{ number_format($nominalSaran, 0, ',', '.') }}</strong>.
                                                @else
                                                    Evaluasi ulang pengeluaran di kategori ini — kamu sudah melewati batas secara signifikan.
                                                @endif
                                            </small> 
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            
            @else

                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-inbox empty-state-icon text-secondary"></i>
                    </div>
                    <h6 class="fw-semibold mb-1">Belum ada anggaran</h6>
                    <p class="text-muted small mb-0">
                        Anggaran yang telah ditambahkan akan muncul di sini.
                    </p>
                    <button type="button" class="btn-gradient mt-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Anggaran
                    </button>
                </div>

            @endif
        </div>
    </div>
</div>

{{-- Modal Tambah Anggaran --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <form method="POST" action="{{ route('anggaran.store') }}">
                @csrf
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Anggaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Pilih Kategori</label>
                        <select name="kategori_id" id="kategoriSelect" class="form-select select-kategori" required>
                            <option value="" disabled selected>-- Pilih kategori --</option>
                            
                            {{-- Kita pasang data-icon DAN data-data sekaligus agar aman dari segala versi parser Tom Select --}}
                            @foreach ($kategoriTersedia as $kategori)
                                <option value="{{ $kategori->id_kategori }}" 
                                        data-icon="{{ $kategori->icon ?? 'bi-tag' }}" 
                                        data-data='{"icon": "{{ $kategori->icon ?? "bi-tag" }}"}'>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach

                            @if(auth()->user()->is_premium)
                                <option value="new" data-icon="bi-plus-circle-fill" data-data='{"icon": "bi-plus-circle-fill"}' class="fw-bold text-primary">
                                    + Tambah kategori baru / Lainnya
                                </option>
                            @else
                                <option value="upgrade_info" data-icon="bi-gem" data-data='{"icon": "bi-gem"}' class="text-muted">
                                    🔒 Tambah kategori baru (Premium Only)
                                </option>
                            @endif
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="newKategoriInput">
                        <label class="form-label fw-semibold text-dark">Nama Kategori Baru</label>
                        <input type="text" name="nama_kategori" id="namaKategoriBaru" class="form-control" placeholder="Masukkan nama kategori baru">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Jumlah Anggaran</label>
                        <input type="text" name="jumlah_anggaran" class="form-control nominal" id="jumlah_anggaran" placeholder="Masukkan jumlah anggaranmu dalam sebulan" inputmode="numeric" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-gradient">
                         Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Modal Tambah Anggaran -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelectEl = document.getElementById('kategoriSelect');
    const newKategoriInput = document.getElementById('newKategoriInput');
    const namaBaru = document.getElementById('namaKategoriBaru');

    if (kategoriSelectEl) {
        // 1. Inisialisasi Tom Select untuk Dropdown Anggaran
        const tsAnggaran = new TomSelect(kategoriSelectEl, {
            create: false,
            dataAttr: 'data-data', 
            
            render: {
                option: function(item, escape) {
                    // MENCARI IKON DI SETIAP SUDUT MEMORI TOM SELECT
                    let icon = 'bi-tag';
                    
                    if (item.icon) {
                        icon = item.icon; // Jika terbaca di root object
                    } else if (item.data && item.data.icon) {
                        icon = item.data.icon; // Jika tersimpan di properti data
                    } else if (item.src && item.src.icon) {
                        icon = item.src.icon; // Jika tersimpan di properti src (bawaan HTML)
                    } else if (item.element && item.element.getAttribute('data-icon')) {
                        icon = item.element.getAttribute('data-icon'); // Cadangan dari HTML langsung
                    }

                    // Beri warna khusus jika itu menu Premium atau Tambah Baru agar mencolok
                    let colorClass = 'text-secondary';
                    if (item.value === 'new') colorClass = 'text-success';
                    if (item.value === 'upgrade_info') colorClass = 'text-warning';

                    return `<div class="d-flex align-items-center">
                                <i class="bi ${icon} me-2 ${colorClass}" style="font-size: 1.1rem;"></i>
                                <span>${escape(item.text)}</span>
                            </div>`;
                },
                item: function(item, escape) {
                    // MENCARI IKON DI SETIAP SUDUT MEMORI TOM SELECT (UNTUK ITEM TERPILIH)
                    let icon = 'bi-tag';
                    
                    if (item.icon) {
                        icon = item.icon;
                    } else if (item.data && item.data.icon) {
                        icon = item.data.icon;
                    } else if (item.src && item.src.icon) {
                        icon = item.src.icon;
                    } else if (item.element && item.element.getAttribute('data-icon')) {
                        icon = item.element.getAttribute('data-icon');
                    }

                    return `<div class="d-flex align-items-center">
                                <i class="bi ${icon} me-2 text-primary" style="font-size: 1.1rem;"></i>
                                <strong>${escape(item.text)}</strong>
                            </div>`;
                }
            }
        });

        // 2. Logika Event Listener Menggunakan Tom Select Event ('change')
        tsAnggaran.on('change', function(value) {
            if (value === 'new') {
                newKategoriInput.classList.remove('d-none');
                namaBaru.required = true;
                namaBaru.focus();

            } else if (value === 'upgrade_info') {
                const modalTambahEl = document.getElementById('modalTambah');
                const modalTambah = bootstrap.Modal.getInstance(modalTambahEl);
                
                if (modalTambah) {
                    modalTambah.hide();
                }

                tsAnggaran.setValue("", true); 
                newKategoriInput.classList.add('d-none');
                namaBaru.required = false;

                const paywallModalEl = document.getElementById('paywallModal');
                if (paywallModalEl) {
                    const paywallModal = bootstrap.Modal.getInstance(paywallModalEl) || new bootstrap.Modal(paywallModalEl);
                    
                    setTimeout(() => {
                        paywallModal.show();
                    }, 400);
                }

            } else {
                newKategoriInput.classList.add('d-none');
                namaBaru.required = false;
            }
        });
    }
});
</script>

@push('scripts')
<script src="{{ asset('js/app/anggaran/filtercalendar.js') }}"></script>
<script src="{{ asset('js/app/anggaran/auto-close-alert.js') }}"></script>
@endpush

@include('partials.modals.modal-paywall')
@include('partials.modals.modal-edit-anggaran')
@include('partials.modals.modal-confirm-delete')

@endsection