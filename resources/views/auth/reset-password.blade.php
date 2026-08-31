<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-lg font-semibold text-[#E5E7EB] mb-1">Reset Kata Sandi</h2>
        <p class="text-xs text-[#A8ADB4]">Masukkan kata sandi baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs text-[#BFC3C8] mb-1">Alamat Email</label>
            <input id="email" type="email" name="email"
                value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm text-gray-200 bg-[#1e293b]/70 border border-gray-700 focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-500">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs text-[#BFC3C8] mb-1">Kata Sandi Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="••••••••"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm text-gray-200 bg-[#1e293b]/70 border border-gray-700 focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-500">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs text-[#BFC3C8] mb-1">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="••••••••"
                class="input-glass w-full rounded-lg px-4 py-2.5 text-sm text-gray-200 bg-[#1e293b]/70 border border-gray-700 focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-500">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full py-3 rounded-lg font-semibold tracking-wide transition pointer-events-auto cursor-pointer"
                style="color:#ffffff; background-color:#C8102E; background-image:linear-gradient(90deg,#C8102E 0%,#1F2937 100%);">
                RESET KATA SANDI
            </button>
        </div>
    </form>
</x-guest-layout>
