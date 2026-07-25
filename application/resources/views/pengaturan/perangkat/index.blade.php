@extends('layouts.app')

@section('title', 'Pengaturan Sesi')

@section('content')
<div class="container py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h2 class="fw-bold text-dark mb-1">Manajemen Perangkat</h2>
        <p class="text-muted mb-0">
            Kelola perangkat yang sedang login ke akun Anda.
        </p>
    </div>

    {{-- Alert Security --}}
    <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-start gap-3 mb-4">
        <div class="fs-3">🔐</div>
        <div>
            <h6 class="fw-semibold mb-1">Keamanan Akun</h6>
            <small class="text-muted">
                Jika Anda melihat perangkat yang tidak dikenali, segera keluarkan perangkat tersebut untuk menjaga keamanan akun keuangan Anda.
            </small>
        </div>
    </div>

    {{-- Device List --}}
    <div class="row g-4">
        @foreach($devices as $device)

            @php
                $isCurrent = $device->session_id === $currentSessionId;
                $platform = strtolower($device->platform);

                // Default icon (Laptop/Generic)
                $icon = 'bi-laptop';

                if (str_contains($platform, 'android') || str_contains($platform, 'iphone')) {
                    $icon = 'bi-phone';
                } elseif (str_contains($platform, 'windows')) {
                    $icon = 'bi-display'; // Ikon monitor desktop
                } elseif (str_contains($platform, 'mac')) {
                    $icon = 'bi-apple';   // Atau tetap 'bi-laptop' jika ingin netral
                }
            @endphp

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 device-card">

                    <div class="card-body p-4">

                        {{-- Top --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div class="d-flex gap-3">
                                <div class="device-icon">
                                    <i class="bi {{ $icon }} {{ $isCurrent ? 'text-success' : 'text-secondary' }}" 
                                       style="font-size: 1.5rem;"></i>
                                </div>

                                <div>
                                    <h5 class="fw-bold mb-1 text-dark">
                                        {{ $device->device_name }}
                                    </h5>

                                    <div class="text-muted small">
                                        {{ $device->browser }}
                                        •
                                        {{ $device->platform }}
                                    </div>
                                </div>
                            </div>

                            @if($isCurrent)
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    Sedang Aktif
                                </span>
                            @endif

                        </div>

                        {{-- Info --}}
                        <div class="device-info">

                            <div class="info-item">
                                <span class="label">IP Address</span>
                                <span class="value">{{ $device->ip_address }}</span>
                            </div>

                            @if(isset($device->last_active))
                            <div class="info-item">
                                <span class="label">Aktivitas Terakhir</span>
                                <span class="value">
                                    {{ \Carbon\Carbon::parse($device->last_active)->diffForHumans() }}
                                </span>
                            </div>
                            @endif

                        </div>

                        {{-- Action --}}
                        @unless($isCurrent)
                            <div class="mt-4">
                                <form action="{{ route('perangkat.logout', $device->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger w-100 rounded-3 fw-semibold"
                                        onclick="return confirm('Yakin ingin mengeluarkan perangkat ini?')"
                                    >
                                        Keluarkan Perangkat
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mt-4">
                                <button
                                    class="btn btn-light border w-100 rounded-3 fw-semibold text-success"
                                    disabled
                                >
                                    Perangkat yang Sedang Digunakan
                                </button>
                            </div>
                        @endunless

                    </div>
                </div>
            </div>

        @endforeach
    </div>
</div>
@endsection