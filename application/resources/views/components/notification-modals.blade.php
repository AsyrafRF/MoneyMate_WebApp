@props([
    'monthFilter' => null,
    'selectedNotif' => null
])

{{-- ================= MODAL FILTER ================= --}}
<div wire:ignore.self class="modal fade" id="notifCalendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-general-gradient text-white">
                <h5 class="modal-title"><i class="bi bi-calendar2-range"></i> Filter Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form wire:submit="applyFilter" data-no-overlay="true">
                <div class="modal-body">
                    <label class="form-label fw-semibold" for="inputMonth">Pilih Bulan</label>
                    <input type="month" id="inputMonth" wire:model.live="monthFilter"
                           class="form-control" required>
                </div>
                <div class="modal-footer d-flex gap-2">
                    <button type="submit" class="btn btn-primary bg-btn-gradient w-100 text-white fw-bold">
                        Terapkan
                    </button>
                    <button type="button" wire:click="resetFilter"
                            class="btn btn-secondary w-100 fw-bold" data-bs-dismiss="modal">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL DETAIL ================= --}}
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

{{-- ================= MODAL PERMISSION ================= --}}
<div class="modal fade" id="notifPermissionModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4">
            <h5 class="fw-bold mb-2">Aktifkan Notifikasi?</h5>
            <p class="text-muted">Kami akan mengirimkan notifikasi untuk:</p>
            <ul>
                <li>🔔 Aktivitas penting akun</li>
                <li>⏰ Pengingat Pencatatan Keuangan</li>
                <li>💰 Peringatan Batas Anggaran</li>
            </ul>
            <div class="d-flex gap-2">
                <button class="btn btn-secondary w-100" data-bs-dismiss="modal">Nanti</button>
                <button class="btn btn-success w-100" id="confirmEnableNotif">Izinkan Notifikasi</button>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL SETTINGS ================= --}}
<div class="modal fade" id="notifSettingsModal">
    <div class="modal-dialog">
        <div class="modal-content p-4 rounded">
            <h4 class="fw-bold mb-3">
                <i class="bi bi-gear"></i> Pengaturan Notifikasi
            </h4>
            <p class="text-muted">
                Atur bagaimana kamu menerima notifikasi walaupun aplikasi tertutup.
            </p>
            <div class="mb-3">
                <label class="fw-bold mb-1">Status Notifikasi Browser:</label>
                <div id="notif-status" class="badge bg-secondary">Checking...</div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span>Aktifkan Push Notification</span>
                <label class="switch">
                    <input type="checkbox" id="pushToggle">
                    <span class="slider round"></span>
                </label>
            </div>
            <!-- <hr>
            <button class="btn btn-success w-100" id="testPushBtn">
                Kirim Notifikasi
            </button> -->
        </div>
    </div>
</div>