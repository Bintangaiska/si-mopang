<?php

namespace Database\Seeders;

use App\Models\PaguAnggaran;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        foreach (config('unitkerja.pagu') as $unit => $pagu) {
            PaguAnggaran::updateOrCreate(
                ['unit_kerja' => $unit],
                ['pagu' => $pagu],
            );
        }

        User::updateOrCreate(['email' => 'superadmin@test.com'], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'unit_kerja' => null,
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(['email' => 'admin@test.com'], [
            'name' => 'Admin TIK',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'unit_kerja' => 'SUBBIDTEKKOM',
            'urusan' => 'URJARKOM',
            'email_verified_at' => now(),
        ]);

        User::updateOrCreate(['email' => 'user@test.com'], [
            'name' => 'Tekkom User',
            'password' => Hash::make('password'),
            'role' => 'user',
            'unit_kerja' => 'SUBBIDTEKKOM',
            'urusan' => 'URJARKOM',
            'email_verified_at' => now(),
        ]);
    }
}
