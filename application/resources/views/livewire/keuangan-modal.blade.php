<div>
    <div class="modal-content shadow-lg">
        <!-- HEADER -->
        <div class="modal-header {{ $jenis == 'Pemasukan' ? 'bg-success' : 'bg-danger' }} text-white">
            <h5 class="modal-title d-flex align-items-center gap-2">
                <i class="bi {{ $jenis == 'Pemasukan' ? 'bi-arrow-down-circle-fill' : 'bi-arrow-up-circle-fill' }} fs-4"></i>
                Detail {{ $jenis }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <!-- BODY -->
        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">

            <!-- Bagian Filter -->
            <div class="row g-2 mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Cari keterangan/tanggal..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="filter">
                        <option value="">Semua Waktu</option>
                        <option value="today">Hari Ini</option>
                        <option value="this_week">Minggu Ini</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="monthly">Pilih Bulan</option>
                    </select>
                </div>

                @if($filter == 'monthly')
                <div class="col-md-3">
                    <input type="month" class="form-control" wire:model.live="month">
                </div>
                @endif

                @if(!$filter)
                <div class="col-md-5 d-flex gap-2">
                    <input type="date" class="form-control" wire:model.live="start_date">
                    <span class="align-self-center">-</span>
                    <input type="date" class="form-control" wire:model.live="end_date">
                </div>
                @endif
            </div>

            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="{{ $jenis == 'Pemasukan' ? 'table-success' : 'table-danger' }} text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th style="text-align: left;">Kategori</th>
                                <th style="text-align: right;">Nominal</th>
                                <th style="text-align: left;">Keterangan</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($items as $index => $item)
                                <tr>
                                    <td class="fw-bold">{{ $items->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td class="fw-semibold" style="text-align: left;">
                                        <span class="badge py-1 px-2 text-dark bg-secondary-subtle fw-bolder"
                                              style="font-size: 13px; font-weight: 500;">
                                            <i class="bi {{ $item->kategori->icon ?? 'bi-tag' }} me-1"></i>
                                            {{ $item->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td class="{{ $jenis == 'Pemasukan' ? 'text-success' : 'text-danger' }} fw-bold" style="text-align: right;">
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: left;">{{ $item->keterangan ?? '-' }}</td>
                                    <td>
                                        @if($item->bukti)
                                            <img src="{{ asset($item->bukti) }}" 
                                                alt="Bukti"
                                                class="img-thumbnail bukti-thumb" 
                                                style="width: 50px; cursor:pointer"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#previewBuktiModal" 
                                                data-bukti="{{ asset($item->bukti) }}">
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION (Livewire Handle Otomatis) -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $items->links() }}
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="d-flex flex-column align-items-center">
                        <i class="bi {{ $jenis == 'Pemasukan' ? 'bi-wallet2' : 'bi-cart-x' }} text-secondary opacity-25" style="font-size: 5rem;"></i>
                        <h5 class="mt-3 fw-bold text-dark">Belum ada data {{ $jenis }}</h5>
                        @if($jenis == 'Pemasukan')
                            <p class="text-muted">Catat setiap uang masuk untuk menjaga laporan keuangan tetap rapi.</p>
                        @else
                            <p class="text-muted">Sepertinya Anda belum mencatat pengeluaran apa pun hari ini.</p>
                        @endif
                        <button type="button" class="btn-gradient ms-2" data-bs-toggle="modal" data-bs-target="#tambahKeuanganModal">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Catatan
                        </button>                       
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>