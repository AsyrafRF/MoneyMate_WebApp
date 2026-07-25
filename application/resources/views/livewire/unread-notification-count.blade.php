<div class="dropdown">

    {{-- Tombol Bell --}}
    <a href="#" 
       class="notification-link position-relative"
       data-bs-toggle="dropdown"
       aria-expanded="false">

        <i class="bi bi-bell-fill fs-5"></i>

        <span wire:poll.5s="updateCount">
            @if($unreadCount > 0)
                <span class="notification-badge">
                    {{ $unreadCount }}
                </span>
            @endif
        </span>
    </a>

    {{-- Dropdown --}}
    <div wire:ignore.self
         class="dropdown-menu dropdown-menu-end p-0 shadow"
         style="width: 350px; max-height: 500px; overflow-y:auto;">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h6 class="mb-0">Notifications</h6>
        </div>

        {{-- Isi Notifikasi --}}
        @forelse($latestNotifications as $notif)

            <div class="p-3 border-bottom">

                <div class="fw-semibold">
                    {{ $notif->summary ?? 'Notifikasi' }}
                </div>

                <div class="small text-muted">
                    {{ $notif->sender }}
                </div>

                <div class="small text-secondary mt-1">
                    {{ $notif->created_at->diffForHumans() }}
                </div>

                {{-- Tombol lihat lengkap --}}
                <div class="mt-2">
                    <button type="button" 
                            wire:click="$dispatch('trigger-view-detail', { notifId: '{{ $notif->notif_id }}' })"
                            class="btn btn-link p-0 text-decoration-none small {{ $isNotificationPage ? 'text-muted' : 'text-primary' }}"
                            {{ $isNotificationPage ? 'disabled' : '' }}>
                        Lihat lengkap
                    </button>
                </div>

            </div>

        @empty

            <div class="p-3 text-center text-muted">
                Tidak ada notifikasi
            </div>

        @endforelse

        {{-- Footer --}}
        <div class="p-2 border-top text-center bg-light">
            <a href="{{ route('notifications.index') }}"
               class="text-decoration-none fw-semibold">
                Lihat semuanya
            </a>
        </div>

    </div>
</div>