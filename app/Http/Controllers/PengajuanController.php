<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    // Data dummy sementara, nanti diganti tabel pengajuan_anggaran asli
    private function dummyData()
    {
        return [
            [
                'id' => 1,
                'nama_subsatker' => 'Subbid Tekkom',
                'unit' => 'Subbid Tekkom',
                'tanggal' => '20 Jul 2026',
                'jumlah' => 10000000,
                'status' => 'Diproses',
                'catatan' => null,
            ],
            [
                'id' => 2,
                'nama_subsatker' => 'Subbid Tekinfo',
                'unit' => 'Subbid Tekinfo',
                'tanggal' => '22 Jul 2026',
                'jumlah' => 7500000,
                'status' => 'Diproses',
                'catatan' => null,
            ],
            [
                'id' => 3,
                'nama_subsatker' => 'Subbagrenmin',
                'unit' => 'Subbagrenmin',
                'tanggal' => '23 Jul 2026',
                'jumlah' => 5000000,
                'status' => 'Selesai',
                'catatan' => 'Pengajuan disetujui, dana sudah dicairkan.',
            ],
        ];
    }

    public function index()
    {
        $pengajuan = $this->dummyData();

        return view('pengajuan.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = collect($this->dummyData())->firstWhere('id', (int) $id);

        return view('pengajuan.detail', compact('pengajuan'));
    }

        public function create()
    {
        // Sisa pagu unit kerja user yang login (dummy dulu)
        $sisaPagu = 45000000;

        return view('pengajuan.form', compact('sisaPagu'));
    }

    public function riwayat()
    {
        // Riwayat pengajuan milik unit kerja user yang login (dummy dulu)
        $riwayat = collect($this->dummyData())->take(3);

        return view('pengajuan.riwayat', compact('riwayat'));
    }
}