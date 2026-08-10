<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Riwayat Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="simopang-card p-6 overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                        <tr>
                            <th class="py-2">Subsatker</th>
                            <th class="py-2">Urusan</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $item)
                        <tr class="border-b border-polri-dark-light">
                            <td class="py-2 text-polri-silver">{{ $item->unit_kerja }}</td>
                            <td class="py-2 text-polri-silver">{{ $item->urusan ?? '-' }}</td>
                            <td class="py-2 text-polri-silver">{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                            <td class="py-2 text-polri-silver">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td class="py-2">
                                @php
                                    $warna = match($item->status) {
                                        'Selesai' => 'bg-green-500/20 text-green-400',
                                        'Diproses' => 'bg-yellow-500/20 text-yellow-400',
                                        'Ditolak' => 'bg-red-500/20 text-red-400',
                                        default => 'bg-gray-500/20 text-gray-300',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs {{ $warna }}">{{ $item->status }}</span>
                            </td>
                            <td class="py-2">
                                <a href="{{ route('pengajuan.show', $item->id) }}" class="text-polri-red hover:underline">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-polri-silver-dark text-sm">
                                Belum ada pengajuan. <a href="{{ route('pengajuan.create') }}" class="text-polri-red hover:underline">Ajukan sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
