<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Riwayat Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="simopang-card p-6">
                <table class="w-full text-sm text-left">
                    <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                        <tr>
                            <th class="py-2">Subsatker</th>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                        <tr class="border-b border-polri-dark-light">
                            <td class="py-2 text-polri-silver">{{ $item['nama_subsatker'] }}</td>
                            <td class="py-2 text-polri-silver">{{ $item['tanggal'] }}</td>
                            <td class="py-2 text-polri-silver">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                            <td class="py-2">
                                @php
                                    $warna = match($item['status']) {
                                        'Selesai' => 'bg-green-500/20 text-green-400',
                                        'Diproses' => 'bg-yellow-500/20 text-yellow-400',
                                        'Ditolak' => 'bg-red-500/20 text-red-400',
                                        default => 'bg-gray-500/20 text-gray-300',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs {{ $warna }}">{{ $item['status'] }}</span>
                            </td>
                            <td class="py-2">
                                <a href="{{ route('pengajuan.show', $item['id']) }}" class="text-polri-red hover:underline">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>