<div class="py-4 px-2 px-md-4">

    <div class="row mb-4 align-items-center">
        <div class="col-12 col-md-8">
            @php
                $jam = date('H');
                $namaDepan = explode(' ', trim(Auth::user()->name))[0];
                
                // 1. Tentukan waktu dasar dengan penggantian emoji ke teks/icon wrapper nanti
                if ($jam >= 5 && $jam < 12) {
                    $koleksiSapaan = [
                        "Good morning, $namaDepan! <i class='bi bi-cup-hot text-secondary ms-1'></i>",
                        "Semangat pagi, $namaDepan! <i class='fa-solid fa-fire-flip text-warning ms-1'></i>",
                        "Hai, pagi yang cerah, $namaDepan! <i class='bi bi-sun text-warning ms-1'></i>"
                    ];
                } elseif ($jam >= 12 && $jam < 18) {
                    $koleksiSapaan = [
                        "Halo siang, $namaDepan! <i class='fa-solid fa-hand text-warning ms-1'></i>",
                        "Hai, jangan lupa makan siang, $namaDepan! <i class='fa-solid fa-utensils text-danger ms-1'></i>",
                        "Masih semangat, $namaDepan? <i class='bi bi-lightning-charge-fill text-warning ms-1'></i>"
                    ];
                } else {
                    $koleksiSapaan = [
                        "Selamat malam, $namaDepan! <i class='bi bi-moon-stars text-primary ms-1'></i>",
                        "Hai, waktu beristirahat, $namaDepan! <i class='fa-solid fa-bed text-muted ms-1'></i>",
                        "Evaluasi keuangan hari ini, $namaDepan? <i class='bi bi-bar-chart-line text-info ms-1'></i>"
                    ];
                }

                // 2. Acak salah satu sapaan dari koleksi di atas
                $sapaanDinamis = $koleksiSapaan[array_rand($koleksiSapaan)];
            @endphp

            <h2 class="fw-black text-dark tracking-tight mb-1">
                {!! $sapaanDinamis !!}
            </h2>
            <p class="text-muted fs-7 mb-4">Berikut adalah ringkasan keuanganmu bulan ini.</p>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 d-flex align-items-center py-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>
                    <div class="fs-7 fw-medium text-dark-emphasis">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close fs-8 p-3" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <p class="text-muted mb-0">
                @if(Auth::user()->is_premium)
                    <span class="badge premium-bdg bg-general-gradient text-white rounded-pill px-3 py-2 fs-7 ">
                        <i class="bi bi-star-fill me-1"></i> Premium Member ({{ Auth::user()->subscription_days_left }} Days Left)
                    </span>
                @else
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fs-7">
                        <i class="bi bi-shield-lock me-1"></i> Basic Mode (Limit: Rp 6.000.000)
                    </span>
                @endif
            </p>
        </div>
        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
            <button type="button" class="btn btn-gradient" data-bs-toggle="modal" data-bs-target="#tambahKeuanganModal">
                <i class="bi bi-plus-circle me-2"></i>Catat Transaksi
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6 d-flex flex-column justify-content-between">
            <div class="card card-modern border-0 bg-general-gradient text-white p-4 mb-4 flex-grow-1 shadow-sm overflow-hidden position-relative">
                <div class="card-body p-0 d-flex flex-column justify-content-between z-1">
                    <div>
                        <span class="text-white-50 text-uppercase tracking-wider fs-7 fw-bold">Total Saldo Kamu</span>
                        <h2 class="display-5 fw-black mt-1 mb-2 tracking-tight">
                            {{ Auth::user()->saldo_rupiah }}
                        </h2>
                    </div>
                    <div class="mt-4 pt-3 border-top border-secondary-subtle">
                        <div class="d-flex justify-content-between align-items-center text-white-50 fs-7">
                            <span>Prediksi Batas Aman</span>
                            
                            <span class="text-white fw-medium">
                                @php
                                    $totalSaldo = (float) Auth::user()->saldo;
                                    $pengeluaran = (float) $this->totalPengeluaranBulanIni;
                                    
                                    // Inisialisasi rasio standar jika saldo normal
                                    $rasioBakarDuit = $totalSaldo > 0 ? round(($pengeluaran / $totalSaldo) * 100) : 0;
                                @endphp

                                @if($totalSaldo == 0)
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary rounded-pill px-2.5 py-1 fs-8">
                                        <i class="bi bi-wallet2 me-1"></i> Saldo kosong
                                    </span>
                                @elseif($totalSaldo < 0)
                                    <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 fs-8 animate-pulse">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Kritis! (Saldo Minus / Habis)
                                    </span>
                                @elseif($rasioBakarDuit <= 30)
                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-2.5 py-1 fs-8">
                                        <i class="bi bi-hand-thumbs-up-fill me-1"></i> Sehat (Baru Bakar {{ $rasioBakarDuit }}% Saldo)
                                    </span>
                                @elseif($rasioBakarDuit <= 60)
                                    <span class="badge bg-warning-subtle text-warning border border-warning rounded-pill px-2.5 py-1 fs-8">
                                        <i class="bi bi-eye-fill me-1"></i> Waspada (Bakar {{ $rasioBakarDuit }}% Saldo)
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-2.5 py-1 fs-8 animate-pulse">
                                        <i class="fa-solid fa-skull me-1"></i> Kritis! (Dompet Sekarat {{ $rasioBakarDuit }}%)
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-modern border-0 bg-white p-4 flex-grow-1 shadow-sm border-start-expense">
                <div class="card-body p-0">
                    <span class="text-muted text-uppercase tracking-wider fs-7 fw-bold">
                        Bakar Duit Bulan Ini <i class="bi bi-cash-stack text-danger ms-1"></i>
                    </span>
                    <h3 class="fw-black text-danger mt-1 mb-2 display-6 tracking-tight">
                        Rp {{ number_format($this->totalPengeluaranBulanIni, 0, ',', '.') }}
                    </h3>
                    <p class="text-muted fs-7 mb-0">
                        Diperbarui otomatis dari sirkulasi real-time periode <strong>{{ now()->translatedFormat('F Y') }}</strong>.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6" x-data="{ localColors: [] }" @update-chart-colors.window="localColors = $event.detail">
            <div class="card card-modern border-0 bg-white p-4 shadow-sm h-100">
                <div class="card-body p-0 d-flex flex-column align-items-center">
                    <h5 class="fw-bold text-dark mb-4 align-self-start">Distribusi Pengeluaran</h5>
                    
                    @if(count($this->topKategori) > 0)
                        <div class="w-100 d-flex justify-content-center mb-4" wire:ignore>
                            <div class="chart-container-permanent">
                                <canvas id="expensePieChart" 
                                        data-chart-initial="{{ json_encode([
                                            'labels' => $this->topKategori->map(fn($item) => $item->kategori->nama_kategori ?? 'Lainnya'),
                                            'data' => $this->topKategori->map(fn($item) => $item->total_jumlah)
                                        ]) }}">
                                </canvas>
                            </div>
                        </div>
                        
                        <div class="w-100">
                            <span class="text-muted fs-7 fw-bold text-uppercase d-block mb-2 text-center text-sm-start">
                                5 Kategori Terbesar
                            </span>
                            
                            <ul class="list-unstyled mb-0 d-flex flex-column gap-1">
                                @foreach($this->topKategori as $index => $item)
                                    <li class="d-flex justify-content-between align-items-center py-2 border-bottom border-light-subtle">
                                        <div class="d-flex align-items-center min-width-0">
                                            <span class="badge rounded-circle me-2 flex-shrink-0" 
                                                x-bind:style="{ backgroundColor: localColors[{{ $index }}] || '#6c757d' }"
                                                style="width: 10px; height: 10px; display: inline-block;"></span>
                                            
                                            <span class="fs-7 fw-semibold text-dark text-truncate" style="max-width: 200px;">
                                                {{ $item->kategori->nama_kategori ?? 'Lainnya' }}
                                            </span>
                                        </div>
                                        
                                        <span class="fs-7 fw-bold text-muted ms-2 flex-shrink-0">
                                            Rp {{ number_format($item->total_jumlah, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-center py-5 my-auto">
                            <i class="bi bi-pie-chart text-muted display-4"></i>
                            <p class="text-muted fs-7 mt-2 mb-0">Belum ada data pengeluaran bulan ini, yuk catat dulu!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="card card-modern border-0 bg-white p-4 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Budget Watch <i class="fa-solid fa-scale-balanced text-primary ms-1"></i></h5>
                    <a href="{{ route('anggaran.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold fs-7">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                
                @if(count($this->anggarans) > 0)
                    <div class="d-flex flex-column gap-3">
                        @foreach($this->anggarans as $anggaran)
                            @php $tampilan = $anggaran->tampilan; @endphp
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1 fs-7">
                                    <span class="fw-semibold text-dark">{{ $anggaran->kategori->nama_kategori ?? 'Umum' }}</span>
                                    <span class="text-muted">
                                        <strong class="text-dark">Rp {{ number_format($tampilan['nominal_yang_terpakai'], 0, ',', '.') }}</strong> 
                                        / Rp {{ number_format($tampilan['jumlah_anggaran_tampilan'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="progress rounded-pill shadow-inner position-relative" style="height: 12px;">
                                    <div class="progress-bar rounded-pill transition-all @if($tampilan['persentase_terpakai'] >= 90) bg-danger @elseif($tampilan['persentase_terpakai'] >= 75) bg-warning @else bg-general-gradient @endif" 
                                         role="progressbar" 
                                         style="width: {{ min($tampilan['persentase_terpakai'], 100) }}%">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1 fs-8 text-muted">
                                    <span>Sisa: Rp {{ number_format($tampilan['sisa_anggaran_tampilan'], 0, ',', '.') }}</span>
                                    <span class="fw-bold @if($tampilan['persentase_terpakai'] >= 90) text-danger @endif">{{ $tampilan['persentase_terpakai'] }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-sliders text-muted display-6"></i>
                        <p class="text-muted fs-7 mt-2 mb-0">Belum membuat anggaran bulan ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card card-modern border-0 bg-white p-4 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Tabungan Impian <i class="bi bi-rocket-takeoff text-success ms-1"></i></h5>
                    <a href="{{ route('tujuan.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold fs-7">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                @if(count($this->tujuans) > 0)
                    <div class="row g-3">
                        @foreach($this->tujuans as $tujuan)
                            <div class="col-12">
                                <div class="p-3 bg-light rounded-3 border-0 position-relative overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0">{{ $tujuan->nama_tujuan }}</h6>
                                            <span class="text-muted fs-8">Target: {{ \Carbon\Carbon::parse($tujuan->deadline)->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <span class="badge {{ $tujuan->progress >= 100 ? 'bg-success text-white' : 'bg-dark-subtle text-dark' }} rounded-pill px-2 py-1 fs-8 fw-bold">
                                            {{ $tujuan->progress }}%
                                        </span>
                                    </div>
                                    <div class="progress rounded-pill mb-2" style="height: 6px;">
                                        <div class="progress-bar {{ $tujuan->progress >= 100 ? 'bg-success' : 'bg-dark' }} rounded-pill" 
                                            role="progressbar" 
                                            style="width: {{ min($tujuan->progress, 100) }}%">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center fs-7">
                                        <span class="text-muted">Terkumpul</span>
                                        <span class="fw-bold text-success">Rp {{ number_format($tujuan->nominal_display, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4 my-auto">
                        <i class="bi bi-trophy text-muted display-6"></i>
                        <p class="text-muted fs-7 mt-2 mb-0">Belum ada *financial goals* yang dibuat.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-modern border-0 bg-white p-4 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Riwayat Transaksi Terakhir</h5>
                    <a href="{{ route('keuangan.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold fs-7">
                        Riwayat Lengkap <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr class="text-muted fs-8 text-uppercase tracking-wider">
                                <th scope="col" class="border-0 ps-0">Tanggal</th>
                                <th scope="col" class="border-0">Keterangan</th>
                                <th scope="col" class="border-0">Kategori</th>
                                <th scope="col" class="border-0 text-end pe-0">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->recentTransactions as $tx)
                                <tr>
                                    <td class="ps-0 fs-7 text-muted border-light-subtle">
                                        {{ \Carbon\Carbon::parse($tx->tanggal)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="border-light-subtle">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-7">{{ $tx->keterangan ?? '-' }}</span>
                                            @if($tx->is_auto)
                                                <span class="badge bg-info-subtle text-info rounded-pill align-self-start fs-9 mt-1 px-2">Auto</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="border-light-subtle">
                                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1.5 fs-8">
                                            <i class="bi {{ $tx->kategori->icon ?? 'bi-tag' }} me-1"></i>
                                            {{ $tx->kategori->nama_kategori ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-0 border-light-subtle">
                                        <span class="fw-black fs-7 @if($tx->jenis === 'Pemasukan') text-success @else text-danger @endif">
                                            {{ $tx->jenis === 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->jumlah, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 border-0">
                                        <span class="text-muted fs-7">Belum ada rekaman sirkulasi duit masuk atau keluar.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Selipan Current Events --}}
    <div class="card shadow-sm mt-4 rounded-4">
        <div class="card-header bg-general-gradient text-white fw-bold rounded-4 rounded-bottom rounded-bottom-0">
            <i class="bi bi-calendar-event"></i> Acara Berlangsung
        </div>
        <div class="card-body">
            <livewire:event-index />
        </div>
    </div>

@include('partials.styles.dashboard.ui')

@push('scripts')
@vite(['resources/js/pages/keuangan/index.js'])
<script src="{{ asset('js/app/pencatatan/tujuan-link.js') }}"></script>
@if(session()->has('show_paywall'))
    <script src="{{ asset('js/app/premium_paywall.js') }}"></script>
@endif
<script src="{{ asset('js/app/pencatatan/select-kategoris.js') }}"></script>
@endpush

@push('styles')
<link href="{{ asset('css/app/components/modal-form.css') }}" rel="stylesheet">
@endpush

@include('partials.modals.modal-tambah-catatan', [
    'user'       => $this->user,
    'limitSaldo' => $this->limitSaldo,
    'sisaUpload' => $this->sisaUpload,
    'tujuan'     => $this->allTujuan
])

</div>