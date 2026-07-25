@extends('layouts.app')

@section('title', 'Riwayat Premium')

@section('content')
<div class="container py-3 py-md-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Riwayat Pembayaran</h3>
        <a href="{{ route('premium.checkout') }}" class="btn btn-primary btn-sm rounded-pill px-3 d-md-none">
            <i class="fas fa-plus me-1"></i> Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 border-0">INVOICE</th>
                            <th class="py-3 border-0">PAKET</th>
                            <th class="py-3 border-0">TOTAL</th>
                            <th class="py-3 border-0">TANGGAL</th>
                            <th class="py-3 border-0 text-center">STATUS</th>
                            <th class="pe-4 py-3 border-0 text-end">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold text-dark d-block">#{{ $trx->invoice_number }}</span>
                                <small class="text-muted d-md-none">{{ $trx->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-light text-primary border border-primary-subtle fw-medium">
                                    {{ ucfirst($trx->plan) }}
                                </span>
                            </td>
                            <td class="py-3 fw-semibold text-dark">
                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 text-muted d-none d-md-table-cell">
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-3 text-center">
                                @if($trx->status == 'pending')
                                    <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3">Menunggu</span>
                                @elseif($trx->status == 'verifying')
                                    <span class="badge rounded-pill bg-info-subtle text-info-emphasis px-3">Verifikasi</span>
                                @elseif($trx->status == 'success')
                                    <span class="badge rounded-pill bg-success-subtle text-success-emphasis px-3">Berhasil</span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger-emphasis px-3">Gagal</span>
                                @endif
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        @if($trx->status == 'pending')
                                            <li><a class="dropdown-item text-primary" href="{{ route('premium.upload', $trx->id) }}"><i class="fas fa-credit-card me-2"></i>Bayar Sekarang</a></li>
                                        @elseif($trx->status == 'verifying' || $trx->status == 'success')
                                            <li><a class="dropdown-item" href="{{ route('premium.status', $trx->id) }}"><i class="fas fa-eye me-2"></i>Detail Transaksi</a></li>
                                        @else
                                            <li><a class="dropdown-item" href="{{ route('premium.checkout') }}"><i class="fas fa-redo me-2"></i>Ulangi Checkout</a></li>
                                        @endif

                                        @if($trx->status == 'success')
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="{{ route('premium.invoice.download', $trx->id) }}"><i class="fas fa-file-pdf me-2"></i>Download PDF</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="No Data" style="width: 80px;" class="mb-3 opacity-50">
                                <p class="text-muted mb-0">Belum ada riwayat transaksi ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links() }}
    </div>
</div>

<style>
    /* Custom Styling untuk mempercantik tampilan mobile */
    .table-responsive {
        scrollbar-width: thin;
    }
    
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Mengurangi ukuran font di mobile agar tidak sesak */
    @media (max-width: 576px) {
        .table thead {
            display: none; /* Sembunyikan header di mobile untuk tampilan lebih clean */
        }
        .table td {
            font-size: 0.85rem;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>
@endsection