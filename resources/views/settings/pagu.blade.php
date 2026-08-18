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
                <h3 class="text-sm font-semibold text-white mb-1">ATUR ANGGARAN PER SUBSATKER</h3>
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
                                            <input type="text" inputmode="numeric" name="pagu[{{ $unit }}]"
                                                value="{{ number_format($paguMap[$unit] ?? 0, 0, ',', '.') }}"
                                                class="rencana-nominal simopang-input text-sm px-3 py-1.5 w-full">
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

            {{-- ========== RENCANA PENDISTRIBUSIAN ANGGARAN ========== --}}
            <div class="simopang-card p-6 mt-6">
                <h3 class="text-sm font-semibold text-white mb-1">RENCANA PENDISTRIBUSIAN ANGGARAN DIPA BID TIK POLDA JATIM 2026</h3>
                <p class="text-xs text-polri-silver-dark mb-5">Kelola rencana pendistribusian anggaran per satker per bulan. Data ini tampil di dashboard.</p>

                {{-- Form tambah --}}
                <form method="POST" action="{{ route('settings.rencana.store') }}" class="mb-6 p-4 rounded-xl bg-polri-dark border border-polri-dark-light">
                    @csrf
                    <p class="text-xs font-semibold text-polri-silver mb-3 uppercase tracking-wider">Tambah Item Rencana</p>

                    @if($errors->has('satker') || $errors->has('item') || $errors->has('pagu') || $errors->has('jan'))
                        <div class="mb-3 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                            Periksa kembali isian form tambah rencana.
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-1">Subsatker</label>
                            <select name="satker" class="simopang-input w-full px-3 py-2 text-sm" required>
                                <option value="" disabled selected>Pilih satker</option>
                                @foreach($satker as $unit)
                                    <option value="{{ $unit }}" {{ old('satker') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-1">Uraian</label>
                            <input type="text" name="item" value="{{ old('item') }}" placeholder="Contoh: Harwat CC" class="simopang-input w-full px-3 py-2 text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-1">Pagu Total (Rp)</label>
                            <input type="text" inputmode="numeric" name="pagu" value="{{ old('pagu') }}" placeholder="0" class="rencana-nominal simopang-input w-full px-3 py-2 text-sm" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                        @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                            <div>
                                <label class="block text-xs text-polri-silver-dark mb-1">{{ \App\Models\RencanaAnggaran::BULAN_LABEL[$bln] }}</label>
                                <input type="text" inputmode="numeric" name="{{ $bln }}" value="{{ old($bln) }}" placeholder="0" class="rencana-nominal simopang-input w-full px-3 py-2 text-sm">
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-polri-red hover:bg-red-700 text-white text-sm font-medium transition">
                            Tambah Item
                        </button>
                    </div>
                </form>

                {{-- Tabel data rencana --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left whitespace-nowrap">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2 pr-3">No</th>
                                <th class="py-2 pr-3">Subsatker</th>
                                <th class="py-2 pr-3">Uraian</th>
                                <th class="py-2 pr-3">Pagu</th>
                                @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                                    <th class="py-2 pr-3">{{ \App\Models\RencanaAnggaran::BULAN_LABEL[$bln] }}</th>
                                @endforeach
                                <th class="py-2 pr-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rencanaAnggaran as $i => $item)
                            <tr class="border-b border-polri-dark-light">
                                <td class="py-2 pr-3 text-polri-silver-dark">{{ $i + 1 }}</td>
                                <td class="py-2 pr-3 text-white">{{ $item->satker }}</td>
                                <td class="py-2 pr-3 text-polri-silver">{{ $item->item }}</td>
                                <td class="py-2 pr-3 text-polri-silver">Rp {{ number_format($item->pagu, 0, ',', '.') }}</td>
                                @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                                    <td class="py-2 pr-3 text-polri-silver-dark">{{ $item->{$bln} > 0 ? number_format($item->{$bln}, 0, ',', '.') : '-' }}</td>
                                @endforeach
                                <td class="py-2 pr-3">
                                    <button type="button" onclick="toggleEditRencana({{ $item->id }})" class="text-blue-400 hover:underline">Edit</button>
                                    <form method="POST" action="{{ route('settings.rencana.destroy', $item) }}" class="inline" onsubmit="return confirm('Hapus item \"{{ $item->item }}\"?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            <tr id="edit-row-{{ $item->id }}" class="hidden">
                                <td colspan="16" class="py-2 px-2 bg-polri-dark">
                                    <form method="POST" action="{{ route('settings.rencana.update', $item) }}" class="p-3 rounded-xl border border-polri-dark-light">
                                        @csrf
                                        @method('PATCH')
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                            <div>
                                                <label class="block text-xs text-polri-silver-dark mb-1">Satker</label>
                                                <select name="satker" class="simopang-input w-full px-3 py-2 text-sm" required>
                                                    @foreach($satker as $unit)
                                                        <option value="{{ $unit }}" {{ $item->satker === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs text-polri-silver-dark mb-1">Item</label>
                                                <input type="text" name="item" value="{{ $item->item }}" class="simopang-input w-full px-3 py-2 text-sm" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs text-polri-silver-dark mb-1">Pagu Total (Rp)</label>
                                                <input type="text" inputmode="numeric" name="pagu" value="{{ $item->pagu }}" class="rencana-nominal simopang-input w-full px-3 py-2 text-sm" required>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                                            @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                                                <div>
                                                    <label class="block text-xs text-polri-silver-dark mb-1">{{ \App\Models\RencanaAnggaran::BULAN_LABEL[$bln] }}</label>
                                                    <input type="text" inputmode="numeric" name="{{ $bln }}" value="{{ $item->{$bln} }}" class="rencana-nominal simopang-input w-full px-3 py-2 text-sm">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-3 flex justify-end gap-2">
                                            <button type="button" onclick="toggleEditRencana({{ $item->id }})" class="px-3 py-1.5 rounded-lg border border-polri-dark-light text-polri-silver text-xs">Batal</button>
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="16" class="py-6 text-center text-polri-silver-dark">Belum ada data rencana anggaran. Tambahkan item di form di atas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEditRencana(id) {
            document.getElementById('edit-row-' + id).classList.toggle('hidden');
        }

        function formatRupiah(value) {
            var digits = value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');
            return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        document.addEventListener('input', function (e) {
            var input = e.target;
            if (input.classList && input.classList.contains('rencana-nominal')) {
                var caret = input.value.length;
                input.value = formatRupiah(input.value);
                input.setSelectionRange(caret, caret);
            }
        });

        document.addEventListener('submit', function (e) {
            e.target.querySelectorAll('.rencana-nominal').forEach(function (input) {
                input.value = input.value.replace(/\./g, '');
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rencana-nominal').forEach(function (input) {
                input.value = formatRupiah(input.value);
            });
        });
    </script>
</x-app-layout>
