<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- PWA -->
    <link rel="manifest" href="/build/manifest.webmanifest">
    <meta name="theme-color" content="#1B94D7">
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Onboarding') — MoneyMate</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <!-- Framework CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app/onboarding.css') }}">
    @stack('styles')
</head>
<body>
    <div class="onboarding-wrapper">
        {{-- Header --}}
        <header class="onboarding-header border-bottom">
            <div class="container-fluid d-flex align-items-center py-3">
                
            <div class="col-4 d-flex justify-content-start">
                <img src="{{ asset('images/moneymate-original.png') }}" alt="MoneyMate" style="height: 40px;">
            </div>

            <div class="col-4 text-center">
                <h1 class="m-0 h4">@yield('page-title', 'MoneyMate')</h1>
            </div>

            <div class="col-4 d-flex justify-content-end">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Batal</button>
                </form>
            </div>

            </div>
        </header>

        {{-- Stepper --}}
        <div class="onboarding-stepper">
            <div class="stepper-item">
                <div class="stepper-circle @if(request()->is('onboarding/persetujuan*')) active @elseif(request()->is('onboarding/kuisioner*')) done @endif">1</div>
                <span class="stepper-label @if(request()->is('onboarding/persetujuan*')) active @elseif(request()->is('onboarding/kuisioner*')) done @endif">Persetujuan</span>
            </div>
        </div>

        {{-- Content --}}
        @yield('content')
    </div>

    <script src="{{ asset('js/button-loading.js') }}"></script>
    @stack('scripts')
</body>
</html>