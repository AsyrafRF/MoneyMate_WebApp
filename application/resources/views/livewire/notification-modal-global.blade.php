<div wire:ignore.self class="modal fade" id="notifDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow border-0">
            <div class="modal-header bg-primary bg-general-gradient text-white">
                <h5 class="modal-title">📩 Detail Notifikasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="notif-detail-body">
                @if($selectedNotif)
                    <p><strong>Pengirim:</strong> {{ $selectedNotif->sender ?? 'Sistem' }}</p>
                    <p><strong>Waktu:</strong> {{ $selectedNotif->created_at->translatedFormat('d M Y • H:i') }}</p>
                    <hr>
                    <div>{!! $selectedNotif->content !!}</div>
                @else
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border text-primary mb-2"></div>
                        <p>Memuat detail...</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer d-flex justify-content-between">
                @if($selectedNotif)
                    <button class="btn btn-danger rounded-pill"
                            wire:click="deleteNotif('{{ $selectedNotif->notif_id }}')"
                            wire:confirm="Yakin ingin menghapus notifikasi ini?">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                @endif
                <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>