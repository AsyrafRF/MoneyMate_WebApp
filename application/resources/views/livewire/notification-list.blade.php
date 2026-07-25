<div x-data="notificationList">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-3 flex-column flex-md-row gap-2">
            <div class="flex-grow-1 text-center text-md-start flex-column">
                <h4 class="fw-bold mb-0" style="color: #102F4B;">
                    <i class="bi bi-bell-fill"></i> Daftar Notifikasi
                </h4>
                @if($monthFilter)
                    <span class="badge bg-info bg-general-gradient">
                        Filter: {{ $monthFilter }}
                    </span>
                @endif
            </div>

            <div class="flex-grow-1 text-center text-md-end">
                <button class="btn btn-outline-secondary btn-sm me-1" style="color: #102F4B;"
                        data-bs-toggle="modal" data-bs-target="#notifCalendarModal">
                    <i class="bi bi-calendar"></i>
                </button>
                <button class="btn btn-outline-secondary btn-sm" style="color: #102F4B;"
                        data-bs-toggle="modal" data-bs-target="#notifSettingsModal">
                    <i class="bi bi-gear"></i>
                </button>
            </div>
        </div>

        {{-- LIST NOTIFIKASI --}}
        <div id="notification-list">
            @forelse($notifications as $month => $items)
                <div class="mb-3 mt-4 notif-month" data-month="{{ $month }}">
                    <h5 class="fw-bold" style="color: #1B94D7;">
                        <i class="bi bi-calendar3"></i> {{ $month }}
                    </h5>
                    <hr>
                </div>

                @foreach($items as $notif)
                    <div class="card mb-3 shadow-sm border-dark rounded rounded-5
                        {{ $notif->is_read ? 'opacity-75' : 'border-start border-4 border-primary' }}
                        {{ (isset($newNotifId) && $newNotifId == $notif->notif_id) ? 'new-notif' : '' }}"
                         wire:key="notif-{{ $notif->notif_id }}">
                        <div class="card-body d-flex justify-content-between align-items-start notif-card rounded rounded-5">
                            <div class="notif-content me-3 w-100">
                                <div class="d-flex align-items-center mb-1">
                                    <strong class="me-2">{{ $notif->summary }}</strong>
                                </div>
                                <div>
                                    <a href="#" wire:click.prevent="viewDetail('{{ $notif->notif_id }}')"
                                       class="fw-bold lihat-detail" style="color: #1B94D7">
                                        Lihat Selengkapnya
                                    </a>
                                </div>
                                <small class="text-muted">
                                    Dari {{ $notif->sender ?? 'Sistem' }} • {{ $notif->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="notif-badge d-flex align-items-center mb-1 me-3">
                                @unless($notif->is_read)
                                    <span class="badge bg-success">BARU</span>
                                @endunless
                                <span class="badge bg-secondary bg-general-gradient ms-2 text-uppercase">
                                    {{ $notif->type }}
                                </span>
                            </div>
                            <div class="notif-date small text-muted fw-semibold"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="{{ $notif->created_at->translatedFormat('d M Y • H:i') }}">
                                {{ $notif->created_at->translatedFormat('d M Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach

            @empty
                <div class="text-center py-5 text-muted" id="empty-notif-state">
                    <i class="bi bi-bell-slash fs-1"></i>
                    <p class="mt-3">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pemanggilan Komponen Modal --}}
    <x-notification-modals :monthFilter="$monthFilter" :selectedNotif="$selectedNotif" />

</div>

{{-- Pemanggilan CSS & JS termodulasi --}}
@include('livewire.notification-list.partials.styles')
@include('livewire.notification-list.partials.scripts')