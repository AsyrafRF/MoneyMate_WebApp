@foreach($transaksi as $item)
    <!-- Detail -->
    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-receipt"></i>
                        Detail Transaksi #{{ $item->id }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-row">
                        <span class="label">Tanggal</span>
                        <span class="value">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('j F Y') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Jenis</span>
                        <span class="value">
                            <span class="badge {{ $item->jenis == 'Pemasukan' ? 'bg-success' : 'bg-danger' }}">{{ $item->jenis }}</span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Kategori</span>
                        <span class="value">
                            <i class="bi {{ $item->kategori->icon ?? 'bi-tag' }} me-1"></i>
                            {{ $item->kategori->nama_kategori }}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Nominal</span>
                        <span class="value">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Keterangan</span>
                        <span class="value">{{ $item->keterangan ?? '-' }}</span>
                    </div>
                    <div class="mt-3 text-center">
                        <label class="fw-bold d-block mb-2">Bukti Transaksi</label>
                        @if($item->bukti)
                            <img src="{{ asset($item->bukti) }}" 
                                 class="img-fluid rounded shadow-sm img-thumbnail" 
                                 style="max-height: 250px;"
                                 alt="Bukti"
                                 data-bs-toggle="modal"
                                 data-bs-target="#previewBuktiModal"
                                 data-bukti="{{ asset($item->bukti) }}">
                        @else
                            <p class="text-muted small">Tidak ada bukti dilampirkan</p>
                        @endif
                    </div>
                </div>
                {{-- Footer --}}
                <div class="modal-footer justify-content-center">
                    <p>&copy; {{ date('Y') }} <strong>MoneyMate</strong>.id
                </div>
            </div>
        </div>
    </div>

    <!-- Edit -->
    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header modal-header-gradient text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i>
                        Edit Transaksi #{{ $item->id }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('keuangan.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="form-edit-keuangan"
                      data-is-premium="{{ $user->is_premium ? 'true' : 'false' }}"
                      data-current-saldo="{{ $user->saldo }}"
                      data-limit-saldo="{{ $limitSaldo }}"
                      data-sisa-upload="{{ $sisaUpload }}"
                      data-old-nominal="{{ $item->jumlah }}"
                      data-old-jenis="{{ $item->jenis }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal }}" required>
                        </div>

                        <!-- Jenis -->
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select name="jenis" class="form-control select-jenis-edit" required>
                                <option value="Pemasukan" {{ $item->jenis == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="Pengeluaran" {{ $item->jenis == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="edit_kategori{{ $item->id }}" class="form-label">Kategori</label>
                            <select 
                                name="kategori_id" 
                                id="edit_kategori{{ $item->id }}" 
                                class="form-control form-select select-kategori" 
                                data-selected="{{ $item->kategori->nama_kategori }}" 
                                required>
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>

                        <!-- Nominal -->
                        <div class="mb-3">
                            <label class="form-label">Nominal</label>
                            <input type="text" name="jumlah" class="form-control nominal input-nominal" value="{{ $item->jumlah }}" inputmode="numeric" required>
                            <small class="error-limit-saldo text-danger mt-1 d-block" style="display:none;"></small>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan{{ $item->id }}" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan{{ $item->id }}" class="form-control">{{ $item->keterangan }}</textarea>
                        </div>

                        {{-- Preview bukti lama --}}
                        @if($item->bukti)
                            <div class="mb-3">
                                <label class="form-label">Bukti Lama</label><br>
                                <img src="{{ asset($item->bukti) }}" alt="Bukti" class="img-fluid rounded shadow-sm mb-2" style="max-width: 200px;">
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Ganti Bukti</label>
                            <input type="file" name="bukti" class="form-control input-bukti">
                            <small class="error-limit-upload text-danger mt-1 d-block" style="display:none;"></small>
                        </div>
                    </div>

                    <div class="modal-footer gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-simpan">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
    function showDetail(id) {
        // Memicu modal detail berdasarkan ID
        var myModal = new bootstrap.Modal(document.getElementById('detailModal' + id));
        myModal.show();
    }
</script>