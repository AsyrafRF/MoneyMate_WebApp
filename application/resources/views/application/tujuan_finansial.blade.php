<!-- resources\views\application\tujuan_finansial.blade.php -->
@extends('layouts.app')

@section('title', 'Tujuan Finansial')

@push('styles')
<link href="{{ asset('css/app/summary-card.css') }}" rel="stylesheet">
@endpush

@section('content')

<style>
.btn-success:hover {
    color: black;
}

.progress {
    background-color: #E9ECEF;
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    transition: width 0.6s ease, background-color 0.3s ease;
}

.tujuan-card:hover {
    transform: scale(1.02);
    transition: all 0.2s ease-in-out;
}
.card-summary-target h5 {
    margin: 0;
    font-weight: bold;
}
.card-summary-target {
    border-radius: 15px;
    background: linear-gradient(135deg, rgba(116, 185, 255, 0.3), rgba(9, 132, 227, 0.2)) !important;
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s, box-shadow 0.3s ease;
}
.card-summary-target:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    background: linear-gradient(135deg, #edf0f3ff, #bdc0c2ff) !important;
}

.badge-stempel {
    position: absolute;
    top: 12px;
    right: -15px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    color: white;
    border-radius: 5px;
    transform: rotate(12deg);
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    opacity: 0.92;
    letter-spacing: 1px;
    z-index: 10;
}

/* Warna untuk status */
.badge-terpakai {
    background: #102F4B;
    border: 2px solid #fff1f1;
}

