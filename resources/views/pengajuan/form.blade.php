<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Ajukan Anggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="simopang-card p-6">
                <form method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">
                            Nama Satuan Kerja
                        </label>
                        <select name="unit_kerja" id="unit_kerja" class="simopang-input w-full px-3 py-2" required
                                onchange="updateUrusan()">
                            <option value="">Pilih Sub Satuan Kerja</option>
                            @foreach($unitKerjaList as $satker => $urusanList)
                                <option value="{{ $satker }}" {{ old('unit_kerja') === $satker ? 'selected' : '' }}>{{ $satker }}</option>
                            @endforeach
                        </select>
                        @error('unit_kerja')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Nama Urusan
                        </label>
                        <select name="urusan" id="urusan" class="simopang-input w-full px-3 py-2" required>
                            <option value="">Pilih Sub Satuan Kerja terlebih dahulu</option>
                        </select>
                        @error('urusan')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <script>
                        window.urusanMap = @json($unitKerjaList);
                        window.preselectUrusan = @json(old('urusan'));
                        document.addEventListener('DOMContentLoaded', function () {
                            updateUrusan();
                        });

                        function updateUrusan() {
                            const satker = document.getElementById('unit_kerja');
                            const urusan = document.getElementById('urusan');
                            const list = window.urusanMap[satker.value] || [];
                            urusan.innerHTML = '<option value="">Pilih Nama Urusan</option>'
                                + list.map(function (u) {
                                    const sel = window.preselectUrusan === u ? 'selected' : '';
                                    return '<option value="' + u + '" ' + sel + '>' + u + '</option>';
                                }).join('');
                        }
                    </script>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Uraian / Nama Anggaran
                        </label>
                        <input type="text" name="uraian" value="{{ old('uraian') }}"
                               placeholder="Masukkan uraian atau nama anggaran"
                               class="simopang-input w-full px-3 py-2" required>
                        @error('uraian')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Tanggal Pengajuan
                        </label>
                        <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan') }}"
                               class="simopang-input w-full px-3 py-2" required>
                    </div>

                    

                    <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Jumlah Anggaran Diajukan (Rp)
                        </label>
                        <input type="number" name="jumlah_pengajuan" value="{{ old('jumlah_pengajuan') }}"
                               placeholder="Masukkan jumlah anggaran yang diajukan"
                               class="simopang-input w-full px-3 py-2" required>
                    </div>

                   <div class="mb-4">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Laporan Rencana Kebutuhan Anggaran
                            <span class="text-polri-silver-dark">(opsional, PDF maks 10MB)</span>
                        </label>
                        <input type="file" name="rka" accept=".pdf"
                            class="w-full text-sm text-polri-silver file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-polri-red file:text-white file:text-xs hover:file:bg-red-800">
                        @error('rka')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                   <div class="mb-6">
                        <label class="block text-sm text-polri-silver-dark mb-1">
                            Laporan Perwabku Bulan Lalu
                            <span class="text-polri-red">*wajib PDF, maks 10MB</span>
                        </label>
                        <input type="file" name="perwabku" accept=".pdf"
                            class="w-full text-sm text-polri-silver file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-polri-red file:text-white file:text-xs hover:file:bg-red-800" required>
                        @error('perwabku')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="simopang-btn-primary text-sm">
                            Submit Pengajuan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
