<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use App\Models\PengajuanAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    public function index()
    {
        $query = PengajuanAnggaran::with('user');
        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        return view('pengajuan.index', compact('pengajuan'));
    }

    public function create()
    {
        $paguUnit = collect(PaguAnggaran::paguMap())->map(function ($pagu, $unit) {
            $disetujui = PengajuanAnggaran::where('unit_kerja', $unit)
                ->where('status', 'Selesai')
                ->sum('jumlah');
            return [
                'unit' => $unit,
                'pagu' => $pagu,
                'sisa' => max($pagu - $disetujui, 0),
            ];
        })->values();

        return view('pengajuan.form', [
            'sisaPaguPerUnit' => $paguUnit,
            'unitKerjaList' => config('unitkerja.satker'),
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'unit_kerja' => ['required', 'string', Rule::in(array_keys(config('unitkerja.satker')))],
            'urusan' => ['required', 'string', Rule::in(collect(config('unitkerja.satker'))->flatten()->all())],
            'uraian' => ['required', 'string', 'max:255'],
            'tanggal_pengajuan' => ['required', 'date'],
            'jumlah_pengajuan' => ['required', 'numeric', 'min:1'],
            'rka' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'perwabku' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $fileRka = $request->hasFile('rka')
            ? $request->file('rka')->store('pengajuan/rka', 'public')
            : null;

        $filePerwabku = $request->file('perwabku')->store('pengajuan/perwabku', 'public');

        PengajuanAnggaran::create([
            'user_id' => $user->id,
            'unit_kerja' => $request->unit_kerja,
            'urusan' => $request->urusan,
            'uraian' => $request->uraian,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'jumlah' => $request->jumlah_pengajuan,
            'file_rka' => $fileRka,
            'file_perwabku' => $filePerwabku,
            'status' => 'Diproses',
        ]);

        return redirect()->route('pengajuan.riwayat')
            ->with('success', 'Pengajuan anggaran berhasil dikirim dan sedang diproses.');
    }

    public function show($id)
    {
        $pengajuan = PengajuanAnggaran::with('user')->findOrFail($id);

        return view('pengajuan.detail', compact('pengajuan'));
    }

    public function riwayat()
    {
        $user = auth()->user();

        $riwayat = PengajuanAnggaran::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengajuan.riwayat', compact('riwayat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:Diproses,Ditolak,Selesai'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        $pengajuan = PengajuanAnggaran::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pengajuan.index')
            ->with('success', "Status pengajuan {$pengajuan->unit_kerja} diubah menjadi {$request->status}.");
    }
}