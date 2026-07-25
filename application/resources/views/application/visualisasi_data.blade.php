@extends('layouts.app')

@section('title', 'Grafik & Laporan Keuangan')

@push('styles')
<link href="{{ asset('css/app/components/months-filter.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/visualisasi/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content">
    {{-- Ekspos data ke JS --}}
    <script>
        window.__page = {
            // Untuk label (dipakai nanti jika butuh)
            mode:    "{{ $mode }}",

            // Untuk chart donut
            kategoriData: @json($kategoriData),
            bulanLabels:  @json($bulanLabels),
            PemasukanSeries: @json($PemasukanSeries),
            PengeluaranSeries: @json($PengeluaranSeries),
            totalPengeluaran: {{ (int) $totalPengeluaran }},

            // Untuk chart bar anggaran
            kategoriLabels: @json($kategoriLabels),
            anggaranData:   @json($anggaranData),
            realisasiData:  @json($realisasiData),
            totalAnggaran:  {{ (int) $totalAnggaran }},
        };
    </script>

    <!-- ROW 1: donut CHART + LAPORAN -->
    <div class="row mb-4 mb-md-5 align-items-stretch g-4">

        <div class="col-12 col-lg-8 col-xl-9">
            <div class="card chart-card border-0 shadow-sm h-100">
                
                <div class="card-header bg-transparent border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="cil-chart-pie fs-4"></i>
                        </div>
                        <span>
                            @php
                                use Carbon\Carbon;
                                $tanggal = Carbon::createFromFormat('Y-m-d', $periode);
                                if ($mode === 'harian') {
                                    $start = $tanggal->copy()->startOfDay();
                                    $end = $tanggal->copy()->endOfDay();
                                    $title = "Hari ini, " . $tanggal->translatedFormat('d F Y');
                                } elseif ($mode === 'mingguan') {
                                    $start = $tanggal->copy()->startOfWeek(Carbon::MONDAY);
                                    $end = $tanggal->copy()->endOfWeek(Carbon::SUNDAY);
                                    $title = "Minggu ke-" . $tanggal->weekOfMonth . " (" . $start->translatedFormat('d M') . " - " . $end->translatedFormat('d M Y') . ")";
                                } else {
                                    $title = "Bulan " . $tanggal->translatedFormat('F Y');
                                }
                            @endphp
                            Grafik Pengeluaran {{ $title }}
                        </span>
                    </h5>

                    <div class="dropdown">
                        <button class="btn btn-light btn-sm shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item {{ request('mode') === 'harian' ? 'active' : '' }}" href="{{ route('keuangan.laporan', ['mode' => 'harian']) }}"><i class="bi bi-calendar-day me-2"></i>Hari Ini</a></li>
                            <li><a class="dropdown-item {{ request('mode') === 'mingguan' ? 'active' : '' }}" href="{{ route('keuangan.laporan', ['mode' => 'mingguan']) }}"><i class="bi bi-calendar-week me-2"></i>Minggu Ini</a></li>
                            <li><a class="dropdown-item {{ request('mode') === 'bulanan' ? 'active' : '' }}" href="{{ route('keuangan.laporan', ['mode' => 'bulanan']) }}"><i class="bi bi-calendar-month me-2"></i>Bulan Ini</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalFilterBulanan"><i class="bi bi-calendar2-range me-2"></i>Pilih Bulan...</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('keuangan.laporan') }}"><i class="bi bi-arrow-counterclockwise me-2"></i>Reset</a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-4 d-flex align-items-center">
                    <div class="row g-4 align-items-center w-100 m-0">
                        
                        {{-- SISI KIRI: CHART --}}
                        <div class="col-12 col-md-6 d-flex justify-content-center">
                            <div class="chart-container position-relative w-100 mx-auto" style="max-width: 280px; min-height: 200px;">
                                @if ($totalPengeluaran == 0 || empty($kategoriData))
                                    <div class="empty-state text-center py-4 d-flex flex-column align-items-center justify-content-center h-100">
                                        <lottie-player src="{{ asset('lottie/no-result.json') }}" background="transparent" speed="1" style="width: 100%; max-width: 180px;" loop autoplay></lottie-player>
                                        <p class="mt-2 text-muted small fw-semibold mb-0">Belum ada pengeluaran.</p>
                                    </div>
                                @else
                                    <canvas id="kategoridonutChart"></canvas>
                                @endif
                            </div>
                        </div>

                        {{-- SISI KANAN: INFO & INSIGHT --}}
                        <div class="col-12 col-md-6">
                            @if ($totalPengeluaran > 0)
                                <div class="ps-md-2 text-center text-md-start">
                                    <div class="mb-3">
                                        <p class="text-muted mb-1 small text-uppercase fw-bold tracking-wider">Total Pengeluaran</p>
                                        <h3 class="fw-bold mb-0 text-dark text-break">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
                                    </div>

                                    <div class="legend-box mb-3">
                                        <ul class="list-unstyled mb-0 d-flex flex-wrap justify-content-center justify-content-md-start gap-2" id="donutLegend"></ul>
                                    </div>

                                    {{-- INSIGHT BOX --}}
                                    <div class="alert border-0 bg-primary-subtle p-3 rounded-4 mb-0 text-start">
                                        <div class="d-flex gap-3 align-items-start">
                                            <span class="fs-3 lh-1">💡</span>
                                            <div>
                                                <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">Rata-rata: Rp{{ number_format($rataRataPengeluaran, 0, ',', '.') }}/hari</h6>
                                                <p class="mb-0 small opacity-75">
                                                    @if($statusTren == 'turun')
                                                        ✨ <b>Slay!</b> Turun {{ $perbandinganPersen }}%. Dompet full senyum!
                                                    @elseif($statusTren == 'naik')
                                                        ⚠️ <b>Boncos!</b> Naik {{ $perbandinganPersen }}%. Rem dikit yuk!
                                                    @elseif($statusTren == 'naik_baru')
                                                        🚀 <b>Mulai!</b> Ada pergerakan arus kas baru nih.
                                                    @else
                                                        ⚖️ <b>Stabil!</b> No FOMO-FOMO club, pertahankan!
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-md-start pt-2">
                                    <small class="text-muted d-block text-center">Tambahkan transaksi untuk melihat ringkasan kategori otomatis di sini.</small>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4 col-xl-3">
            <div id="premium-status" data-is-premium="{{ Auth::user()->is_premium ? 'true' : 'false' }}"></div>
            <div class="card report-download-card border-0 shadow-sm h-100 p-0">

                <div class="report-card-header p-4 pb-0">
                    <h5 class="mb-0 d-flex align-items-center gap-2 fw-bold text-white">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                        Laporan Keuangan
                    </h5>
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <form action="{{ route('laporan.export.pdf') }}" method="POST" id="exportForm" data-no-overlay="true" class="w-100 d-flex flex-column flex-grow-1">
                        @csrf
                        <input type="hidden" name="mode" id="mode" value="bulanan">

                        <div class="mb-4">
                            <label class="form-label d-flex align-items-center gap-2 fw-semibold text-secondary small mb-2">
                                <input type="checkbox" id="check_single" class="form-check-input mt-0">
                                Pilih Bulan
                            </label>
                            <input type="month" id="periode" name="periode" class="form-control form-control-custom">

                            @if(!Auth::user()->is_premium)
                                <div class="mt-2 text-muted small d-flex justify-content-between align-items-center bg-light p-2 rounded-3">
                                    <span>Sisa unduhan:</span>
                                    <span class="fw-bold" style="color: #36A2EB;">{{ 3 - $jumlahDownload }} / 3</span>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4 text-muted opacity-25">

                        <div class="mb-4 text-muted">
                            <label class="form-label d-flex align-items-center justify-content-between gap-2 fw-semibold small mb-2">
                                <span class="d-flex align-items-center gap-2 text-secondary">
                                    <input type="checkbox" id="check_range" class="form-check-input mt-0">
                                    Periode Bulan 
                                </span>
                                @if(!Auth::user()->is_premium)
                                    <span class="badge bg-premium-gradient text-white" style="font-size: 0.65rem; padding: 4px 8px;"><i class="bi bi-lock-fill me-1"></i>PREMIUM</span>
                                @endif
                            </label>

                            <div class="row g-2 align-items-center">
                                <div class="col-12">
                                    <input type="month" id="start_month" name="start_month" class="form-control form-control-custom" disabled>
                                </div>
                                <div class="col-12 text-center my-1">
                                    <small class="text-uppercase fw-bold tracking-wider text-muted opacity-50" style="font-size: 0.75rem;">s/d</small>
                                </div>
                                <div class="col-12">
                                    <input type="month" id="end_month" name="end_month" class="form-control form-control-custom" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-auto pt-2">
                            <button type="submit" onclick="showSuccessNotif()" class="btn btn-unduh btn-success w-100 py-2.5 fw-bold shadow-sm rounded-3">
                                <i class="bi bi-download me-2"></i>Unduh Laporan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        
    </div>

    <!-- ROW 2: ANGGARAN BAR CHART -->
    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card chart-card p- 4">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center mx-3 mt-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <div class="p-2 bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <i class="cil-bar-chart fs-4"></i>
                        </div>

                        @php
                            $tanggal = Carbon::createFromFormat('Y-m-d', $periode);
                            $start = $tanggal->copy()->startOfMonth();
                            $end   = $tanggal->copy()->endOfMonth();
                        @endphp

                        {{-- 🔥 Judul khusus bulanan --}}
                        Grafik Anggaran Bulan {{ $tanggal->translatedFormat('F Y') }}
                    </h5>

                    {{-- FILTER BULAN --}}
                    <div class="filter-wrapper position-relative">
                        <button class="btn btn-light btn-sm" title="Filter Bulan" 
                                data-bs-toggle="modal" data-bs-target="#modalFilterBulanan">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body">
                    {{-- 🔥 LOGIKA EMPTY STATE --}}
                    @if($totalAnggaran > 0)
                        <canvas id="anggaranBarChart"></canvas>
                        
                    <!-- 🔥 BADGE TOTAL ANGGARAN -->
                        <div class="d-flex justify-content-center mb-2">
                            <span class="px-3 py-2 fs-6 shadow-sm">
                                Total Anggaran: Rp{{ number_format($totalAnggaran, 0, ',', '.') }}
                            </span>
                        </div>
                    @else
                        {{-- Tampilan saat data kosong --}}
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-secondary">Belum ada anggaran untuk bulan ini</h5>
                            <p class="text-muted">Mulai kelola keuanganmu dengan menyusun rencana anggaran sekarang.</p>
                            <a href="{{ route('anggaran.index') }}" class="btn btn-primary shadow-sm mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Buat Anggaran Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="{{ asset('js/app/visualisasi/current-month.js') }}"></script>
@if(session()->has('show_paywall'))
    <script src="{{ asset('js/app/premium_paywall.js') }}"></script>
@endif
@endpush

@include('partials.modals.modal-filter-bulan.visualisasi')

@endsection

@push('scripts')
    @vite(['resources/js/pages/keuangan/index.js'])
@endpush