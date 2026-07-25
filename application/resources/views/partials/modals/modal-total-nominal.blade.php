<!-- Modal Pemasukan -->
<div class="modal fade" id="modalPemasukan" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        @livewire('keuangan-modal', ['jenis' => 'Pemasukan'])
    </div>
</div>

<!-- Modal Pengeluaran -->
<div class="modal fade" id="modalPengeluaran" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        @livewire('keuangan-modal', ['jenis' => 'Pengeluaran'])
    </div>
</div>

<!-- Modal Saldo -->
<div class="modal fade" id="modalSaldo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header modal-header-gradient text-white">
        <h5 class="modal-title">
            <i class="bi bi-wallet me-2"></i>Detail Analisis Saldo
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body">
        @if(Auth::user()->is_premium)
            <!-- BAGIAN 1: Saldo Terfilter (Dilihat Semua User) -->
            <div class="text-center mb-4">
                <span class="badge bg-light text-dark mb-2">Periode: {{ ucwords($labelFilter) }}</span>
                @php
                    $isNegative = $totalSaldo < 0;
                    $saldoClass = $isNegative ? 'text-danger' : 'text-success';
                    $iconClass = $isNegative ? 'bi-arrow-down-circle-fill' : 'bi-arrow-up-circle-fill';
                @endphp
                <h2 class="fw-bold mt-1 {{ $saldoClass }}">
                    Rp. {{ number_format($totalSaldo, 0, ',', '.') }}
                    <i x-data 
                        x-init="loadAnimate()"
                        class="bi {{ $iconClass }} me-2 animate__animated animate__fadeIn">
                    </i>
                </h2>
                <small class="text-muted">Total saldo pada filter saat ini</small>
            </div>

            <!-- Garis -->
            <hr> 
            <!-- Garis -->

            <!-- Rincian Perhitungan -->
            <div class="px-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Total Pemasukan</span>
                    <span class="text-success fw-semibold">+ Rp. {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Total Pengeluaran</span>
                    <span class="text-danger fw-semibold">- Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
                </div>
                <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Sisa Saldo</span>
                    <span class="fw-bold {{ $saldoClass }}">Rp. {{ number_format($totalSaldo, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="alert alert-info mt-4 mb-0 style="font-size: 0.85rem;">
                <i class="bi bi-info-circle-fill me-1"></i>
                Angka di atas adalah hasil kalkulasi <strong>neto</strong> berdasarkan filter yang Anda terapkan saat ini.
            </div>

            <!-- BAGIAN 2: Perbandingan / Saldo Keseluruhan (Khusus Premium) -->
            <div class="card border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-star-fill text-warning"></i> Ringkasan Keseluruhan (All Time)</h6>
                    
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Total Pemasukan:</span>
                        <span class="text-success">Rp. {{ number_format($totalPemasukanAll, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Total Pengeluaran:</span>
                        <span class="text-danger">Rp. {{ number_format($totalPengeluaranAll, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold border-top pt-1">
                        <span>Saldo Akhir Kas:</span>
                        <span class="{{ $totalSaldoAll < 0 ? 'text-danger' : 'text-primary' }}">
                            Rp. {{ number_format($totalSaldoAll, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            @if(request()->filled('filter') || request()->filled('search'))
                <p class="text-center mt-3 mb-0" style="font-size: 0.75rem;">
                    <i class="bi bi-info-circle"></i> 
                    Terdapat selisih <strong>Rp. {{ number_format(abs($totalSaldoAll - $totalSaldo), 0, ',', '.') }}</strong> 
                    antara filter ini dengan saldo asli Anda.
                </p>
            @endif
        @else
            <!-- BAGIAN 1: Saldo Terfilter (Dilihat Semua User) -->
            <div class="text-center mb-4">
                <small class="text-uppercase tracking-wider text-muted fw-bold">Periode: {{ $labelFilter }}</small>
                <h2 class="fw-bold {{ $totalSaldo < 0 ? 'text-danger' : 'text-success' }}">
                    Rp. {{ number_format($totalSaldo, 0, ',', '.') }}
                </h2>
                <small class="text-muted">Total saldo pada filter saat ini</small>
            </div>

            <hr>

            <!-- Tampilan untuk Non-Premium (Upselling) -->
            <div class="text-center p-3 border rounded-3 bg-light" style="border-style: dashed !important;">
                <i class="bi bi-lock-fill text-muted"></i>
                <p class="small text-muted mb-2">Ingin melihat perbandingan dengan saldo keseluruhan?</p>
                <a href="/plans" class="btn btn-sm btn-outline-primary shadow-sm">
                    Upgrade ke Premium
                </a>
            </div>

        @endif
      </div>
    </div>
  </div>
</div>