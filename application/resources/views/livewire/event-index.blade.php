<div>
    {{-- Custom CSS khusus halaman Event --}}
    @assets
    <style>
        .event-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        }
        .event-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 200px;
        }
        .event-img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: scale 0.5s ease;
        }
        .event-card:hover .event-img {
            scale: 1.05;
        }
        .badge-live {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #ff4757;
            color: white;
            padding: 6px 12px;
            font-weight: bold;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-back {
            border-radius: 20px;
            padding: 8px 20px;
        }
        .detail-img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 16px;
            width: 100%;
        }
        /* Style Tambahan untuk Empty State */
        .empty-state-icon {
            font-size: 4.5rem;
            background: linear-gradient(45deg, #6c757d, #adb5bd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
    </style>
    @endassets

    <div class="container py-5">
        
        {{-- KONDISI 1: TAMPILKAN DAFTAR EVENT --}}
        @if(is_null($selectedEventId))
            <div class="row mb-4">
                <div class="col">
                    <h2 class="fw-bold text-dark">🔴 Pemberitahuan & Event Berlangsung</h2>
                    <p class="text-muted">Ikuti berbagai event seru di MoneyMate dan raih keuntungannya!</p>
                </div>
            </div>

            <div class="row g-4">
                {{-- Mengubah @foreach menjadi @forelse untuk menangani Empty State --}}
                @forelse($events as $event)
                    <div class="col-md-6 col-lg-4" wire:key="event-{{ $event['id'] }}">
                        <div class="card h-100 shadow-sm event-card" wire:click="showDetail({{ $event['id'] }})">
                            <div class="event-img-wrapper">
                                <span class="badge-live"><i class="fas fa-circle-notch fa-spin me-1"></i> Ongoing</span>
                                <img src="{{ str_contains($event->image, 'http') ? $event->image : asset('storage/' . $event->image) }}" 
                                     class="event-img" alt="{{ $event['title'] }}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <span class="text-primary small fw-semibold mb-1">
                                    <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y H.i') }} WIB - {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y H.i') }} WIB
                                </span>
                                <h5 class="card-title fw-bold text-dark text-truncate">{{ $event['title'] }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($event['description'], 100, '...') }}
                                </p>
                                <div class="mt-3 text-end text-primary fw-semibold small">
                                    Lihat Detail <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- BLOK EMPTY STATE (Muncul jika array/collection $events kosong) --}}
                    <div class="col-12 user-select-none">
                        <div class="card border-0 shadow-sm text-center p-5" style="border-radius: 16px;">
                            <div class="card-body py-4">
                                <div class="empty-state-icon mb-3 animate__animated animate__bounceIn">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-2">Belum Ada Event Tersedia</h4>
                                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                    Saat ini belum ada event aktif yang berlangsung. Hubungi admin atau kembali lagi nanti untuk melihat update event terbaru dari MoneyMate!
                                </p>
                                <button class="btn btn-primary px-4 py-2 fw-semibold shadow-sm" style="border-radius: 12px;" wire:click="$refresh">
                                    <i class="bi bi-arrow-clockwise"></i> Segarkan Halaman
                                </button>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

        {{-- KONDISI 2: TAMPILKAN DETAIL EVENT --}}
        @else
            @if($selectedEvent)
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <button class="btn btn-outline-secondary btn-back mb-4 shadow-sm" wire:click="backToList">
                            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                        </button>

                        <div class="card border-0 shadow-sm p-4 style-detail mb-4" style="border-radius: 16px;">
    
                            <img src="{{ str_contains($selectedEvent->image, 'http') ? $selectedEvent->image : asset('storage/' . $selectedEvent->image) }}" 
                                class="detail-img mb-4 shadow-sm" 
                                alt="{{ $selectedEvent->title }}">
                            
                            <span class="badge bg-danger align-self-start mb-2 px-3 py-2 rounded-pill">Event Sedang Berlangsung</span>
                            <h1 class="fw-bold text-dark mb-2">{{ $selectedEvent->title }}</h1>
                            
                            <p class="text-primary fw-medium mb-4">
                                <i class="bi bi-calendar3"></i> Periode: {{ \Carbon\Carbon::parse($selectedEvent->start_date)->translatedFormat('d F Y H.i') }} WIB s/d {{ \Carbon\Carbon::parse($selectedEvent->end_date)->translatedFormat('d F Y H.i') }} WIB
                            </p>

                            <h5 class="fw-bold text-dark">Deskripsi & Pemberitahuan</h5>
                            <p class="text-muted" style="line-height: 1.7;">
                                {!! nl2br(e($selectedEvent->description)) !!}
                            </p>

                            {{-- Cek apakah ada gambar deskripsi tambahan / QR Code --}}
                            @if(!empty($selectedEvent->description_image))
                                <div class="my-3 text-center">
                                    <img src="{{ str_contains($selectedEvent->description_image, 'http') ? $selectedEvent->description_image : asset('storage/' . $selectedEvent->description_image) }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         alt="Ilustrasi Deskripsi" 
                                         style="max-height: 300px;">
                                </div>
                            @endif

                            <hr class="my-4 text-muted">

                            <h5 class="fw-bold text-dark mb-3">Syarat & Ketentuan</h5>
                            <div class="bg-light p-3 rounded-3 text-muted card-text">
                                {!! nl2br(e($selectedEvent->terms)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
</div>