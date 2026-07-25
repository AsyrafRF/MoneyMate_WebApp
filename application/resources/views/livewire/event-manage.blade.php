<div class="py-5 bg-light min-vh-screen">
    <div class="container-xl">
        
        @if (session()->has('success'))
            <div class="alert alert-success border-start border-4 border-success d-flex align-items-center justify-content-between p-3 mb-4 shadow-sm" 
                 x-data="{ show: true }" x-show="show" x-transition>
                <div class="d-flex align-items-center">
                    <svg class="bi flex-shrink-0 me-2" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="fw-medium small">{{ session('success') }}</span>
                </div>
                <button @click="show = false" type="button" class="btn-close text-success focus-none shadow-none" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            
            <div class="card-header bg-white border-bottom border-light p-4 d-sm-flex align-items-center justify-content-between">
                <div>
                    <h2 class="h4 fw-bold text-dark mb-1">Manajemen Event</h2>
                    <p class="text-muted small mb-0">Kelola data event, upload banner, QR Code kuis, dan jadwal pelaksanaan.</p>
                </div>
                <div class="mt-3 mt-sm-0">
                    <button wire:click="create" class="btn btn-indigo px-4 py-2 fw-semibold d-inline-flex align-items-center shadow-sm">
                        <svg class="bi me-2" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Event Baru
                    </button>
                </div>
            </div>

            <div class="card-body bg-light bg-opacity-50 border-bottom border-light p-4">
                <div class="position-relative style-search-box">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input wire:model.live="search" type="text" placeholder="Cari berdasarkan judul atau deskripsi..." class="form-control ps-5 py-2 text-sm border-2-focus">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-sm">
                    <thead class="table-light text-uppercase tracking-wider small fw-bold text-secondary border-bottom">
                        <tr>
                            <th scope="col" class="p-3 ps-4">Banner / Judul</th>
                            <th scope="col" class="p-3">Tanggal Pelaksanaan</th>
                            <th scope="col" class="p-3">Status</th>
                            <th scope="col" class="p-3 pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse($events as $event)
                            <tr class="transition-colors">
                                <td class="p-3 ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 overflow-hidden border border-light bg-light flex-shrink-0 style-thumb">
                                            @if($event->image)
                                                <img src="{{ str_contains($event->image, 'http') ? $event->image : asset('storage/' . $event->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full d-flex align-items-center justify-content-center text-muted small-xxs">No Img</div>
                                            @endif
                                        </div>
                                        <div class="style-max-width-md">
                                            <div class="fw-semibold text-dark text-truncate" title="{{ $event->title }}">{{ $event->title }}</div>
                                            <div class="text-muted small text-truncate mt-1">{{ Str::limit($event->description, 80) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3">
                                    <div class="small fw-semibold text-dark">{{ $event->start_date }}</div>
                                    <div class="small text-muted">s/d {{ $event->end_date }}</div>
                                </td>
                                <td class="p-3">
                                    <button wire:click="toggleStatus({{ $event->id }})" class="btn rounded-pill px-2.5 py-1 small fw-semibold d-inline-flex align-items-center gap-1.5 border-0 style-status-btn {{ $event->is_active ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }}">
                                        <span class="rounded-circle d-inline-block style-dot {{ $event->is_active ? 'bg-success' : 'bg-danger' }}"></span>
                                        {{ $event->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </td>
                                <td class="p-3 pe-4 text-end whitespace-nowrap">
                                    <button wire:click="edit({{ $event->id }})" class="btn btn-link text-indigo text-decoration-none fw-medium p-0 me-3 d-inline-flex align-items-center gap-1 small">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button onclick="confirm('Apakah Anda yakin ingin menghapus event ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $event->id }})" class="btn btn-link text-danger text-decoration-none fw-medium p-0 d-inline-flex align-items-center gap-1 small">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-5 text-center text-muted">
                                    <svg class="text-secondary opacity-50 mb-3" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mb-0">Tidak ada event ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-top border-light p-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>

    @if($isOpen)
        <div class="modal d-block show bg-dark bg-opacity-50 overflow-auto style-fade-in" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered p-3 style-slide-up" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <form wire:submit.prevent="save">
                        
                        <div class="modal-header border-bottom border-light px-4 py-3 d-flex align-items-center justify-content-between bg-white">
                            <h3 class="modal-title h5 fw-bold text-dark" id="modal-title">
                                {{ $eventId ? 'Edit Event' : 'Tambah Event Baru' }}
                            </h3>
                            <button type="button" wire:click="closeModal" class="btn-close shadow-none" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-4 bg-white">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label style-form-label mb-2">Judul Event</label>
                                    <input type="text" wire:model="title" class="form-control py-2 text-sm border-2-focus">
                                    @error('title') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label style-form-label mb-2">Deskripsi Event</label>
                                    <textarea wire:model="description" rows="5" class="form-control py-2 text-sm border-2-focus"></textarea>
                                    @error('description') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label style-form-label mb-2">Waktu Mulai</label>
                                    <input type="datetime-local" wire:model="start_date" class="form-control py-2 text-sm border-2-focus">
                                    @error('start_date') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label style-form-label mb-2">Waktu Selesai</label>
                                    <input type="datetime-local" wire:model="end_date" class="form-control py-2 text-sm border-2-focus">
                                    @error('end_date') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label style-form-label mb-2">Banner Event (Rekomendasi 16:9)</label>
                                    <div class="d-flex flex-column gap-2">
                                        @if ($image)
                                            <div class="position-relative bg-light rounded-3 overflow-hidden border style-preview-box">
                                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                            </div>
                                        @elseif ($existingImage)
                                            <div class="position-relative bg-light rounded-3 overflow-hidden border style-preview-box">
                                                <img src="{{ str_contains($existingImage, 'http') ? $existingImage : asset('storage/' . $existingImage) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <input type="file" wire:model="image" class="form-control form-control-sm cursor-pointer style-file-input">
                                    </div>
                                    @error('image') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label style-form-label mb-2">QR Code / Detail Gambar (Opsional)</label>
                                    <div class="d-flex flex-column gap-2">
                                        @if ($description_image)
                                            <div class="position-relative bg-light rounded-3 overflow-hidden border p-2 d-flex align-items-center justify-content-center style-preview-box">
                                                <img src="{{ $description_image->temporaryUrl() }}" class="max-h-100 style-object-contain">
                                            </div>
                                        @elseif ($existingDescriptionImage)
                                            <div class="position-relative bg-light rounded-3 overflow-hidden border p-2 d-flex align-items-center justify-content-center style-preview-box">
                                                <img src="{{ str_contains($existingDescriptionImage, 'http') ? $existingDescriptionImage : asset('storage/' . $existingDescriptionImage) }}" class="max-h-100 style-object-contain">
                                            </div>
                                        @endif
                                        <input type="file" wire:model="description_image" class="form-control form-control-sm cursor-pointer style-file-input">
                                    </div>
                                    @error('description_image') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label style-form-label mb-2">Syarat & Ketentuan (Tulis dan pisahkan per baris)</label>
                                    <textarea wire:model="terms" rows="4" placeholder="Contoh:&#10;1. Terbuka khusus Mahasiswa Batam&#10;2. Hadir 15 menit sebelum dimulai" class="form-control py-2 text-sm border-2-focus"></textarea>
                                    @error('terms') <span class="text-danger small mt-1 d-block fw-medium">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-12 d-flex align-items-center mt-3">
                                    <button type="button" wire:click="$toggle('is_active')" class="btn p-0 border-0 style-toggle-switch {{ $is_active ? 'active-indigo' : 'bg-secondary-light' }}">
                                        <span class="style-toggle-dot {{ $is_active ? 'translate-dot' : '' }}"></span>
                                    </button>
                                    <span class="ms-3 small fw-medium text-dark">Aktifkan Event Langsung</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-end gap-2 border-top-0">
                            <button type="button" wire:click="closeModal" class="btn btn-white border px-4 py-2 small fw-medium">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="btn btn-indigo px-4 py-2 small fw-medium shadow-sm d-inline-flex align-items-center">
                                <span wire:loading.remove wire:target="save">Simpan</span>
                                <span wire:loading wire:target="save" class="d-flex align-items-center">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Memproses...
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    /* Custom Indigo Brand Palette */
    .btn-indigo { background-color: #4f46e5; color: #fff; border: 1px solid #4f46e5; transition: all 0.2s ease-in-out; }
    .btn-indigo:hover { background-color: #4338ca; border-color: #4338ca; color: #fff; }
    .text-indigo { color: #4f46e5; }
    .text-indigo:hover { color: #3730a3; }
    .border-2-focus:focus { border-color: #818cf8 !important; box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.2) !important; }
    
    /* Layout Helpers */
    .text-sm { font-size: 0.875rem !important; }
    .small-xxs { font-size: 10px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .whitespace-nowrap { white-space: nowrap; }
    .object-cover { object-fit: cover; }
    .w-full { width: 100%; }
    .h-full { height: 100%; }
    .max-h-100 { max-height: 100%; }
    .style-object-contain { object-fit: contain; }
    .cursor-pointer { cursor: pointer; }
    .focus-none:focus { box-shadow: none !important; }
    
    /* Box & Dimensions */
    .style-search-box { max-width: 448px; }
    .style-thumb { width: 64px; height: 40px; }
    .style-max-width-md { max-width: 448px; }
    .style-preview-box { width: 100%; height: 128px; }
    
    /* Soft Badges Warna */
    .bg-success-light { background-color: #d1fae5; }
    .bg-danger-light { background-color: #ffe4e6; }
    .bg-secondary-light { background-color: #e5e7eb; }
    .style-status-btn { padding: 0.25rem 0.625rem !important; }
    .style-dot { width: 6px; height: 6px; }
    
    /* Form Label Styling */
    .style-form-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; color: #4b5563; text-transform: uppercase; }
    
    /* Custom CSS Toggle Switch */
    .style-toggle-switch { position: relative; display: inline-flex; height: 24px; width: 44px; flex-shrink: 0; cursor: pointer; border-radius: 9999px; transition: background-color 0.2s ease-in-out; background-color: #e5e7eb;}
    .style-toggle-switch.active-indigo { background-color: #4f46e5; }
    .style-toggle-dot { pointer-events: none; display: inline-block; height: 20px; width: 20px; background-color: #ffffff; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s ease-in-out; position: absolute; top: 2px; left: 2px; }
    .translate-dot { transform: translateX(20px); }
    
    /* File input bootstrap small patch */
    .style-file-input::-webkit-file-upload-button { font-size: 0.75rem; background-color: #e0e7ff; color: #4338ca; font-weight: 600; border: none; border-radius: 0.25rem; }
    .style-file-input::-webkit-file-upload-button:hover { background-color: #c7d2fe; }

    /* Modal Animation Helper */
    .style-fade-in { animation: fadeIn 0.15s ease-out; }
    .style-slide-up { animation: slideUp 0.2s ease-out; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>
@endpush