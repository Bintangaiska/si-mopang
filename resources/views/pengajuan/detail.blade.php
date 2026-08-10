<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Detail Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Informasi Pengajuan</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-polri-silver-dark">Unit Kerja</dt>
                        <dd class="text-white">{{ $pengajuan->unit_kerja }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Nama Urusan</dt>
                        <dd class="text-white">{{ $pengajuan->urusan ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Pengaju</dt>
                        <dd class="text-white">{{ $pengajuan->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Tanggal Diajukan</dt>
                        <dd class="text-white">{{ $pengajuan->tanggal_pengajuan->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Jumlah Diajukan</dt>
                        <dd class="text-white">Rp {{ number_format($pengajuan->jumlah, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Status Saat Ini</dt>
                        <dd class="text-white">{{ $pengajuan->status }}</dd>
                    </div>
                </dl>
            </div>

            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Dokumen Terlampir</h3>
                <div class="flex flex-wrap gap-2">
                    @if($pengajuan->file_rka)
                        <a href="{{ asset('storage/' . $pengajuan->file_rka) }}" target="_blank"
                           class="inline-flex items-center gap-1 px-3 py-2 bg-polri-red/10 text-polri-red rounded text-sm border border-polri-red/20 hover:bg-polri-red/20 transition">
                            Laporan RKA
                        </a>
                    @else
                        <span class="text-polri-silver-dark text-sm">Tidak ada file</span>
                    @endif
                    @if($pengajuan->file_perwabku)
                        <a href="{{ asset('storage/' . $pengajuan->file_perwabku) }}" target="_blank"
                           class="inline-flex items-center gap-1 px-3 py-2 bg-polri-red/10 text-polri-red rounded text-sm border border-polri-red/20 hover:bg-polri-red/20 transition">
                            Laporan Perwabku
                        </a>
                    @else
                        <span class="text-polri-silver-dark text-sm">Tidak ada file</span>
                    @endif
                </div>
            </div>

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Proses Pengajuan</h3>
                <form method="POST" action="{{ route('pengajuan.update-status', $pengajuan->id) }}">
                    @csrf
                    @method('PATCH')

                    <label class="block text-sm text-polri-silver-dark mb-1">Ubah Status</label>
                    <select name="status" class="simopang-input w-full mb-4 px-3 py-2">
                        <option value="Diproses" {{ $pengajuan->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Ditolak" {{ $pengajuan->status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Selesai" {{ $pengajuan->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <label class="block text-sm text-polri-silver-dark mb-1">Balasan / Catatan</label>
                    <textarea name="catatan" class="simopang-input w-full mb-4 px-3 py-2" rows="3" placeholder="Tulis balasan untuk pengaju...">{{ $pengajuan->catatan }}</textarea>

                    <button type="submit" class="simopang-btn-primary text-sm">
                        Perbarui Status & Kirim
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
