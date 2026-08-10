<?php

namespace Database\Seeders;

use App\Models\Satker;
use Illuminate\Database\Seeder;

class SatkerUrSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'SUBBAGREMIN',
                'deskripsi' => 'Subbagian Perencanaan dan Administrasi',
                'urs' => ['URMINTU', 'URREN', 'URKEN'],
            ],
            [
                'nama' => 'SUBBID TEKKOM',
                'deskripsi' => 'Subbidang Teknologi Komunikasi',
                'urs' => ['URJARKOM', 'URYANKOM', 'URHARKAN'],
            ],
            [
                'nama' => 'SUBBID TEKINFO',
                'deskripsi' => 'Subbidang Teknologi Informasi',
                'urs' => ['URRULLAHTA', 'URINTI', 'URYANDUKNIS'],
            ],
        ];

        foreach ($data as $item) {
            $satker = Satker::create([
                'nama' => $item['nama'],
                'deskripsi' => $item['deskripsi'],
                'pagu_bulanan' => 0,
            ]);

            foreach ($item['urs'] as $namaUr) {
                $satker->urs()->create(['nama' => $namaUr]);
            }
        }
    }
}