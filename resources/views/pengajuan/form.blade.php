<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Ajukan Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="simopang-card border-l-4 border-l-polri-red p-4">
                <p class="text-sm text-polri-silver-dark">Sisa Pagu Tersedia untuk Diajukan</p>
                <p class="text-2xl font-semibold text-white">
                    Rp {{ number_format($sisaPagu, 0, ',', '.') }}
                </p>
            </div>

            <div class="simopang-card p-6">
                <form method="POST" action="#">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">
                            Nama Satuan Kerja
                        </label>
                        <select
                            name="nama_subsatker"
                            class="simopang-input w-full px-3 py-2">
                            <option value="">Pilih Subsatker</option>
                            <option value="Subbid Tekkom">Subbid Tekkom</option>
                            <option value="Subbid Tekinfo">Subbid Tekinfo</option>
                            <option value="Subbagrenmin">Subbagrenmin</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Tanggal Pengajuan
                        </label>
                        <input
                            type="date"
                            name="tanggal_pengajuan"
                            class="simopang-input w-full px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Jumlah Anggaran Diajukan (Rp)
                        </label>
                        <input
                            type="number"
                            name="jumlah_pengajuan"
                            placeholder="Masukkan angka maksimal Rp {{ number_format($sisaPagu, 0, ',', '.') }}"
                            class="simopang-input w-full px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Laporan Rencana Kebutuhan Anggaran
                            <span class="text-polri-red">*wajib PDF</span>
                        </label>
                        <input
                            type="file"
                            name="rka"
                            accept=".pdf"
                            class="w-full text-sm text-polri-silver file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-polri-red file:text-white file:text-xs hover:file:bg-red-800">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Laporan Perwabku Bulan Lalu
                            <span class="text-polri-red">*wajib PDF</span>
                        </label>
                        <input
                            type="file"
                            name="perwabku"
                            accept=".pdf"
                            class="w-full text-sm text-polri-silver file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-polri-red file:text-white file:text-xs hover:file:bg-red-800">
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="simopang-btn-primary text-sm">
                            Submit Pengajuan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>