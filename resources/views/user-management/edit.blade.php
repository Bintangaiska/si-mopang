<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-polri-gray leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="simopang-card p-6">
                <form method="POST" action="{{ route('user-management.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="simopang-input w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="simopang-input w-full px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">Role</label>
                        <select name="role" class="simopang-input w-full px-3 py-2">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="super_admin" {{ $user->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">Sub Satuan Kerja</label>
                        <select name="unit_kerja" id="unit_kerja" class="simopang-input w-full px-3 py-2"
                                onchange="updateUrusan()">
                            <option value="">— Pilih Sub Satuan Kerja —</option>
                            @foreach($unitKerjaList as $satker => $urusanList)
                                <option value="{{ $satker }}" {{ $user->unit_kerja === $satker ? 'selected' : '' }}>
                                    {{ $satker }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-polri-silver-dark mt-1">Khusus role User, sub satuan kerja menentukan pagu anggaran.</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-polri-silver-dark mb-2">Nama Urusan</label>
                        <select name="urusan" id="urusan" class="simopang-input w-full px-3 py-2">
                            <option value="">— Pilih Nama Urusan —</option>
                        </select>
                    </div>

                    <script>
                        window.urusanMap = @json($unitKerjaList);
                        window.preselectUrusan = @json($user->urusan);
                        document.addEventListener('DOMContentLoaded', function () {
                            updateUrusan();
                        });

                        function updateUrusan() {
                            const satker = document.getElementById('unit_kerja');
                            const urusan = document.getElementById('urusan');
                            const list = window.urusanMap[satker.value] || [];
                            urusan.innerHTML = '<option value="">— Pilih Nama Urusan —</option>'
                                + list.map(function (u) {
                                    const sel = window.preselectUrusan === u ? 'selected' : '';
                                    return '<option value="' + u + '" ' + sel + '>' + u + '</option>';
                                }).join('');
                        }
                    </script>

                    <div class="flex justify-between">
                        <a href="{{ route('user-management.index') }}"
                           class="px-4 py-2 text-sm border border-polri-dark-light text-polri-silver rounded-lg hover:bg-white/5 transition">
                            Batal
                        </a>
                        <button type="submit" class="simopang-btn-primary text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
