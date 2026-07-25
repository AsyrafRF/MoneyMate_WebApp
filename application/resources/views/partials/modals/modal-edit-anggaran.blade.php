@foreach($anggarans as $i => $item)
    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit{{ $item->id_anggaran }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('anggaran.update', $item->id_anggaran) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header modal-header-gradient text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil-square"></i> Edit Anggaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" class="form-control" value="{{ $item->kategori->nama_kategori }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Anggaran</label>
                            <input type="hidden" name="jumlah_anggaran" class="anggaran-hidden" value="{{ $item->jumlah_anggaran }}">
                            <input type="text" class="form-control anggaran-display" value="{{ number_format($item->jumlah_anggaran, 0, ',', '.') }}" inputmode="numeric" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-gradient">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- Script Nominal Rupiah --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function formatRupiah(angka) {
        let num = angka.toString().replace(/[^0-9]/g, '');
        return num.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.querySelectorAll('.anggaran-display').forEach(input => {
        const hidden = input.closest('.mb-3').querySelector('.anggaran-hidden');
        
        input.addEventListener('input', function() {
            this.value = formatRupiah(this.value);
            hidden.value = this.value.replace(/\./g, '');
        });
    });
});
</script>