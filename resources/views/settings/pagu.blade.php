<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Manajemen Pagu Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="simopang-card p-6">
                <h3 class="text-sm font-semibold text-white mb-1">Atur Jumlah Anggaran per Unit Kerja</h3>
                <p class="text-xs text-polri-silver-dark mb-5">Isi pagu anggaran untuk setiap unit kerja. Perubahan langsung dipakai di dashboard, halaman pengajuan, dan rekap.</p>

                <form method="POST" action="{{ route('settings.pagu.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="border-b border-polri-dark-light text-polri-silver-dark text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="py-3 px-2">Unit Kerja</th>
                                    <th class="py-3 px-2">Realisasi</th>
                                    <th class="py-3 px-2 w-64">Pagu Anggaran (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($satker as $unit)
                                    @php
                                        $realisasi = \App\Models\PengajuanAnggaran::where('unit_kerja', $unit)
                                            ->where('status', 'Selesai')
                                            ->sum('jumlah');
                                    @endphp
                                    <tr class="border-b border-polri-dark-light hover:bg-white/5 transition">
                                        <td class="py-3 px-2 text-polri-silver font-medium">{{ $unit }}</td>
                                        <td class="py-3 px-2 text-polri-silver-dark">Rp {{ number_format($realisasi, 0, ',', '.') }}</td>
                                        <td class="py-3 px-2">
                                            <input type="number" name="pagu[{{ $unit }}]"
                                                value="{{ $paguMap[$unit] ?? 0 }}"
                                                min="0" step="500000"
                                                class="simopang-input text-sm px-3 py-1.5 w-full">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-polri-red hover:bg-red-700 text-white text-sm font-medium transition">
                            Simpan Pagu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
