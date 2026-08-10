<nav x-data="{ open: false }" class="relative z-50 bg-polri-dark border-b border-polri-dark-light shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="h-10 w-10 object-contain" alt="Logo TIK Polri">

                    <div class="flex flex-col">
                        <span class="font-bold text-polri-silver tracking-widest text-sm">
                            SI MOPANG
                        </span>
                        <span class="text-[10px] text-polri-silver-dark uppercase tracking-wider">
                            Monitoring Penyerapan Anggaran
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
                        <a href="#" class="px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white transition">Manajemen User</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Dashboard</a>
                        <a href="{{ route('pengajuan.create') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('pengajuan.create') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Ajukan Anggaran</a>
                        <a href="{{ route('pengajuan.riwayat') }}" class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('pengajuan.riwayat') ? 'bg-polri-red/20 text-white' : 'text-polri-silver hover:bg-polri-red/10 hover:text-white' }} transition">Riwayat Pengajuan</a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Desktop) -->
            <div class="hidden lg:flex lg:items-center lg:ms-6">
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
                <a href="{{ route('settings.pagu') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Pengaturan</a>
            @elseif(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Dashboard</a>
                <a href="{{ route('pengajuan.index') }}" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen Pengajuan</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-sm text-polri-silver hover:bg-polri-red/10 hover:text-white">Manajemen User</a>
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
