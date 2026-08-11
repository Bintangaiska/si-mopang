<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use App\Models\RencanaAnggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function editPagu()
    {
        $paguMap = PaguAnggaran::paguMap();
        $satker = array_keys(config('unitkerja.satker'));
        $rencanaAnggaran = RencanaAnggaran::orderBy('satker')->orderBy('id')->get();

        return view('settings.pagu', compact('paguMap', 'satker', 'rencanaAnggaran'));
    }

    public function updatePagu(Request $request)
    {
        $validated = $request->validate([
            'pagu' => ['required', 'array'],
            'pagu.*' => ['required', 'numeric', 'min:0'],
        ]);

        foreach ($request->input('pagu') as $unit => $pagu) {
            PaguAnggaran::updateOrCreate(
                ['unit_kerja' => $unit],
                ['pagu' => $pagu],
            );
        }

        return redirect()->route('settings.pagu')
            ->with('success', 'Pagu anggaran setiap unit kerja berhasil diperbarui.');
    }

    public function storeRencana(Request $request)
    {
        $data = $this->validateRencana($request);

        RencanaAnggaran::create($data);

        return redirect()->route('settings.pagu')
            ->with('success', "Item rencana \"{$data['item']}\" berhasil ditambahkan.");
    }

    public function updateRencana(Request $request, RencanaAnggaran $rencana)
    {
        $data = $this->validateRencana($request);

        $rencana->update($data);

        return redirect()->route('settings.pagu')
            ->with('success', "Item rencana \"{$data['item']}\" berhasil diperbarui.");
    }

    public function destroyRencana(RencanaAnggaran $rencana)
    {
        $rencana->delete();

        return redirect()->route('settings.pagu')
            ->with('success', "Item rencana \"{$rencana->item}\" berhasil dihapus.");
    }

    private function validateRencana(Request $request): array
    {
        $rules = [
            'satker' => ['required', 'string', Rule::in(array_keys(config('unitkerja.satker')))],
            'item' => ['required', 'string', 'max:255'],
            'pagu' => ['required', 'numeric', 'min:0'],
        ];

        foreach (RencanaAnggaran::BULAN as $bln) {
            $rules[$bln] = ['nullable', 'numeric', 'min:0'];
        }

        $validated = $request->validate($rules);

        foreach (RencanaAnggaran::BULAN as $bln) {
            $validated[$bln] = $validated[$bln] ?? 0;
        }

        return $validated;
    }
}
