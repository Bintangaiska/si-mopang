<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="simopang-card p-6 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="border-b border-polri-dark-light text-polri-silver-dark text-xs uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-2">No</th>
                            <th class="py-3 px-2">Nama</th>
                            <th class="py-3 px-2">Email</th>
                            <th class="py-3 px-2">Role</th>
                            <th class="py-3 px-2">Sub Satuan Kerja</th>
                            <th class="py-3 px-2">Urusan</th>
                            <th class="py-3 px-2">Terdaftar</th>
                            <th class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                        <tr class="border-b border-polri-dark-light hover:bg-white/5 transition">
                            <td class="py-3 px-2 text-polri-silver-dark">{{ $i + 1 }}</td>
                            <td class="py-3 px-2 text-polri-silver font-medium">{{ $user->name }}</td>
                            <td class="py-3 px-2 text-polri-silver-dark">{{ $user->email }}</td>
                            <td class="py-3 px-2">
                                @php
                                    $roleBadge = match($user->role) {
                                        'super_admin' => 'bg-purple-500/20 text-purple-400',
                                        'admin' => 'bg-blue-500/20 text-blue-400',
                                        'user' => 'bg-gray-500/20 text-gray-300',
                                        default => 'bg-gray-500/20 text-gray-300',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded text-xs font-medium {{ $roleBadge }}">
                                    {{ $user->role === 'super_admin' ? 'Super Admin' : ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-polri-silver-dark">{{ $user->unit_kerja ?? '-' }}</td>
                            <td class="py-3 px-2 text-polri-silver-dark">{{ $user->urusan ?? '-' }}</td>
                            <td class="py-3 px-2 text-polri-silver-dark text-xs">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-2 flex gap-2">
                                <a href="{{ route('user-management.edit', $user) }}"
                                   class="px-3 py-1 text-xs rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/20 hover:bg-blue-500/20 transition">
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('user-management.destroy', $user) }}"
                                      onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 text-xs rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 hover:bg-red-500/20 transition">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-6 text-center text-polri-silver-dark text-sm">
                                Belum ada user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
