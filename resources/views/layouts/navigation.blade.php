<nav x-data="{ open: false }" class="relative z-50 bg-polri-dark border-b border-polri-dark-light shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">

            <!-- Logo
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="h-10 w-10 object-contain" alt="Logo TIK Polri">

                    <div class="flex flex-col">
                        <span class="font-bold text-polri-silver tracking-widest text-sm">
                            SIMOPANG
                        </span>
                        <span class="text-[10px] text-polri-silver-dark uppercase tracking-wider">
                            Monitoring Penyerapan Anggaran
                        </span>
                    </div>
                </a>  -->

            <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
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

                </a>


                <!-- Menu Horizontal (Desktop) -->
                <div class="hidden lg:flex items-center gap-1">
                    @if(auth()->user()->role === 'super_admin')
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Dashboard</a>
                        <a href="{{ route('user-management.index') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('user-management.*') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Manajemen User</a>
                        <a href="{{ route('settings.pagu') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('settings.*') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Manajemen Pagu</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Dashboard</a>
                        <a href="{{ route('pengajuan.index') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('pengajuan.index') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Manajemen Pengajuan</a>
                        <!-- <a href="#" class="px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white transition">Manajemen User</a> -->
                    @else
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Dashboard</a>
                        <a href="{{ route('pengajuan.create') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('pengajuan.create') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Ajukan Anggaran</a>
                        <a href="{{ route('pengajuan.riwayat') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('pengajuan.riwayat') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Riwayat Pengajuan</a>
                    @endif
                </div>
            </div>

            <!-- Notifikasi + Settings Dropdown (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:ms-6 gap-2">

                <!-- Notifikasi -->
                <div class="relative" x-data="{ openNotif: false }">
                    <button @click="openNotif = !openNotif" @click.away="openNotif = false" class="relative p-2 text-polri-silver hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(isset($notifikasi) && $notifikasi->count() > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-polri-red rounded-full"></span>
                        @endif
                    </button>

                    <div x-show="openNotif" x-transition class="absolute right-0 mt-2 w-80 bg-polri-dark border border-polri-dark-light rounded-lg shadow-xl z-50" style="display: none;">
                        <div class="p-3 border-b border-polri-dark-light">
                            <p class="text-sm font-semibold text-white">Notifikasi Terbaru</p>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse($notifikasi ?? [] as $item)
                            <a href="{{ route('pengajuan.show', $item->id) }}" class="block px-4 py-3 border-b border-polri-dark-light hover:bg-white/5 transition">
                                <p class="text-sm text-white">{{ $item->unit_kerja }}</p>
                                <p class="text-xs text-polri-silver-dark mt-0.5">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }} —
                                    <span class="{{ $item->status === 'Selesai' ? 'text-green-400' : ($item->status === 'Ditolak' ? 'text-red-400' : 'text-yellow-400') }}">{{ $item->status }}</span>
                                </p>
                                <p class="text-[10px] text-polri-silver-dark mt-1">{{ $item->updated_at->diffForHumans() }}</p>
                            </a>
                            @empty
                            <p class="px-4 py-6 text-center text-sm text-polri-silver-dark">Belum ada aktivitas terbaru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-polri-silver hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

            </div>

            <!-- Hamburger (Mobile & Tablet) -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-polri-silver hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile & Tablet) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-2">
            @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Dashboard</a>
                <a href="{{ route('user-management.index') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen User</a>
                <a href="{{ route('settings.pagu') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen Pagu</a>
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Dashboard</a>
                <a href="{{ route('pengajuan.index') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen Pengajuan</a>
                <!-- <a href="#" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen User</a> -->
            @else
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Dashboard</a>
                <a href="{{ route('pengajuan.create') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Ajukan Anggaran</a>
                <a href="{{ route('pengajuan.riwayat') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Riwayat Pengajuan</a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-polri-silver-dark">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white cursor-pointer">Log Out</a>
                </form>
            </div>
        </div>
    </div>
</nav>
