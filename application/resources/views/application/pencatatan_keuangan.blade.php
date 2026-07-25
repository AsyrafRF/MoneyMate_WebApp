{{-- resources/views/pencatatan-keuangan.blade.php --}}
@extends('layouts.app')

@section('title', 'Pencatatan Keuangan')

@push('styles')
<link href="{{ asset('css/app/pencatatan-style.css?v=3') }}" rel="stylesheet">
<link href="{{ asset('css/app/components/months-filter.css') }}" rel="stylesheet">
<link href="{{ asset('css/app/components/modal-form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content">

    {{-- ✅ Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ❌ Pesan Error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria="Close"></button>
        </div>
    @endif

    {{-- Info Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Judul Halaman --}}
        <div class="col text-center">
            <h2 class="fw-bold">
                <img src="{{ asset('images/moneymate-black-notext.png') }}" alt="MoneyMate" class="rounded-img">
            </h2>
            <p class="text-muted">Catat Pemasukan dan Pengeluaran Anda dengan mudah.</p>
        </div>

        <div class="border-bottom mb-3"></div>

        <div class="mb-3">
            <!-- WRAPPER FLEX RESPONSIVE -->
            <div class="d-flex flex-column flex-md-row justify-content-center justify-content-md-end align-items-center gap-2">
                <!-- Badge Total Saldo -->
                <div class="text-md-end">
                    <div class="fw-semibold">Total Saldo :</div>

                    @php
                        if ($totalSaldo < 0) {
                            $badgeClass = 'bg-danger-subtle text-danger border-danger';
                        } elseif ($totalSaldo > 0) {
                            $badgeClass = 'bg-success-subtle text-success border-success';
                        } else {
                            $badgeClass = 'bg-secondary-subtle text-secondary border-secondary';
                        }
                    @endphp

                    <span 
                        class="badge {{ $badgeClass }} border fw-semibold card-summary"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalSaldo">
                        Rp. {{ number_format($totalSaldo, 0, ',', '.') }}
                    </span>

                </div>
            </div>
        </div>

        <div class="row g-3">
            <!-- Card Pemasukan -->
            <div class="col-md-6">
                <div class="card text-success shadow-sm rounded-4 border border-2 card-summary h-100"
                    data-bs-toggle="modal" data-bs-target="#modalPemasukan">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge"></span>
                            <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">Pemasukan</h6>
                            <span class="fw-semibold mb-0">
                                Rp. {{ number_format($tampilanPemasukan, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Pengeluaran -->
            <div class="col-md-6">
                <div class="card text-danger shadow-sm rounded-4 border border-2 card-summary h-100"
                    data-bs-toggle="modal" data-bs-target="#modalPengeluaran">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge"></span>
                            <i class="bi bi-cash-stack fs-4"></i>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">Pengeluaran</h6>
                            <span class="fw-semibold mb-0">
                                Rp. {{ number_format($tampilanPengeluaran, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Divider --}}
    <hr class="my-4">
    <h5 class="mb-3">
        <div class="mb-3 page-title">
            <i class="bi bi-journal-plus"></i> 
            Tambah Catatan Keuangan
        </div>
    </h5>

    {{-- Tombol Tambah Catatan & Kelola Kategori --}}
    <div class="d-flex justify-content-end gap-2 mb-3 text-nowrap" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">

        @php
            $premiumMember = !auth()->user()->is_premium;
        @endphp

        @if($premiumMember)
            <button class="btn btn-gradient opacity-50" data-bs-toggle="modal" data-bs-target="#paywallModal">
                <i class="bi bi-lock-fill me-1"></i> Kategori (Premium)
            </button>
        @else
            <a href="{{ route('kategori.index') }}" class="btn btn-gradient">
                <i class="bi bi-tags"></i> Kelola Kategori
            </a>
        @endif      

        <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#tambahKeuanganModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Catatan
        </button>
    </div>

    <br>
    {{-- Daftar Catatan --}}
    <div class="card shadow-sm rounded rounded-5">
        <div class="card-body">
            <h5 class="card-title d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div class="mb-3 page-title">
                    <i class="bi bi-clock-history"></i>
                    Riwayat Transaksi
                </div>

                <!-- BAGIAN FILTER -->
                <div class="d-flex align-items-center gap-2 mb-3 fs-6">

                    <!-- BADGE FILTER AKTIF -->
                    @if(request('filter'))
                        <span class="badge bg-primary bg-general-gradient text-white">
                            @switch(request('filter'))
                                @case('today')
                                    Hari Ini
                                    @break
                                @case('this_week')
                                    Minggu Ini
                                    @break
                                @case('this_month')
                                    Bulan Ini
                                    @break
                                @case('monthly')
                                    {{ \Carbon\Carbon::parse(request('month'))->translatedFormat('F Y') }}
                                    @break
                            @endswitch
                        </span>
                    @else
                        <span class="badge bg-general-gradient text-white">
                            Bulan ini
                            <i class="bi bi-chevron-double-right"></i>
                        </span>
                    @endif

                    <!-- TOMBOL UTAMA FILTER -->
                    <div class="dropdown">
                        <button class="checklist-outline shadow-sm"
                                type="button"
                                data-bs-toggle="dropdown">
                            <i class="bi bi-funnel-fill"></i>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <ul class="dropdown-menu shadow">
                            
                            <!-- Hari Ini -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2
                                    {{ request('filter') === 'today' ? 'active fw-bold' : '' }}"
                                    href="{{ route('keuangan.index', ['filter' => 'today']) }}">
                                    <i class="bi bi-calendar-day text-primary"></i> Hari Ini
                                </a>
                            </li>

                            <!-- Minggu Ini -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2
                                    {{ request('filter') === 'this_week' ? 'active fw-bold' : '' }}"
                                    href="{{ route('keuangan.index', ['filter' => 'this_week']) }}">
                                    <i class="bi bi-calendar-week text-success"></i> Minggu Ini
                                </a>
                            </li>

                            <!-- Bulan Ini -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2
                                    {{ request('filter') === 'this_month' ? 'active fw-bold' : '' }}"
                                    href="{{ route('keuangan.index', ['filter' => 'this_month']) }}">
                                    <i class="bi bi-calendar-month text-danger"></i> Bulan Ini
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <!-- Pilih Periode Bulan -->
                            <li>
                                <button class="dropdown-item d-flex align-items-center gap-2
                                    {{ request('filter') === 'monthly' ? 'active fw-bold' : '' }}"
                                    data-bs-toggle="modal" data-bs-target="#modalFilterBulanan">
                                    <i class="bi bi-calendar2-range text-warning"></i> Pilih Bulan...
                                </button>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <!-- Reset -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 text-danger
                                    {{ !request()->has('filter') ? 'fw-bold' : '' }}"
                                    href="{{ route('keuangan.index') }}">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                                </a>
                            </li>

                        </ul>
                    </div>

                </div>
            </h5>

            <!-- Tabel Riwayat Transaksi -->
            <div class="table-responsive">

                <!-- Search Box (ikut scroll horizontal) -->
                <div class="mb-3" style="position: sticky; left: 0; z-index: 10;">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('keuangan.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari transaksi..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm bg-general-gradient">Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Data Table -->
                @if($transaksi->count() > 0)

                    <table class="table table-borderless table-striped align-middle text-center table-hover table-sm" id="keuanganTable">
                        <thead class="table-light table-group-divider">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($transaksi as $index => $item)
                                <tr style="cursor: pointer;">
                                    <td onclick="showDetail({{ $item->id }})">
                                        {{ $transaksi->firstItem() + $index }}
                                    </td>
                                    <td onclick="showDetail({{ $item->id }})" 
                                        style="text-align: left;">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d-M-Y') }}
                                    </td>
                                    <td onclick="showDetail({{ $item->id }})">
                                        <span class="badge {{ $item->jenis == 'Pemasukan' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $item->jenis }}
                                        </span>
                                    </td>
                                    <td onclick="showDetail({{ $item->id }})" style="text-align: right;">Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td onclick="showDetail({{ $item->id }})" style="text-align: left;">
                                        <span class="badge py-1 px-2 {{ $item->jenis == 'Pemasukan' ? 'text-success bg-success-subtle' : 'text-danger bg-danger-subtle' }}"
                                              style="font-size: 13px; font-weight: 500;">
                                            <i class="bi {{ $item->kategori->icon ?? 'bi-tag' }} me-1"></i>
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td onclick="showDetail({{ $item->id }})" title="{{ $item->keterangan }}" style="text-align: left;">
                                        <div class="truncate">
                                            @if($item->keterangan)
                                                {{ $item->keterangan }}
                                            @else
                                                ....
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Tombol Edit: Langsung ke Modal Edit --}}
                                            <button class="btn btn-sm bg-general-gradient" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <button type="button" class="btn btn-sm btn-red" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                    onclick="prepareDelete('{{ route('keuangan.destroy', $item->id) }}')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td onclick="showDetail({{ $item->id }})">
                                        @if($item->bukti)
                                            <img src="{{ asset($item->bukti) }}" 
                                                 alt="Bukti" 
                                                 class="img-fluid rounded shadow-sm img-thumbnail bukti-thumb" 
                                                 style="max-width: 300px;">
                                        @else - @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @else

                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-inbox empty-state-icon text-secondary"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Belum ada transaksi</h6>
                        <p class="text-muted small mb-0">
                            Data pemasukan dan pengeluaran akan muncul di sini.
                        </p>
                            <button type="button" class="btn-gradient mt-3" data-bs-toggle="modal" data-bs-target="#tambahKeuanganModal">
                                <i class="bi bi-plus-circle me-1"></i> Tambah
                            </button>
                    </div>

                @endif
            </div>

            {{-- Pagination jika ada --}}
            <div class="d-flex justify-content-center mt-3">
                @if ($transaksi->hasPages())
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-2 w-100 px-2">

                        {{-- Info jumlah data --}}
                        <div class="text-muted small text-center text-md-start">
                            Menampilkan 
                            <strong>{{ $transaksi->firstItem() }}</strong>
                            hingga 
                            <strong>{{ $transaksi->lastItem() }}</strong>
                            dari 
                            <strong>{{ $transaksi->total() }}</strong> hasil
                        </div>

                        {{-- Navigasi halaman --}}
                        <nav aria-label="Navigasi halaman">
                            <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center responsive-pagination">

                                {{-- Mengikuti Kondisi Halaman --}}
                                @php
                                    $current = $transaksi->currentPage();
                                    $last = $transaksi->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);

                                    // menarik url filter:
                                    $query = request()->query();
                                    unset($query['page']); // hilangkan page lama agar tidak duplikat
                                @endphp

                                {{-- Tombol Sebelumnya --}}
                                @if ($transaksi->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" 
                                            href="{{ $transaksi->previousPageUrl() . ( $query ? '&'.http_build_query($query) : '' ) }}" 
                                            rel="prev">&laquo;
                                        </a>
                                    </li>
                                @endif

                                {{-- Nomor Halaman --}}
                                @php
                                    $current = $transaksi->currentPage();
                                    $last = $transaksi->lastPage();
                                    $start = max(1, $current - 2);
                                    $end = min($last, $current + 2);
                                @endphp

                                {{-- Halaman Pertama --}}
                                @if ($start > 1)
                                    <li class="page-item page-md">
                                        <a class="page-link" href="{{ $transaksi->url(1) . ($query ? '&'.http_build_query($query) : '') }}">1</a>
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
                                                href="{{ $transaksi->url($i) . ( $query ? '&'.http_build_query($query) : '' ) }}">
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
                                        <a class="page-link" href="{{ $transaksi->url($last) . ( $query ? '&'.http_build_query($query) : '' ) }}">
                                            {{ $last }}
                                        </a>
                                    </li>
                                @endif

                                {{-- Tombol Berikutnya --}}
                                @if ($transaksi->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" 
                                            href="{{ $transaksi->nextPageUrl() . ( $query ? '&'.http_build_query($query) : '' ) }}"
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
    </div>
    
</div>

@if (session('warning'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
    <div id="toastWarning" class="toast align-items-center text-bg-warning border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                 {{ session('warning') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script src="{{ asset('js/app/pencatatan/tujuan-link.js') }}"></script>
@if(session()->has('show_paywall'))
    <script src="{{ asset('js/app/premium_paywall.js') }}"></script>
@endif
<script src="{{ asset('js/app/pencatatan/select-kategoris.js') }}"></script>
@endpush

<!-- Modals Components -->
@include('partials.modals.modal-paywall')
@include('partials.modals.modal-total-nominal')
@include('partials.modals.modal-tambah-catatan')
@include('partials.modals.modal-view-edit-catatan')
@include('partials.modals.modal-preview-bukti')
@include('partials.modals.modal-confirm-delete')
@include('partials.modals.modal-filter-bulan.keuangan')

<!-- Script Components -->
@include('partials.scripts.keuangan.limit')

@endsection