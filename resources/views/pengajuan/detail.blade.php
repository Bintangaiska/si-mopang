<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Detail Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Informasi Pengajuan</h3>
                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-polri-silver-dark">Unit Kerja</dt>
                        <dd class="text-white">{{ $pengajuan['unit'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Tanggal Diajukan</dt>
                        <dd class="text-white">{{ $pengajuan['tanggal'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Jumlah Diajukan</dt>
                        <dd class="text-white">Rp {{ number_format($pengajuan['jumlah'], 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-polri-silver-dark">Status Saat Ini</dt>
                        <dd class="text-white">{{ $pengajuan['status'] }}</dd>
                    </div>
                </dl>
            </div>

            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Dokumen Terlampir</h3>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-block px-3 py-2 bg-polri-red/10 text-polri-red rounded text-sm border border-polri-red/20">Laporan Rencana Kebutuhan Anggaran.pdf</span>
                    <span class="inline-block px-3 py-2 bg-polri-red/10 text-polri-red rounded text-sm border border-polri-red/20">Laporan Perwabku Bulan Lalu.pdf</span>
                </div>
            </div>

            <div class="simopang-card p-6">
                <h3 class="font-semibold text-white mb-4">Proses Pengajuan</h3>
                <form>
                    <label class="block text-sm text-polri-silver-dark mb-1">Ubah Status</label>
                    <select class="simopang-input w-full mb-4 px-3 py-2">
                        <option>Diproses</option>
                        <option>Ditolak</option>
                        <option>Selesai</option>
                    </select>

                    <label class="block text-sm text-polri-silver-dark mb-1">Balasan / Catatan</label>
                    <textarea class="simopang-input w-full mb-4 px-3 py-2" rows="3" placeholder="Tulis balasan untuk pengaju...">{{ $pengajuan['catatan'] }}</textarea>

                    <button type="submit" class="simopang-btn-primary text-sm">
                        Perbarui Status & Kirim
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>