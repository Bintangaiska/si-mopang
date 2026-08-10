<?php

namespace App\Http\Controllers;

use App\Models\PaguAnggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function editPagu()
    {
        $paguMap = PaguAnggaran::paguMap();
        $satker = array_keys(config('unitkerja.satker'));

        return view('settings.pagu', compact('paguMap', 'satker'));
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
}
