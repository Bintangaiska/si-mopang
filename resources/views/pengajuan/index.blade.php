<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Manajemen Pengajuan') }}
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
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-white">DATA PENGAJUAN ANGGARAN</h3>
                        <p class="text-xs text-polri-silver-dark mt-1">Semua pengajuan dari seluruh unit kerja</p>
                    </div>
                    <div class="flex gap-2">
                        <select id="filterSatkerManajemen" class="simopang-input text-sm px-3 py-1.5">
                            <option value="">Semua Subsatker</option>
                            @foreach(array_keys(config('unitkerja.satker')) as $sk)
                                <option value="{{ $sk }}">{{ $sk }}</option>
                            @endforeach
                        </select>
                        <input type="text" id="searchManajemen" placeholder="Cari subsatker, uraian..." class="simopang-input text-sm px-3 py-1.5">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" id="manajemenTable">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-3 px-3 w-10">No</th>
                                <th class="py-3 px-3">Subsatker</th>
                                <th class="py-3 px-3">Urusan</th>
                                <th class="py-3 px-3">Uraian</th>
                                <th class="py-3 px-3">Pengaju</th>
                                <th class="py-3 px-3">Tanggal</th>
                                <th class="py-3 px-3 text-right">Jumlah</th>
                                <th class="py-3 px-3 text-center">Status</th>
                                <th class="py-3 px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $item)
                            <tr class="border-b border-polri-dark-light/50 hover:bg-white/[0.02] transition-colors table-row" data-satker="{{ $item->unit_kerja }}">
                                <td class="py-3 px-3 text-polri-silver-dark">{{ $loop->iteration }}</td>
                                <td class="py-3 px-3">
                                    <span class="text-white font-medium">{{ $item->unit_kerja }}</span>
                                </td>
                                <td class="py-3 px-3 text-polri-silver">{{ $item->urusan ?? '-' }}</td>
                                <td class="py-3 px-3 text-polri-silver">{{ $item->uraian ?? '-' }}</td>
                                <td class="py-3 px-3 text-polri-silver">{{ $item->user->name }}</td>
                                <td class="py-3 px-3 text-polri-silver">{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                                <td class="py-3 px-3 text-right text-white font-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="py-3 px-3 text-center">
                                    @php
                                        $warna = match($item->status) {
                                            'Selesai' => 'bg-green-500/20 text-green-400',
                                            'Diproses' => 'bg-yellow-500/20 text-yellow-400',
                                            'Ditolak' => 'bg-red-500/20 text-red-400',
                                            default => 'bg-gray-500/20 text-gray-300',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $warna }}">{{ $item->status }}</span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <a href="{{ route('pengajuan.show', $item->id) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 text-xs text-polri-red hover:bg-polri-red/10 rounded transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-10 h-10 text-polri-silver-dark/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-polri-silver-dark text-sm">Belum ada pengajuan anggaran.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p class="text-xs text-polri-silver-dark mt-3" id="manajemenInfo"></p>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchManajemen');
        const filterSelect = document.getElementById('filterSatkerManajemen');
        const rows = document.querySelectorAll('#manajemenTable .table-row');
        const info = document.getElementById('manajemenInfo');

        function updateInfo() {
            const visible = Array.from(rows).filter(r => r.style.display !== 'none').length;
            info.textContent = `Menampilkan ${visible} dari ${rows.length} data`;
        }

        function applyFilter() {
            const keyword = searchInput.value.toLowerCase();
            const satker = filterSelect.value;
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const rowSatker = row.dataset.satker || '';
                const matchSearch = !keyword || text.includes(keyword);
                const matchSatker = !satker || rowSatker === satker;
                row.style.display = (matchSearch && matchSatker) ? '' : 'none';
            });
            updateInfo();
        }

        searchInput.addEventListener('input', applyFilter);
        filterSelect.addEventListener('change', applyFilter);
        applyFilter();

        updateInfo();
    </script>
</x-app-layout>