.badge-ditarik {
    background: #198754;
    border: 2px solid #cdd8ff;
}
</style>

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

    {{-- 📊 Summary Card --}}
    {{-- Ringkasan --}}
    <div class="row text-center mb-4 g-3">

        <!-- Total Tabungan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-piggy-bank fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Total Tabungan</h6>
                        <h4 class="mb-0 fw-bold summary-nominal text-white">
                            Rp. {{ number_format($totalTabungan, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Target -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="bi bi-crosshair2 fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Total Target</h6>
                        <h4 class="mb-0 fw-bold summary-nominal text-white">
                            Rp. {{ number_format($totalTarget, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sisa Target -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 summary-card-2">
                <div class="card-body d-flex align-items-center justify-content-center gap-3 p-4 summary-item">
                    <div class="rounded-circle bg-icon text-white d-flex align-items-center icon justify-content-center shadow"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-money-bill-wave fs-3"></i>
                    </div>
                    <div class="text-start">
                        <h6 class="text-secondary text-white mb-1">Sisa Target</h6>

                        <h4 class="mb-0 fw-bold summary-nominal text-white">
                            Rp. {{ number_format($sisaTarget, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Script untuk menyesuaikan Ukuran Nominal di dalam Summary Card -->
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


        {{-- ➕Tombol Tambah Tujuan --}}
        <div class="mb-3 text-end">
            @php
                $limitReached = !auth()->user()->is_premium && $tujuan->total() >= 1;
            @endphp

            @if($limitReached)
                <button class="btn btn-secondary opacity-75" data-bs-toggle="modal" data-bs-target="#paywallModal">
                    <i class="bi bi-lock-fill me-1"></i> Tambah (Limit Tercapai)
                </button>
            @else
                <button class="btn-gradient" data-bs-toggle="modal" data-bs-target="#tambahNominalModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah 
                </button>
            @endif
        </div>

        <div class="row">
            @forelse ($tujuan as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm rounded-3 tujuan-card position-relative
                        {{ $item->status != 'active' ? 'opacity-50 pointer-events-none' : '' }}"
                        data-bs-toggle="modal"
                        data-bs-target="#viewTujuanModal"
                        data-id="{{ $item->id }}"
                        data-progress="{{ $item->persen_nominal }}"
                        data-status="{{ $item->status }}"
                        data-nama="{{ $item->nama_tujuan }}"
                        data-target="{{ number_format($item->target_nominal, 0, ',', '.') }}"
                        data-nominal="{{ number_format($item->nominal_saat_ini, 0, ',', '.') }}"
                        data-target-raw="{{ $item->target_nominal }}"
                        data-current-raw="{{ $item->nominal_saat_ini }}"
                        data-progress-nominal="{{ round($item->persen_nominal) }}"
                        data-progress-warna="{{ $item->warna_nominal }}"
                        data-deadline="{{ \Carbon\Carbon::parse($item->deadline)->format('d F Y') }}"
                        data-deadline-raw="{{ $item->deadline }}">

                        @if ($item->status == 'used')
                            <div class="badge-stempel badge-terpakai">Sudah Terpakai</div>
                        @endif

                        @if ($item->status == 'withdrawn')
                            <div class="badge-stempel badge-ditarik">Sudah Ditarik</div>
                        @endif

                        <div class="card-header text-white fw-bold text-center bg-general-gradient">
                            {{ $item->nama_tujuan }}
                        </div>

                        <div class="card-body">
                            <p class="mb-1">
                                <strong>
                                    <i class="bi bi-bullseye"></i>
                                    {{ $item->nama_tujuan }}
                                </strong>
                            </p>
                            <p class="mb-1">Target: Rp. {{ number_format($item->target_display, 0, ',', '.') }}</p>
                            <p class="mb-1">Saat ini: Rp. {{ number_format($item->nominal_display, 0, ',', '.') }}</p>

                            {{-- Progress Nominal --}}
                            <div class="mb-2">
                                <label class="small text-muted">Progress Nominal</label>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar fw-bold"
                                        role="progressbar"
                                        style="width: {{ $item->persen_nominal }}%; background-color: {{ $item->warna_nominal }}">
                                        {{ round($item->persen_nominal) }}%
                                    </div>
                                </div>
                            </div>

                            {{-- Progress Waktu --}}
                            <div class="mb-2">
                                <label class="small text-muted">Progress Waktu</label>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        style="width: {{ $item->progress_hari }}%; background-color: {{ $item->warna_hari }}">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    @if ($item->sisa_hari == 0 && $item->sisa_jam == 0)
                                        Waktu telah habis.
                                    @else
                                        <small class="text-muted">
                                            @if ($item->sisa_hari == 0 && $item->sisa_jam == 0 && $item->sisa_bulan == 0 && $item->sisa_tahun == 0)
                                                Waktu telah habis.
                                            @else
                                                Tersisa 
                                                @if ($item->sisa_tahun > 0)
                                                    {{ $item->sisa_tahun }} tahun 
                                                @endif

                                                @if ($item->sisa_bulan > 0)
                                                    {{ $item->sisa_bulan }} bulan 
                                                @endif

                                                @if ($item->sisa_hari > 0)
                                                    {{ $item->sisa_hari }} hari 
                                                @endif

                                                @if ($item->sisa_jam > 0)
                                                    {{ $item->sisa_jam }} jam 
                                                @endif

                                                lagi sebelum deadline.
                                            @endif
                                        </small>
                                    @endif
                                </small>
                            </div>

                            <p class="mt-2 mb-0">Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        
                        <!-- Lottie Animation -->
                        <div 
                            id="emptyTujuanAnimation" 
                            style="max-width: 350px; margin: 0 auto;"
                            data-path="{{ asset('lottie/no-result.json') }}"
                        ></div>

                        <h4 class="mt-4 fw-bold text-muted">
                            Belum ada Tujuan Finansial
                        </h4>
                        <p class="text-muted">
                            Yuk mulai buat tujuan finansial pertamamu 
                            <i class="bi bi-rocket"></i>
                        </p>

                        <button class="btn-gradient mt-3"
                                data-bs-toggle="modal"
                                data-bs-target="#tambahNominalModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Tujuan
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination untuk Tujuan --}}
        <div class="d-flex justify-content-center mt-3">
            @if ($tujuan->hasPages())
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-2 w-100 px-2">

                    {{-- Info jumlah data --}}
                    <div class="text-muted small text-center text-md-start">
                        Menampilkan 
                        <strong>{{ $tujuan->firstItem() }}</strong>
                        hingga 
                        <strong>{{ $tujuan->lastItem() }}</strong>
                        dari 
                        <strong>{{ $tujuan->total() }}</strong> hasil
                    </div>

                    {{-- Navigasi halaman --}}
                    <nav aria-label="Navigasi halaman">
                        <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center responsive-pagination">

                            @php
                                $current = $tujuan->currentPage();
                                $last = $tujuan->lastPage();
                                $start = max(1, $current - 2);
                                $end = min($last, $current + 2);

                                // simpan semua query filter
                                $query = request()->query();
                                unset($query['page']);
                            @endphp

                            {{-- Tombol Sebelumnya --}}
                            @if ($tujuan->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" 
                                        href="{{ $tujuan->previousPageUrl() . ($query ? '&'.http_build_query($query) : '') }}" 
                                        rel="prev">&laquo;
                                    </a>
                                </li>
                            @endif

                            {{-- Halaman Pertama --}}
                            @if ($start > 1)
                                <li class="page-item page-md">
                                    <a class="page-link" href="{{ $tujuan->url(1) . ($query ? '&'.http_build_query($query) : '') }}">1</a>
                                </li>
                                @if ($start > 2)
                                    <li class="page-item disabled page-md"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            {{-- Halaman Tengah --}}
                            @for ($i = $start; $i <= $end; $i++)
                                @php
                                    $isHiddenMobile = ($i < $current - 1 || $i > $current + 1);
                                @endphp

                                <li class="page-item {{ $i == $current ? 'active' : '' }} {{ $isHiddenMobile ? 'page-md' : '' }}">
                                    @if ($i == $current)
                                        <span class="page-link">{{ $i }}</span>
                                    @else
                                        <a class="page-link" 
                                            href="{{ $tujuan->url($i) . ($query ? '&'.http_build_query($query) : '') }}">
                                            {{ $i }}
                                        </a>
                                    @endif
                                </li>
                            @endfor

                            {{-- Halaman Terakhir --}}
                            @if ($end < $last)
                                @if ($end < $last - 1)
                                    <li class="page-item disabled page-md"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item page-md">
                                    <a class="page-link" 
                                        href="{{ $tujuan->url($last) . ($query ? '&'.http_build_query($query) : '') }}">
                                        {{ $last }}
                                    </a>
                                </li>
                            @endif

                            {{-- Tombol Berikutnya --}}
                            @if ($tujuan->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" 
                                        href="{{ $tujuan->nextPageUrl() . ($query ? '&'.http_build_query($query) : '') }}"
                                        rel="next">&raquo;
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif

                        </ul>
                    </nav>
                </div>
            @endif
        </div>

</div>

@include('partials.modals.modal-tambah-tujuan')
@include('partials.modals.modal-view-tujuan')
@include('partials.modals.modal-paywall')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua kartu tujuan
    const cards = document.querySelectorAll('.tujuan-card');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const modal = document.getElementById('viewTujuanModal');

            // Ambil data dari atribut HTML
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const target = this.dataset.target;
            const nominal = this.dataset.nominal;
            const deadline = this.dataset.deadline;
            const persen = this.dataset.progressNominal;   // contoh: 45
            const warna  = this.dataset.progressWarna;     // contoh: #4CAF50

            // Masukkan ke tab View
            modal.querySelector('#viewNama').textContent = nama;
            modal.querySelector('#viewTarget').textContent = target;
            modal.querySelector('#viewNominal').textContent = nominal;
            modal.querySelector('#viewDeadline').textContent = deadline;

            // Update progress bar modal sesuai Controller
            const bar = modal.querySelector('#progressBar');
            const pct = modal.querySelector('#progressText');
            bar.style.width = persen + "%";
            bar.style.backgroundColor = warna;
            pct.textContent = persen + "%";

            // Masukkan ke tab Edit
            modal.querySelector('#editNominal').value = nominal;

            // 🔥 Update action form UPDATE & DELETE
            const updateForm = modal.querySelector('#updateForm');
            const deleteForm = modal.querySelector('#deleteForm');

            if (updateForm) updateForm.action = `/tujuan/${id}`;
            if (deleteForm) deleteForm.action = `/tujuan/${id}`;

            console.log('Form action diset untuk ID:', id);
        });
    });
});
</script>

<!-- Lottie Animation (for empty) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const emptyContainer = document.getElementById('emptyTujuanAnimation');

    if (emptyContainer) {
        lottie.loadAnimation({
            container: emptyContainer,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            // Ambil path dari atribut data-path
            path: emptyContainer.getAttribute('data-path')
        });
    }
});
</script>

@if(!auth()->user()->is_premium)
<div class="card bg-light mt-5 border-dashed">
    <div class="card-body text-center py-4">
        <h5>🚀 Ingin memantau banyak tujuan sekaligus?</h5>
        <p class="text-muted">Upgrade ke akun <strong>Premium</strong> dan buat tujuan finansial tanpa batas!</p>
        <a href="/plans" class="btn btn-secondary btn-sm">Pelajari Selengkapnya</a>
    </div>
</div>
@endif

@endsection