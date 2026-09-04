<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SI MOPANG') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('images/logo-tikpolri.png') }}?v=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hex-bg {
            background-color: #111827;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(200,16,46,0.10), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(191,195,200,0.08), transparent 40%),
                linear-gradient(135deg, #111827 0%, #1F2937 50%, #374151 100%);
        }
        .glass-card {
            background: rgba(31, 41, 55, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(75, 85, 99, 0.6);
        }
        .watermark-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 700px;
            max-width: 90vw;
            opacity: 0.05;
            pointer-events: none;
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(107, 114, 128, 0.4);
            color: #E5E7EB;
        }
        .input-glass option {
            background: #374151;
            color: #E5E7EB;
        }
        .input-glass::placeholder { color: #A8ADB4; }
        .input-glass:focus {
            outline: none;
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="hex-bg min-h-screen relative flex items-center justify-center overflow-hidden px-4 py-10">

        <img src="{{ asset('images/logo-tikpolri.png') }}" alt="" class="watermark-logo">

        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#C8102E] to-transparent"></div>

        <div class="relative z-10 w-full max-w-md">

            <div class="flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo-tikpolri.png') }}" alt="Logo TIK Polri" class="w-20 h-20 object-contain mb-3">
                <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide">SI MOPANG</h1>
                <p class="text-xs text-[#A8ADB4] mt-1 text-center">Sistem Informasi dan Monitoring Penyerapan Anggaran</p>
                <p class="text-[10px] text-[#BFC3C8] mt-0.5 tracking-widest uppercase"> BIDANG TIK POLDA JATIM</p>
            </div>

            <div class="glass-card rounded-2xl shadow-2xl px-8 py-8">
                {{ $slot }}
            </div>

            <p class="text-center text-[10px] text-[#A8ADB4] mt-6">
                &copy; {{ date('Y') }} Bidang Teknologi Informasi dan Komunikasi — Polda Jawa Timur
            </p>
        </div>
    </div>
</body>
</html>
