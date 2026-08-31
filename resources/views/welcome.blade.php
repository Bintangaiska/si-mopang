<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMOPANG - Bid TIK Polda Jatim</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* .hex-bg {
            background-color: #071D49;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(200,16,46,0.10), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(191,195,200,0.10), transparent 40%),
                repeating-linear-gradient(60deg, rgba(217,217,217,0.05) 0, rgba(217,217,217,0.05) 1px, transparent 1px, transparent 40px),
                repeating-linear-gradient(-60deg, rgba(217,217,217,0.05) 0, rgba(217,217,217,0.05) 1px, transparent 1px, transparent 40px);
        } */
        /* .hex-bg {
            background-color: #111827;

            background-image:
                radial-gradient(circle at 20% 20%, rgba(200,16,46,0.08), transparent 35%),
                radial-gradient(circle at 80% 80%, rgba(191,195,200,0.08), transparent 35%),
                linear-gradient(
                    135deg,
                    #111827 0%,
                    #1F2937 50%,
                    #374151 100%
                );
        } */
        .hex-bg {
            background-color: #111827;

            background-image:
                radial-gradient(circle at 20% 20%, rgba(200,16,46,0.10), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.03), transparent 40%),
                repeating-linear-gradient(
                    60deg,
                    rgba(255,255,255,0.03) 0,
                    rgba(255,255,255,0.03) 1px,
                    transparent 1px,
                    transparent 40px
                ),
                repeating-linear-gradient(
                    -60deg,
                    rgba(255,255,255,0.03) 0,
                    rgba(255,255,255,0.03) 1px,
                    transparent 1px,
                    transparent 40px
                );
        }
        /* .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(191, 195, 200, 0.2);
        } */
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
            width: 800px;
            max-width: 90vw;
            opacity: 0.04;
            pointer-events: none;
        }
    </style>
</head>
<body class="font-sans antialiased hex-bg min-h-screen relative overflow-x-hidden">

    <img src="{{ asset('images/logo-tikpolri.png') }}" alt="" class="watermark-logo">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-polri-red to-transparent"></div>

    {{-- Navbar --}}
    <nav class="relative z-10 border-b border-gray-700 bg-gray-900/50 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img
                        src="{{ asset('images/logo-tikpolri.png') }}"
                        class="h-12 w-12 object-contain"
                        alt="Logo TIK Polri"
                    >

                <div class="flex flex-col leading-none">
                    <span class="text-[28px] tracking-[0.4em] font-black text-white">
                        SIMOPANG
                    </span>

                    <span class="text-[8px] uppercase tracking-[0.2em] text-polri-silver">
                        Sistem Monitoring Penyerapan Anggaran
                    </span>
                </div>
            </div>
            <div class="space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 text-sm bg-gradient-to-r from-polri-red to-polri-navy text-white rounded-lg hover:opacity-90 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm bg-gradient-to-r from-polri-red to-polri-navy text-white rounded-lg hover:opacity-90 transition">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm bg-gradient-to-r from-polri-red to-polri-navy text-white rounded-lg hover:opacity-90 transition">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <!-- <div class="relative z-10 max-w-5xl mx-auto px-6 py-20 text-center">
        <p class="text-xs text-polri-silver-dark tracking-widest uppercase mb-3">Kepolisian Negara Republik Indonesia Daerah Jawa Timur</p>
        <!-- <h1 class="text-4xl md:text-5xl font-bold text-polri-gray mb-5 leading-tight"> -->
        <!-- <h1 class="text-4xl md:text-5xl font-bold text-white mb-5 leading-tight">
            Sistem Informasi dan Monitoring<br>Penyerapan Anggaran
        </h1>
        <p class="text-polri-silver-dark max-w-2xl mx-auto mb-8 text-sm md:text-base">
            Mendukung optimalisasi pencapaian nilai IKPA pada Satker Bid TIK Polda Jatim melalui
            digitalisasi pengajuan, monitoring, dan realisasi anggaran secara terstruktur dan tepat waktu.
        </p>
        @guest
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-polri-red to-polri-navy text-white text-sm font-semibold rounded-lg hover:opacity-90 transition tracking-wide">
                MASUK KE SISTEM
            </a>
        @endguest

        <!-- <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl mx-auto">

        <div class="glass-card rounded-xl p-4">
            <p class="text-gray-400 text-xs">Total Satker</p>
            <p class="text-2xl font-bold text-white">4</p>
        </div>

        <div class="glass-card rounded-xl p-4">
            <p class="text-gray-400 text-xs">Pengajuan Aktif</p>
            <p class="text-2xl font-bold text-white">48</p>
        </div>

        <div class="glass-card rounded-xl p-4">
            <p class="text-gray-400 text-xs">Penyerapan Anggaran</p>
            <p class="text-2xl font-bold text-red-500">87%</p>
        </div>
