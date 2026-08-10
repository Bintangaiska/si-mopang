<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use App\Models\PengajuanAnggaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->user()->role;

        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $status = $request->input('status');
        $satker = $request->input('satker');

        $paguMap = PaguAnggaran::paguMap();

        $unitKerja = collect($paguMap)->map(function ($pagu, $nama) use ($tahun, $bulan) {
            $realisasi = PengajuanAnggaran::where('unit_kerja', $nama)
                ->where('status', 'Selesai')
                ->when($tahun, fn ($q) => $q->whereYear('tanggal_pengajuan', $tahun))
                ->when($bulan, fn ($q) => $q->whereMonth('tanggal_pengajuan', $bulan))
                ->sum('jumlah');

            return [
                'nama' => $nama,
                'pagu' => $pagu,
                'sisa_pagu' => max($pagu - $realisasi, 0),
                'realisasi' => $realisasi,
            ];
        })->when($satker, fn ($c) => $c->filter(fn ($item) => $item['nama'] === $satker))->values();

        $totalPagu = $unitKerja->sum('pagu');
        $totalRealisasi = $unitKerja->sum('realisasi');
        $totalSisa = $unitKerja->sum('sisa_pagu');
        $persenSerap = $totalPagu > 0 ? round(($totalRealisasi / $totalPagu) * 100, 1) : 0;

        $ranking = $unitKerja->map(function ($u) {
            $u['persen'] = $u['pagu'] > 0 ? round(($u['realisasi'] / $u['pagu']) * 100, 1) : 0;
            return $u;
        })->sortByDesc('persen')->values();

        $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $trenBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $realisasi = PengajuanAnggaran::where('status', 'Selesai')
                ->when($satker, fn ($q) => $q->where('unit_kerja', $satker))
                ->whereYear('tanggal_pengajuan', $m->year)
                ->whereMonth('tanggal_pengajuan', $m->month)
                ->sum('jumlah');

            $trenBulanan[] = [
                'bulan' => $bulanNama[$m->month - 1],
                'pagu' => $totalPagu,
                'realisasi' => $realisasi,
            ];
        }

        $pengajuanQuery = fn ($q) => $q
            ->when($tahun, fn ($qq) => $qq->whereYear('tanggal_pengajuan', $tahun))
            ->when($bulan, fn ($qq) => $qq->whereMonth('tanggal_pengajuan', $bulan));

        $antrianDiproses = PengajuanAnggaran::with('user')
            ->where('status', 'Diproses')
            ->when($satker, fn ($q) => $q->where('unit_kerja', $satker))
            ->when($tahun, fn ($q) => $q->whereYear('tanggal_pengajuan', $tahun))
            ->when($bulan, fn ($q) => $q->whereMonth('tanggal_pengajuan', $bulan))
            ->orderBy('created_at', 'desc')
            ->get();

        $pengajuanTerbaru = PengajuanAnggaran::with('user')
            ->when($satker, fn ($q) => $q->where('unit_kerja', $satker))
            ->when($tahun, fn ($q) => $q->whereYear('tanggal_pengajuan', $tahun))
            ->when($bulan, fn ($q) => $q->whereMonth('tanggal_pengajuan', $bulan))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('tanggal_pengajuan', 'desc')
            ->take(10)
            ->get();

        $statusDistribusi = PengajuanAnggaran::query()
            ->when($satker, fn ($q) => $q->where('unit_kerja', $satker))
            ->when($tahun, fn ($q) => $q->whereYear('tanggal_pengajuan', $tahun))
            ->when($bulan, fn ($q) => $q->whereMonth('tanggal_pengajuan', $bulan))
            ->get()
            ->countBy('status');

        $tahunList = PengajuanAnggaran::selectRaw('YEAR(tanggal_pengajuan) as thn')
            ->distinct()
            ->orderByDesc('thn')
            ->pluck('thn')
            ->map(fn ($t) => (string) $t);

        if ($tahunList->isEmpty()) {
            $tahunList = collect([(string) now()->year]);
        }

        $user = $request->user();
        $totalDisetujui = PengajuanAnggaran::where('unit_kerja', $user->unit_kerja)
            ->where('status', 'Selesai')
            ->sum('jumlah');

        $paguUser = $paguMap[$user->unit_kerja] ?? 0;

        $sisaPaguUser = $paguUser - $totalDisetujui;
        if ($sisaPaguUser < 0) $sisaPaguUser = 0;

        $pengajuanUserTerbaru = PengajuanAnggaran::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Admin-specific: data for their satker
        $paguAdmin = $paguMap[$user->unit_kerja] ?? 0;
        $totalTerserapAdmin = PengajuanAnggaran::where('unit_kerja', $user->unit_kerja)
            ->where('status', 'Selesai')
            ->sum('jumlah');
        $sisaPaguAdmin = $paguAdmin - $totalTerserapAdmin;
        if ($sisaPaguAdmin < 0) $sisaPaguAdmin = 0;
        $pengajuanAdmin = PengajuanAnggaran::with('user')
            ->where('unit_kerja', $user->unit_kerja)
            ->orderBy('created_at', 'desc')
            ->get();

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
            'pengajuanUserTerbaru' => $pengajuanUserTerbaru,
            'tahunList' => $tahunList,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'status' => $status,
            'satker' => $satker,
            'paguAdmin' => $paguAdmin,
            'totalTerserapAdmin' => $totalTerserapAdmin,
            'sisaPaguAdmin' => $sisaPaguAdmin,
            'pengajuanAdmin' => $pengajuanAdmin,
        ]);
    }
}
