<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{ asset('images/logo-tikpolri.png') }}?v=1" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .app-bg {
                background-color: #111827;
                background-image:
                    radial-gradient(circle at 15% 10%, rgba(200,16,46,0.08), transparent 35%),
                    radial-gradient(circle at 85% 90%, rgba(191,195,200,0.08), transparent 35%),
                    linear-gradient(135deg, #111827 0%, #1F2937 50%, #374151 100%);
            }

            .justify-title {
                    display: block;
                    text-align: justify;
                    text-align-last: justify;
                    width: 100%;
            }
        </style>
    </head>
    <body class="font-sans antialiased app-bg min-h-screen">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-polri-dark/80 backdrop-blur-md border-b border-polri-dark-light">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="text-polri-gray">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
