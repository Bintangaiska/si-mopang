<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($role === 'super_admin')
                {{-- ========== DASHBOARD SUPER ADMIN ========== --}}

                <div class="relative overflow-hidden rounded-xl bg-polri-dark border border-polri-dark-light p-5">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="absolute -right-6 -top-6 w-40 opacity-10 pointer-events-none" alt="">
                    <p class="text-white font-semibold relative z-10">Selamat datang di Dashboard Super Admin!</p>
                    <p class="text-sm text-polri-silver-dark relative z-10">Anda dapat memantau seluruh unit kerja di Bid TIK Polda Jatim.</p>
                </div>

                {{-- KPI Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="simopang-card p-5 border-l-4 border-l-polri-silver">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Total Anggaran</p>
                        <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($totalPagu, 0, ',', '.') }}</p>
                        <p class="text-xs text-polri-silver-dark mt-2">{{ count($unitKerja) }} unit kerja aktif</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-polri-red">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Anggaran Terserap</p>
                        <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</p>
                        <p class="text-xs text-green-400 mt-2">▲ {{ $persenSerap }}% dari total pagu</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-gray-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Sisa Anggaran</p>
                        <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($totalSisa, 0, ',', '.') }}</p>
                        <p class="text-xs text-polri-silver-dark mt-2">Tersedia untuk diajukan</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-polri-silver">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Jumlah Subsatker</p>
                        <p class="text-xl font-bold text-white mt-1">{{ count($unitKerja) }}</p>
                        <p class="text-xs text-polri-silver-dark mt-2">3 Satuan Kerja aktif</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-polri-red">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Persentase Penyerapan</p>
                        <p class="text-xl font-bold text-white mt-1">{{ $persenSerap }}%</p>
                        <div class="w-full bg-gray-700 rounded-full h-1.5 mt-2">
                            <div class="bg-polri-red h-1.5 rounded-full" style="width: {{ $persenSerap }}%"></div>
                        </div>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-gray-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Status Realisasi</p>
                        <p class="text-xl font-bold {{ $persenSerap >= 50 ? 'text-green-400' : 'text-amber-400' }} mt-1">
                            {{ $persenSerap >= 50 ? 'On Track' : 'Perlu Perhatian' }}
                        </p>
                        <p class="text-xs text-polri-silver-dark mt-2">Target IKPA Triwulan</p>
                    </div>
                </div>

                {{-- Filter --}}
                <div class="simopang-card p-5">
                    <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <select name="satker" class="simopang-input text-sm px-3 py-2">
                            <option value="">Semua Subsatker</option>
                            @foreach(array_keys(config('unitkerja.satker')) as $sk)
                                <option value="{{ $sk }}" {{ $satker === $sk ? 'selected' : '' }}>{{ $sk }}</option>
                            @endforeach
                        </select>
                        <select name="tahun" class="simopang-input text-sm px-3 py-2">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $thn)
                                <option value="{{ $thn }}" {{ $tahun === $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                        <select name="bulan" class="simopang-input text-sm px-3 py-2">
                            <option value="">Semua Bulan</option>
                            @php $bulanNama = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ $bulanNama[$i-1] }}</option>
                            @endfor
                        </select>
                        <select name="status" class="simopang-input text-sm px-3 py-2">
                            <option value="">Semua Status</option>
                            @foreach(['Selesai','Diproses','Ditolak'] as $s)
                                <option value="{{ $s }}" {{ $status === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <div class="col-span-2 md:col-span-5 flex gap-2">
                            <button type="submit" class="simopang-btn-primary text-sm">Filter</button>
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm border border-polri-dark-light text-polri-silver rounded-lg hover:bg-white/5">Reset</a>
                        </div>
                    </form>
                </div>

                {{-- Charts --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">SISA PAGU PER SUBSATKER</h3>
                        <canvas id="chartPagu" height="180"></canvas>
                    </div>
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">TREN REALISASI BULANAN</h3>
                        <canvas id="chartTren" height="180"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">DISTRIBUSI STATUS PENGAJUAN</h3>
                        <canvas id="chartStatus" height="200"></canvas>
                    </div>

                    <div class="simopang-card p-5 lg:col-span-2">
                        <h3 class="text-sm font-semibold text-white mb-3">RANKING PENYERAPAN UNIT KERJA</h3>
                        <div class="space-y-2">
                            @foreach($ranking as $i => $u)
                            <div class="flex items-center gap-3">
                                <span class="w-6 text-xs text-polri-silver-dark font-medium">#{{ $i + 1 }}</span>
                                <span class="w-32 text-sm text-polri-silver truncate">{{ $u['nama'] }}</span>
                                <div class="flex-1 bg-gray-700 rounded-full h-2">
                                    <div class="{{ $u['persen'] >= 50 ? 'bg-green-500' : 'bg-polri-red' }} h-2 rounded-full" style="width: {{ $u['persen'] }}%"></div>
                                </div>
                                <span class="text-xs text-polri-silver-dark w-12 text-right">{{ $u['persen'] }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Tabel data monitoring --}}
                <div class="simopang-card p-5">
                    <div class="flex flex-col sm:flex-row justify-between gap-3 mb-4">
                        <h3 class="text-sm font-semibold text-white">DATA MONITORING ANGGARAN</h3>
                        <div class="flex gap-2">
                            <input type="text" id="searchTable" placeholder="Cari unit kerja..." class="simopang-input text-sm px-3 py-1.5">
                            <a href="{{ route('rekap.export-pdf') }}" class="px-3 py-1.5 text-xs border border-polri-red rounded-lg text-polri-red hover:bg-polri-red/10">Export PDF</a>
                            <a href="{{ route('rekap.export-excel') }}" class="px-3 py-1.5 text-xs border border-polri-dark-light rounded-lg text-polri-silver hover:bg-white/5">Export Excel</a>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left" id="monitoringTable">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2">Unit Kerja</th>
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuanTerbaru as $item)
                            <tr class="border-b border-polri-dark-light table-row">
                                <td class="py-2 text-polri-silver">{{ $item->unit_kerja }}<span class="block text-xs text-polri-silver-dark">{{ $item->urusan ?? '' }}</span></td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="text-xs text-polri-silver-dark mt-3" id="tableInfo"></p>
                </div>

                <div class="simopang-card p-5 overflow-x-auto">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <h3 class="text-sm font-semibold text-white">RENCANA PENDISTRIBUSIAN ANGGARAN DIPA BID TIK POLDA JATIM 2026</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('rencana.export-excel') }}" class="px-3 py-1.5 text-xs border border-green-600 rounded-lg text-green-400 hover:bg-green-600/10">Export Excel</a>
                            <a href="{{ route('rencana.export-pdf') }}" class="px-3 py-1.5 text-xs border border-red-600 rounded-lg text-red-400 hover:bg-red-600/10">Export PDF</a>
                        </div>
                    </div>
                    <table class="w-full text-xs text-left whitespace-nowrap">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2 pr-3">No</th>
                                <th class="py-2 pr-3">Subsatker</th>
                                <th class="py-2 pr-3">Uraian</th>
                                <th class="py-2 pr-3">Pagu</th>
                                <th class="py-2 pr-3">Jan</th>
                                <th class="py-2 pr-3">Feb</th>
                                <th class="py-2 pr-3">Mar</th>
                                <th class="py-2 pr-3">Apr</th>
                                <th class="py-2 pr-3">Mei</th>
                                <th class="py-2 pr-3">Jun</th>
                                <th class="py-2 pr-3">Jul</th>
                                <th class="py-2 pr-3">Agu</th>
                                <th class="py-2 pr-3">Sep</th>
                                <th class="py-2 pr-3">Okt</th>
                                <th class="py-2 pr-3">Nov</th>
                                <th class="py-2 pr-3">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rencanaAnggaranSemua as $item)
                            <tr class="border-b border-polri-dark-light">
                                <td class="py-2 pr-3 text-polri-silver-dark">{{ $loop->iteration }}</td>
                                <td class="py-2 pr-3 text-white">{{ $item['satker'] }}</td>
                                <td class="py-2 pr-3 text-polri-silver">{{ $item['item'] }}</td>
                                <td class="py-2 pr-3 text-polri-silver">Rp {{ number_format($item['pagu'], 0, ',', '.') }}</td>
                                @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                    <td class="py-2 pr-3 text-polri-silver-dark">{{ $item['bulan'][$bln] > 0 ?  number_format($item['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="16" class="py-6 text-center text-polri-silver-dark">Belum ada data rencana anggaran.</td>
                            </tr>
                            @endforelse
                            @if(count($rencanaAnggaranSemua) > 0)
                            <tr class="bg-polri-dark-light/40 font-semibold">
                                <td colspan="3" class="py-2 pr-3 text-white uppercase text-[10px] tracking-wider">Total</td>
                                <td class="py-2 pr-3 text-white">Rp {{ number_format($rencanaTotalSemua['pagu'], 0, ',', '.') }}</td>
                                @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                    <td class="py-2 pr-3 text-white">{{ $rencanaTotalSemua['bulan'][$bln] > 0 ? number_format($rencanaTotalSemua['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                                @endforeach
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            @elseif($role === 'admin')
                {{-- ========== DASHBOARD ADMIN ========== --}}
                <div class="relative overflow-hidden rounded-xl bg-polri-dark border border-polri-dark-light p-5">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="absolute -right-6 -top-6 w-40 opacity-10 pointer-events-none" alt="">
                    <p class="text-white font-semibold relative z-10">Selamat datang di Dashboard Admin!</p>
                    <p class="text-sm text-polri-silver-dark relative z-10">Anda bertugas memproses pengajuan anggaran dari seluruh unit kerja.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="simopang-card p-5 border-l-4 border-l-polri-red">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Total Anggaran</p>
                        <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($paguAdmin, 0, ',', '.') }}</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-green-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Anggaran Terserap</p>
                        <p class="text-xl font-bold text-green-400 mt-1">Rp {{ number_format($totalTerserapAdmin, 0, ',', '.') }}</p>
                    </div>
                    <div class="simopang-card p-5 border-l-4 border-l-gray-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Sisa Anggaran</p>
                        <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($sisaPaguAdmin, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($unitKerja as $unit)
                    <div class="simopang-card p-5 border-l-4 border-l-green-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">{{ $unit['nama'] }}</p>
                        <p class="text-xs text-polri-silver-dark mt-1">Anggaran Terserap</p>
                        <p class="text-xl font-bold text-green-400 mt-1">Rp {{ number_format($unit['realisasi'], 0, ',', '.') }}</p>
                        <p class="text-xs text-polri-silver-dark mt-2">Pagu: Rp {{ number_format($unit['pagu'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="simopang-card p-5">
                    <div class="flex flex-col sm:flex-row justify-between gap-3 mb-4">
                        <h3 class="text-sm font-semibold text-white">DATA MONITORING ANGGARAN</h3>
                        <div class="flex gap-2">
                            <input type="text" id="searchTableAdmin" placeholder="Cari urusan..." class="simopang-input text-sm px-3 py-1.5">
                            <a href="{{ route('rekap.export-excel-admin') }}" class="px-3 py-1.5 text-xs border border-green-600 rounded-lg text-green-400 hover:bg-green-600/10">Export Excel</a>
                        </div>
                    </div>
                    <table class="w-full text-sm text-left" id="monitoringTableAdmin">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2">Subsatker</th>
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanAdmin as $item)
                            <tr class="border-b border-polri-dark-light table-row">
                                <td class="py-2 text-polri-silver">{{ $item->unit_kerja }}<span class="block text-xs text-polri-silver-dark">{{ $item->urusan ?? '' }}</span></td>
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-polri-silver-dark">Belum ada pengajuan anggaran untuk subsatker ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <p class="text-xs text-polri-silver-dark mt-3" id="tableInfoAdmin"></p>
                </div>

                 <div class="simopang-card p-5 overflow-x-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                    <h3 class="text-sm font-semibold text-white">RENCANA PENDISTRIBUSIAN ANGGARAN DIPA BID TIK POLDA JATIM 2026</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('rencana.export-excel') }}" class="px-3 py-1.5 text-xs border border-green-600 rounded-lg text-green-400 hover:bg-green-600/10">Export Excel</a>
                        <a href="{{ route('rencana.export-pdf') }}" class="px-3 py-1.5 text-xs border border-red-600 rounded-lg text-red-400 hover:bg-red-600/10">Export PDF</a>
                    </div>
                </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rencanaAnggaran as $item)
                        <tr class="border-b border-polri-dark-light">
                            <td class="py-2 pr-3 text-polri-silver-dark">{{ $loop->iteration }}</td>
                            <td class="py-2 pr-3 text-white">{{ $item['satker'] }}</td>
                            <td class="py-2 pr-3 text-polri-silver">{{ $item['item'] }}</td>
                            <td class="py-2 pr-3 text-polri-silver">Rp {{ number_format($item['pagu'], 0, ',', '.') }}</td>
                            @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                <td class="py-2 pr-3 text-polri-silver-dark">{{ $item['bulan'][$bln] > 0 ? number_format($item['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="py-6 text-center text-polri-silver-dark">Belum ada rencana anggaran untuk subsatker ini.</td>
                        </tr>
                        @endforelse
                        @if(count($rencanaAnggaran) > 0)
                        <tr class="bg-polri-dark-light/40 font-semibold">
                            <td colspan="3" class="py-2 pr-3 text-white uppercase text-[10px] tracking-wider">Total</td>
                            <td class="py-2 pr-3 text-white">Rp {{ number_format($rencanaTotal['pagu'], 0, ',', '.') }}</td>
                            @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                <td class="py-2 pr-3 text-white">{{ $rencanaTotal['bulan'][$bln] > 0 ? number_format($rencanaTotal['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                            @endforeach
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @else
                {{-- ========== DASHBOARD USER ========== --}}
                <div class="relative overflow-hidden rounded-xl bg-polri-dark border border-polri-dark-light p-5">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="absolute -right-6 -top-6 w-40 opacity-10 pointer-events-none" alt="">
                    <p class="text-white font-semibold relative z-10">Selamat datang di Dashboard User!</p>
                    <p class="text-sm text-polri-silver-dark relative z-10">Anda dapat mengajukan anggaran dan memantau sisa pagu unit Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="simopang-card p-5 border-l-4 border-l-polri-red">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Sisa Pagu Unit Anda</p>
                        <p class="text-2xl font-semibold text-white mt-1">
                            Rp {{ number_format($sisaPaguUser, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="simopang-card p-5">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Total Pagu Bulanan</p>
                        <p class="text-2xl font-semibold text-white mt-1">
                            Rp {{ number_format($paguUser, 0, ',', '.') }}
                        </p>
                    </div>
                </div>


                {{-- Info Penting & Tata Cara Pengajuan --}}
                <div class="simopang-card p-6 border-l-4 border-l-polri-red">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-polri-red shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-white">Penting!</p>
                            <p class="text-sm text-polri-silver-dark mt-1">
                                Harap melakukan pengajuan dana sebelum tanggal <span class="text-polri-red font-medium">5 bulan depan</span>.
                                Sertakan Surat Pengajuan Dana beserta Surat Pertanggungjawaban dana bulan lalu.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-polri-dark-light">
                        <p class="text-sm font-semibold text-white mb-3">Tata Cara Pengajuan Dana</p>
                        <ol class="space-y-2">
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">1</span>
                                Masuk ke akun Anda sesuai SubSatker dan Urusan
                            </li>
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">2</span>
                                Pilih menu <span class="text-white">Ajukan Anggaran</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">3</span>
                                Isi formulir yang tersedia dengan lengkap
                            </li>
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">4</span>
                                Unggah berkas yang dibutuhkan (Laporan Rencana Kebutuhan Anggaran & Laporan Perwabku Bulan Lalu)
                            </li>
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">5</span>
                                Pantau status melalui menu <span class="text-white">Riwayat Pengajuan</span>
                            </li>
                            <li class="flex items-start gap-3 text-sm text-polri-silver">
                                <span class="shrink-0 w-5 h-5 rounded-full bg-polri-red/20 text-polri-red text-xs flex items-center justify-center font-medium">6</span>
                                Cek status secara berkala untuk mengetahui perkembangan pengajuan
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="simopang-card p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Butuh mengajukan anggaran bulan ini?</h3>
                        <p class="text-sm text-polri-silver-dark">Lengkapi form dan lampirkan dokumen pendukung.</p>
                    </div>
                    <a href="{{ route('pengajuan.create') }}" class="simopang-btn-primary text-sm whitespace-nowrap">
                        Ajukan Anggaran
                    </a>
                </div>

                <div class="simopang-card p-5">
                    <h3 class="text-lg font-semibold text-white mb-4">Riwayat Pengajuan Terbaru</h3>
                    <table class="w-full text-sm text-left">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Uraian</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuanUserTerbaru->take(2) as $item)
                            <tr class="border-b border-polri-dark-light">
                                <td class="py-2 text-polri-silver">{{ $item->tanggal_pengajuan->format('d M Y') }}</td>
                                <td class="py-2 text-polri-silver">{{ $item->uraian }}</td>
                                <td class="py-2 text-polri-silver">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="py-2 text-polri-silver">{{ $item->status }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                 <div class="simopang-card p-5 overflow-x-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                    <h3 class="text-sm font-semibold text-white">RENCANA PENDISTRIBUSIAN ANGGARAN DIPA BID TIK POLDA JATIM 2026</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('rencana.export-excel') }}" class="px-3 py-1.5 text-xs border border-green-600 rounded-lg text-green-400 hover:bg-green-600/10">Export Excel</a>
                        <a href="{{ route('rencana.export-pdf') }}" class="px-3 py-1.5 text-xs border border-red-600 rounded-lg text-red-400 hover:bg-red-600/10">Export PDF</a>
                    </div>
                </div>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rencanaAnggaran as $item)
                        <tr class="border-b border-polri-dark-light">
                            <td class="py-2 pr-3 text-polri-silver-dark">{{ $loop->iteration }}</td>
                            <td class="py-2 pr-3 text-white">{{ $item['satker'] }}</td>
                            <td class="py-2 pr-3 text-polri-silver">{{ $item['item'] }}</td>
                            <td class="py-2 pr-3 text-polri-silver">Rp {{ number_format($item['pagu'], 0, ',', '.') }}</td>
                            @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                <td class="py-2 pr-3 text-polri-silver-dark">{{ $item['bulan'][$bln] > 0 ? number_format($item['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="16" class="py-6 text-center text-polri-silver-dark">Belum ada rencana anggaran untuk subsatker Anda.</td>
                        </tr>
                        @endforelse
                        @if(count($rencanaAnggaran) > 0)
                        <tr class="bg-polri-dark-light/40 font-semibold">
                            <td colspan="3" class="py-2 pr-3 text-white uppercase text-[10px] tracking-wider">Total</td>
                            <td class="py-2 pr-3 text-white">Rp {{ number_format($rencanaTotal['pagu'], 0, ',', '.') }}</td>
                            @foreach(['jan','feb','mar','apr','mei','jun','jul','agu','sep','okt','nov','des'] as $bln)
                                <td class="py-2 pr-3 text-white">{{ $rencanaTotal['bulan'][$bln] > 0 ? number_format($rencanaTotal['bulan'][$bln], 0, ',', '.') : '-' }}</td>
                            @endforeach
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @endif

        </div>
    </div>

    @if($role === 'super_admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.color = '#A8ADB4';
        Chart.defaults.borderColor = 'rgba(75, 85, 99, 0.3)';

        new Chart(document.getElementById('chartPagu'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(collect($unitKerja)->pluck('nama')) !!},
                datasets: [{
                    label: 'Sisa Pagu (Rp)',
                    data: {!! json_encode(collect($unitKerja)->pluck('sisa_pagu')) !!},
                    backgroundColor: '#C8102E',
                    borderRadius: 6,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($trenBulanan)->pluck('bulan')) !!},
                datasets: [
                    {
                        label: 'Pagu',
                        data: {!! json_encode(collect($trenBulanan)->pluck('pagu')) !!},
                        borderColor: '#BFC3C8',
                        backgroundColor: 'transparent',
                        borderDash: [4, 4],
                        tension: 0.3,
                    },
                    {
                        label: 'Realisasi',
                        data: {!! json_encode(collect($trenBulanan)->pluck('realisasi')) !!},
                        borderColor: '#C8102E',
                        backgroundColor: 'rgba(200,16,46,0.15)',
                        fill: true,
                        tension: 0.3,
                    }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        new Chart(document.getElementById('chartStatus'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($statusDistribusi->keys()) !!},
                datasets: [{
                    data: {!! json_encode($statusDistribusi->values()) !!},
                    backgroundColor: ['#22c55e', '#eab308', '#dc2626'],
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        const searchInput = document.getElementById('searchTable');
        const rows = document.querySelectorAll('#monitoringTable .table-row');
        const tableInfo = document.getElementById('tableInfo');

        function updateInfo() {
            const visible = Array.from(rows).filter(r => r.style.display !== 'none').length;
            tableInfo.textContent = `Menampilkan ${visible} dari ${rows.length} data`;
        }

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
            updateInfo();
        });

        updateInfo();

        const searchInputAdmin = document.getElementById('searchTableAdmin');
        const rowsAdmin = document.querySelectorAll('#monitoringTableAdmin .table-row');
        const tableInfoAdmin = document.getElementById('tableInfoAdmin');

        function updateInfoAdmin() {
            const visible = Array.from(rowsAdmin).filter(r => r.style.display !== 'none').length;
            tableInfoAdmin.textContent = `Menampilkan ${visible} dari ${rowsAdmin.length} data`;
        }

        searchInputAdmin.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            rowsAdmin.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? '' : 'none';
            });
            updateInfoAdmin();
        });

        updateInfoAdmin();
    </script>
    @endif
</x-app-layout>
