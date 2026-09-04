<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            Pengaturan Sistem
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
                <h3 class="text-sm font-semibold text-white mb-1">
                    PENGATURAN TAMPILAN
                </h3>

                <p class="text-xs text-polri-silver-dark mb-5">
                    Ubah foto dan informasi Kepala Bidang yang tampil di landing page.
                </p>

                <form method="POST"
                      action="{{ route('settings.tampilan.update') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-2">
                                Foto Kepala Bidang
                            </label>

                            @if($pengaturan->foto_kabid_path)
                                <img
                                    src="{{ asset('storage/' . $pengaturan->foto_kabid_path) }}"
                                    class="h-24 w-24 object-cover mb-3 rounded-lg">
                            @endif

                            <input
                                type="file"
                                name="foto_kabid"
                                accept="image/*"
                                class="w-full text-sm text-polri-silver">
                        </div>

                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-1">
                                Nama Kepala Bidang
                            </label>

                            <input
                                type="text"
                                name="nama_kabid"
                                value="{{ old('nama_kabid', $pengaturan->nama_kabid) }}"
                                class="simopang-input w-full px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs text-polri-silver-dark mb-1">
                                Jabatan
                            </label>

                            <input
                                type="text"
                                name="jabatan_kabid"
                                value="{{ old('jabatan_kabid', $pengaturan->jabatan_kabid) }}"
                                class="simopang-input w-full px-3 py-2 text-sm">
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-lg bg-polri-red text-white">
                            Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>