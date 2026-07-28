<aside class="w-64 min-h-screen bg-gray-800 text-white flex flex-col">
    <div class="p-4 text-lg font-semibold border-b border-gray-700">
        SI MOPANG
    </div>

    <nav class="flex-1 px-2 py-4 space-y-1">
        @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Manajemen User</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Pengaturan</a>
        @elseif(auth()->user()->role === 'admin')
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('pengajuan.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Manajemen Pengajuan</a>
            <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Manajemen User</a>
        @else
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('pengajuan.create') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Ajukan Anggaran</a>
            <a href="{{ route('pengajuan.riwayat') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Riwayat Pengajuan</a>
        @endif
    </nav>

    <!-- {{-- DEV TOOLS: hanya untuk testing, hapus sebelum production --}}
    <div class="p-4 border-t border-gray-700">
        <p class="text-xs text-gray-400 mb-2">🛠 Dev: Ganti Role</p>
        <div class="flex flex-col space-y-1">
            <a href="{{ route('dev.switch-role', 'super_admin') }}" class="text-xs px-3 py-1.5 rounded {{ auth()->user()->role === 'super_admin' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">Super Admin</a>
            <a href="{{ route('dev.switch-role', 'admin') }}" class="text-xs px-3 py-1.5 rounded {{ auth()->user()->role === 'admin' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">Admin</a>
            <a href="{{ route('dev.switch-role', 'user') }}" class="text-xs px-3 py-1.5 rounded {{ auth()->user()->role === 'user' ? 'bg-blue-600' : 'bg-gray-700 hover:bg-gray-600' }}">User</a>
        </div>
    </div> -->
</aside>