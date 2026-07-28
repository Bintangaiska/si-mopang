<x-guest-layout>
    <h2 class="text-lg font-semibold text-[#E5E7EB] mb-1">Daftar Akun</h2>
    <p class="text-xs text-[#A8ADB4] mb-6">Buat akun baru untuk mengakses sistem</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-xs text-[#BFC3C8] mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Nama sesuai identitas dinas"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm">
            @error('name')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs text-[#BFC3C8] mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="user@poldajatim.go.id"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm">
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs text-[#BFC3C8] mb-1">Kata Sandi</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="input-glass w-full rounded-lg px-4 py-2.5 text-sm pr-14">
                <button type="button" onclick="togglePassword('password', 'toggleLabel1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#A8ADB4] text-xs">
                    <span id="toggleLabel1">Lihat</span>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs text-[#BFC3C8] mb-1">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••"
                    class="input-glass w-full rounded-lg px-4 py-2.5 text-sm pr-14">
                <button type="button" onclick="togglePassword('password_confirmation', 'toggleLabel2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#A8ADB4] text-xs">
                    <span id="toggleLabel2">Lihat</span>
                </button>
            </div>
            @error('password_confirmation')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full py-3 rounded-lg text-white text-sm font-semibold tracking-wide bg-gradient-to-r from-[#C8102E] to-[#1F2937] hover:opacity-90 transition">
            DAFTAR AKUN
        </button>
    </form>

    <p class="text-center text-xs text-[#A8ADB4] mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-[#C8102E] hover:underline">Masuk di sini</a>
    </p>

    <script>
        function togglePassword(inputId, labelId) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);
            if (input.type === 'password') {
                input.type = 'text';
                label.textContent = 'Sembunyikan';
            } else {
                input.type = 'password';
                label.textContent = 'Lihat';
            }
        }
    </script>
</x-guest-layout>