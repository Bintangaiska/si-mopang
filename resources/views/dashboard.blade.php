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
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Jumlah Satker</p>
                        <p class="text-xl font-bold text-white mt-1">{{ count($unitKerja) }}</p>
                        <p class="text-xs text-polri-silver-dark mt-2">Subbid & Subbagrenmin</p>
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

                {{-- Filter (UI only, dummy) --}}
                <div class="simopang-card p-5">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <select class="simopang-input text-sm px-3 py-2"><option>Semua Wilayah</option><option>Polda Jatim</option></select>
                        <select class="simopang-input text-sm px-3 py-2"><option>Semua Polres</option><option>Bid TIK</option></select>
                        <select class="simopang-input text-sm px-3 py-2"><option>2026</option><option>2025</option></select>
                        <select class="simopang-input text-sm px-3 py-2"><option>Semua Bulan</option><option>Juli</option><option>Juni</option></select>
                        <select class="simopang-input text-sm px-3 py-2"><option>Semua Status</option><option>Selesai</option><option>Diproses</option><option>Ditolak</option></select>
                    </div>
                    <div class="flex gap-2 mt-3">
                        <button class="simopang-btn-primary text-sm">Filter</button>
                        <button class="px-4 py-2 text-sm border border-polri-dark-light text-polri-silver rounded-lg hover:bg-white/5">Reset</button>
                    </div>
                    <p class="text-xs text-polri-silver-dark mt-2">*Filter masih tampilan contoh, belum terhubung ke data.</p>
                </div>

                {{-- Charts --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">Sisa Pagu per Unit Kerja</h3>
                        <canvas id="chartPagu" height="180"></canvas>
                    </div>
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">Tren Realisasi Bulanan</h3>
                        <canvas id="chartTren" height="180"></canvas>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="simopang-card p-5">
                        <h3 class="text-sm font-semibold text-white mb-3">Distribusi Status Pengajuan</h3>
                        <canvas id="chartStatus" height="200"></canvas>
                    </div>

                    <div class="simopang-card p-5 lg:col-span-2">
                        <h3 class="text-sm font-semibold text-white mb-3">Ranking Penyerapan Unit Kerja</h3>
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
                        <h3 class="text-sm font-semibold text-white">Data Monitoring Anggaran</h3>
                        <div class="flex gap-2">
                            <input type="text" id="searchTable" placeholder="Cari unit kerja..." class="simopang-input text-sm px-3 py-1.5">
                            <button onclick="alert('Export PDF akan tersedia setelah data terhubung ke database.')" class="px-3 py-1.5 text-xs border border-polri-dark-light rounded-lg text-polri-silver hover:bg-white/5">Export PDF</button>
                            <button onclick="alert('Export Excel akan tersedia setelah data terhubung ke database.')" class="px-3 py-1.5 text-xs border border-polri-dark-light rounded-lg text-polri-silver hover:bg-white/5">Export Excel</button>
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
                                <td class="py-2 text-polri-silver">{{ $item['unit'] }}</td>
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="text-xs text-polri-silver-dark mt-3" id="tableInfo"></p>
                </div>

            @elseif($role === 'admin')
                {{-- ========== DASHBOARD ADMIN ========== --}}
                <div class="relative overflow-hidden rounded-xl bg-polri-dark border border-polri-dark-light p-5">
                    <img src="{{ asset('images/logo-tikpolri.png') }}" class="absolute -right-6 -top-6 w-40 opacity-10 pointer-events-none" alt="">
                    <p class="text-white font-semibold relative z-10">Selamat datang di Dashboard Admin!</p>
                    <p class="text-sm text-polri-silver-dark relative z-10">Anda bertugas memproses pengajuan anggaran dari tiap unit kerja.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="simopang-card p-5 border-l-4 border-l-yellow-500">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Pengajuan Menunggu Diproses</p>
                        <p class="text-2xl font-semibold text-yellow-400 mt-1">{{ count($antrianDiproses) }}</p>
                    </div>
                    <div class="simopang-card p-5">
                        <p class="text-xs text-polri-silver-dark uppercase tracking-wide">Total Nilai Diajukan Bulan Ini</p>
                        <p class="text-2xl font-semibold text-white mt-1">
                            Rp {{ number_format(collect($antrianDiproses)->sum('jumlah'), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="simopang-card p-5">
                    <h3 class="text-lg font-semibold text-white mb-4">Antrian Perlu Diproses</h3>
                    <table class="w-full text-sm text-left">
                        <thead class="border-b border-polri-dark-light text-polri-silver-dark">
                            <tr>
                                <th class="py-2">Unit Kerja</th>
                                <th class="py-2">Tanggal</th>
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($antrianDiproses as $item)
                            <tr class="border-b border-polri-dark-light">
                                <td class="py-2 text-polri-silver">{{ $item['unit'] }}</td>
                                <td class="py-2 text-polri-silver">{{ $item['tanggal'] }}</td>
                                <td class="py-2 text-polri-silver">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                                <td class="py-2">
                                    <a href="{{ route('pengajuan.index') }}" class="text-polri-red hover:underline">Proses</a>
                                </td>
                            </tr>
                            @endforeach
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
                                <th class="py-2">Jumlah</th>
                                <th class="py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($pengajuanTerbaru, 0, 2) as $item)
                            <tr class="border-b border-polri-dark-light">
                                <td class="py-2 text-polri-silver">{{ $item['tanggal'] }}</td>
                                <td class="py-2 text-polri-silver">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                                <td class="py-2 text-polri-silver">{{ $item['status'] }}</td>
                            </tr>
                            @endforeach
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
    </script>
    @endif
</x-app-layout>