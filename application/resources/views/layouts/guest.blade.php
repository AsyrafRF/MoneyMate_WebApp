<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA -->
    <link rel="manifest" href="/build/manifest.webmanifest">
    <meta name="theme-color" content="#1B94D7">
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Dinamis Title -->
    <title>@yield('title', config('app.name', 'MoneyMate'))</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- AOS (Animate on Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        .auth-container { animation: fadeInUp 0.8s ease-out; }
        .logo { transition: transform 0.3s ease; }
        .logo:hover { transform: scale(1.05); }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
        }
        .btn-primary { background-color: #3182ce; border: none; transition: all 0.3s ease; }
        .btn-primary:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(49, 130, 206, 0.3);
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-control:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 0.2rem rgba(49, 130, 206, 0.25);
        }
    </style>
</head>
<body>
    <div class="container auth-container text-center" data-aos="zoom-in">
        <div class="mb-4">
            <a href="/" class="d-inline-block">
                <img src="{{ asset('images/moneymate-original.png') }}" 
                     alt="Logo" 
                     class="logo" 
                     style="height: 7rem;">
            </a>
        </div>

        <div class="card mx-auto" data-aos="fade-up" style="max-width: 420px;">
            <div class="card-body p-4">
                {{-- Mendukung dua metode pemanggilan sekaligus --}}
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true });
    </script>
    
    {{-- Script Tambahan --}}
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/loadingtombolhandler.js') }}"></script>
    <x-loading-overlay />
</body>
</html>