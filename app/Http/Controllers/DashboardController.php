<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;

        $unitKerja = [
            ['nama' => 'Subbid Tekkom', 'pagu' => 50000000, 'sisa_pagu' => 32000000, 'realisasi' => 18000000],
            ['nama' => 'Subbid Tekinfo', 'pagu' => 40000000, 'sisa_pagu' => 15500000, 'realisasi' => 24500000],
            ['nama' => 'Subbid Wassidik', 'pagu' => 35000000, 'sisa_pagu' => 35000000, 'realisasi' => 0],
            ['nama' => 'Subbagrenmin', 'pagu' => 25000000, 'sisa_pagu' => 8000000, 'realisasi' => 17000000],
        ];

        $totalPagu = collect($unitKerja)->sum('pagu');
        $totalRealisasi = collect($unitKerja)->sum('realisasi');
        $totalSisa = collect($unitKerja)->sum('sisa_pagu');
        $persenSerap = $totalPagu > 0 ? round(($totalRealisasi / $totalPagu) * 100, 1) : 0;

        $trenBulanan = [
            ['bulan' => 'Feb', 'pagu' => 150000000, 'realisasi' => 12000000],
            ['bulan' => 'Mar', 'pagu' => 150000000, 'realisasi' => 28000000],
            ['bulan' => 'Apr', 'pagu' => 150000000, 'realisasi' => 41000000],
            ['bulan' => 'Mei', 'pagu' => 150000000, 'realisasi' => 47000000],
            ['bulan' => 'Jun', 'pagu' => 150000000, 'realisasi' => 55000000],
            ['bulan' => 'Jul', 'pagu' => 150000000, 'realisasi' => 59500000],
        ];

        $ranking = collect($unitKerja)->map(function ($u) {
            $u['persen'] = $u['pagu'] > 0 ? round(($u['realisasi'] / $u['pagu']) * 100, 1) : 0;
            return $u;
        })->sortByDesc('persen')->values();

        $antrianDiproses = [
            ['unit' => 'Subbid Tekkom', 'tanggal' => '20 Jul 2026', 'jumlah' => 10000000],
            ['unit' => 'Subbid Tekinfo', 'tanggal' => '22 Jul 2026', 'jumlah' => 7500000],
        ];

        $sisaPaguUser = 45000000;
        $paguUser = 60000000;

        $pengajuanTerbaru = [
            ['unit' => 'Subbid Tekkom', 'tanggal' => '20 Jul 2026', 'jumlah' => 10000000, 'status' => 'Selesai'],
            ['unit' => 'Subbid Tekinfo', 'tanggal' => '22 Jul 2026', 'jumlah' => 7500000, 'status' => 'Diproses'],
            ['unit' => 'Subbagrenmin', 'tanggal' => '23 Jul 2026', 'jumlah' => 5000000, 'status' => 'Ditolak'],
            ['unit' => 'Subbid Wassidik', 'tanggal' => '18 Jul 2026', 'jumlah' => 12000000, 'status' => 'Selesai'],
            ['unit' => 'Subbid Tekkom', 'tanggal' => '15 Jul 2026', 'jumlah' => 6000000, 'status' => 'Selesai'],
            ['unit' => 'Subbid Tekinfo', 'tanggal' => '12 Jul 2026', 'jumlah' => 8500000, 'status' => 'Ditolak'],
        ];

        $statusDistribusi = collect($pengajuanTerbaru)->countBy('status');

        return view('dashboard', [
            'role' => $role,
            'unitKerja' => $unitKerja,
            'totalPagu' => $totalPagu,
            'totalRealisasi' => $totalRealisasi,
            'totalSisa' => $totalSisa,
            'persenSerap' => $persenSerap,
            'trenBulanan' => $trenBulanan,
            'ranking' => $ranking,
            'antrianDiproses' => $antrianDiproses,
            'sisaPaguUser' => $sisaPaguUser,
            'paguUser' => $paguUser,
            'pengajuanTerbaru' => $pengajuanTerbaru,
            'statusDistribusi' => $statusDistribusi,
        ]);
    }
}