</div> -->
    {{-- Hero --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 py-24">

        <div class="grid lg:grid-cols-2 gap-12 items-start">

            <!-- Kiri: Teks -->
            <div class="pt-6">

                <p class="text-xs text-gray-400 tracking-widest uppercase tracking-[0.2em] text-justify">
                    BIDANG TEKNOLOGI INFORMASI DAN KOMUNIKASI - POLDA JAWA TIMUR
                </p>

                <h1 class="text-5xl lg:text-6xl font-bold text-white leading-tight mb-6 text-justify [text-align-last:left] max-w-[650px]">
                    Sistem Informasi dan Monitoring Penyerapan Anggaran
                </h1>

                <p class="text-gray-400 text-lg leading-relaxed mb-8 max-w-xl text-justify [text-align-last:left]">
                    Mendukung optimalisasi pencapaian nilai IKPA pada Satker Bidang
                    Teknologi Informasi dan Komunikasi Polda Jawa Timur melalui
                    digitalisasi pengajuan, monitoring, dan realisasi anggaran secara
                    terstruktur, transparan, dan tepat waktu.
                </p>
               
                @guest
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center px-10 py-3.5 bg-gradient-to-r from-polri-red to-polri-navy text-white rounded-xl hover:opacity-90 transition font-semibold text-base shadow-lg">
                        Masuk ke Sistem
                    </a>
                @endguest

            </div>

            <!-- Kanan: Foto Profil -->
            <div class="flex justify-center lg:justify-end mt-6 lg:-mt-10">

                <!-- Frame Gradient (Tanpa efek rotate/miring) -->
                <div class="p-[5px] rounded-[30px] bg-gradient-to-br from-red-700 via-gray-500 to-slate-900 shadow-[0_0_50px_rgba(200,16,46,0.30)] w-full max-w-md">

                    <!-- Card Inner -->
                    <div class="glass-card rounded-[25px] p-8 flex flex-col items-center w-full">

                        <!-- Container Foto: Kotak gelap/background dihilangkan (transparan) -->
                        <div class="w-full h-[400px] flex justify-center items-end mb-6 overflow-hidden">

                             <!-- Glow Blur -->
                            <div class="absolute bottom-0 left-1/2 -translate-x-1/2
                                        w-64 h-24
                                        bg-white/10
                                        blur-3xl
                                        rounded-full
                                        z-10">
                            </div>

                            <img
                                src="{{ asset('images/kabidNew.png') }}"
                                alt="Kabid TIK"
                                class="w-full h-full object-cover object-top block"
                                style="
                                    -webkit-mask-image: linear-gradient(
                                        to bottom,
                                        rgba(0,0,0,1) 0%,
                                        rgba(0,0,0,1) 65%,
                                        rgba(0,0,0,0.7) 80%,
                                        rgba(0,0,0,0) 100%
                                    );
                                    mask-image: linear-gradient(
                                        to bottom,
                                        rgba(0,0,0,1) 0%,
                                        rgba(0,0,0,1) 65%,
                                        rgba(0,0,0,0.7) 80%,
                                        rgba(0,0,0,0) 100%
                                    );
                                ">

                        </div>

                        <!-- Info Teks -->
                        <div class="border-t border-white/10 pt-6 w-full text-center mt-auto">
                            <h3 class="text-white font-bold text-2xl">
                                Kombes Pol. Agusman Gurning, S.H., S.I.K, M.H.
                            </h3>
                            <p class="text-gray-400 text-sm mt-2 leading-relaxed">
                                Kepala Bidang Teknologi Informasi dan Komunikasi
                                <br>
                                Polda Jawa Timur
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Dasar hukum -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 pb-16">
            <div class="text-center mb-10">
                <p class="text-2xl text-polri-red tracking-widest uppercase mb-2">
                    Dasar Hukum
                </p>
                <h2 class="text-2xl md:text-3xl font-bold text-white">
                    Landasan Pelaksanaan Anggaran
                </h2>
            </div>

            <div class="glass-card rounded-2xl p-8">
                <div class="space-y-5">
                    <div class="flex gap-4">
                        <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">
                            1
                        </span>
                    <p class="text-polri-silver leading-relaxed text-justify">
                        Peraturan Pemerintah Nomor 45 Tahun 2011 tentang Pelaksanaan APBN.
                    </p>
                    </div>
                </div>
            

                <div class="space-y-5">
                    <div class="flex gap-4">
                        <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">
                            2
                        </span>
                    <p class="text-polri-silver leading-relaxed text-justify">
                        Peraturan Menteri Keuangan Nomor 41 Tahun 2026 tentang Perubahan
                        Kedua atas Peraturan Menteri Keuangan Nomor 62 Tahun 2023 tentang
                        Perencanaan Anggaran, Pelaksanaan Anggaran, serta Akuntansi dan
                        Pelaporan Keuangan.
                    </p>
                    </div>
                </div>
            

                <div class="space-y-5"></div>
                    <div class="flex gap-4">
                        <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">
                            3
                        </span>
                    <p class="text-polri-silver leading-relaxed text-justify">
                        DIPA Bidang Teknologi Informasi dan Komunikasi Polda Jawa Timur
                        Tahun Anggaran 2026.
                    </p>
                    </div> 
                </div>
            </div>
        </div>

     <!-- Tata Cara Pengajuan -->
    <div class="relative z-10 max-w-6xl mx-auto px-6 pb-20">
        <div class="text-center mb-10">
            <p class="text-2xl text-polri-red tracking-widest uppercase mb-2">Panduan Singkat</p>
            <h2 class="text-2xl md:text-3xl font-bold text-white">Tata Cara Pengajuan Anggaran</h2>
        </div>

        <div class="glass-card rounded-2xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">1</span>
                    <div>
                        <p class="text-white font-medium text-sm">Masuk ke Akun</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Login sesuai Satker dan Ur Anda masing-masing.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">2</span>
                    <div>
                        <p class="text-white font-medium text-sm">Isi Formulir</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Lengkapi jumlah anggaran yang diajukan pada menu Ajukan Anggaran.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">3</span>
                    <div>
                        <p class="text-white font-medium text-sm">Unggah Dokumen</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Sertakan Laporan Rencana Kebutuhan Anggaran & Laporan Perwabku bulan lalu.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">4</span>
                    <div>
                        <p class="text-white font-medium text-sm">Verifikasi Admin</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Pengajuan diproses dan diverifikasi oleh Urren.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">5</span>
                    <div>
                        <p class="text-white font-medium text-sm">Pantau Status</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Cek perkembangan pengajuan melalui menu Riwayat Pengajuan.</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-polri-red/20 text-polri-red text-sm flex items-center justify-center font-semibold">6</span>
                    <div>
                        <p class="text-white font-medium text-sm">Batas Waktu</p>
                        <p class="text-polri-silver-dark text-sm mt-1">Pengajuan dilakukan sebelum tanggal 5 bulan berikutnya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Fitur --}}
    <div class="relative z-10 max-w-6xl mx-auto px-6 pb-24">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card rounded-2xl p-6">
                <div class="w-10 h-1 bg-polri-red rounded-full mb-4"></div>
                <h3 class="font-semibold text-polri-gray mb-2">Pengajuan Terstruktur</h3>
                <p class="text-sm text-polri-silver-dark">Ajukan rencana kebutuhan anggaran lengkap dengan dokumen pendukung, tanpa proses manual berulang.</p>
            </div>
            <div class="glass-card rounded-2xl p-6">
                <div class="w-10 h-1 bg-polri-red rounded-full mb-4"></div>
                <h3 class="font-semibold text-polri-gray mb-2">Monitoring Real-time</h3>
                <p class="text-sm text-polri-silver-dark">Pantau sisa pagu dan status pengajuan setiap unit kerja secara cepat dan transparan.</p>
            </div>
            <div class="glass-card rounded-2xl p-6">
                <div class="w-10 h-1 bg-polri-red rounded-full mb-4"></div>
                <h3 class="font-semibold text-polri-gray mb-2">Verifikasi Cepat</h3>
                <p class="text-sm text-polri-silver-dark">Proses persetujuan anggaran oleh Urren dilakukan langsung melalui sistem.</p>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="relative z-10 border-t border-polri-silver/10 py-6 text-center text-xs text-polri-silver-dark">
        Bidang Teknologi Informasi dan Komunikasi — Polda Jawa Timur, {{ date('Y') }}
    </footer>

</body>
</html>
