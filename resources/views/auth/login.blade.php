<x-guest-layout>
    <h2 class="text-lg font-semibold text-[#E5E7EB] mb-1">Login</h2>
    <p class="text-xs text-[#A8ADB4] mb-6">Masuk untuk mengakses sistem</p>

    @if (session('status'))
        <div class="mb-4 text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs text-[#BFC3C8] mb-1">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="user@poldajatim.go.id"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm">
            @error('email')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs text-[#BFC3C8] mb-1">Kata Sandi</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••"
                    class="input-glass w-full rounded-lg px-4 py-2.5 text-sm pr-14">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#A8ADB4] text-xs">
                    <span id="toggleLabel">Lihat</span>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 text-[#BFC3C8]">
                <input type="checkbox" name="remember" class="rounded border-[#BFC3C8]">
                Ingat saya
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[#C8102E] hover:underline">
                    Lupa Kata Sandi?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-3 rounded-lg font-semibold tracking-wide transition pointer-events-auto cursor-pointer"
            style="color:#ffffff; background-color:#C8102E; background-image:linear-gradient(90deg,#C8102E 0%,#1F2937 100%);">
            MASUK SISTEM
        </button>
    </form>

    <p class="text-center text-xs text-[#A8ADB4] mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-[#C8102E] hover:underline">Daftar</a>
    </p>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const label = document.getElementById('toggleLabel');
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