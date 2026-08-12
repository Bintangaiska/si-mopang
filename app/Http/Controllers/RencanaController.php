<?php

namespace App\Http\Controllers;

use App\Models\RencanaAnggaran;
use Dompdf\Dompdf;
use Illuminate\Http\Response;

class RencanaController extends Controller
{
    public function exportExcel(): Response
    {
        $rencana = $this->data();
        $totalBulan = $this->totalBulan($rencana);

        $xml = view('rencana.excel', [
            'rencana' => $rencana,
            'total' => $rencana->sum('pagu'),
            'totalBulan' => $totalBulan,
            'scope' => $this->scopeLabel(),
        ])->render();

        $xml = preg_replace('/^\s+|\s+$/m', '', $xml);

        $filename = 'rencana-pendistribusian-anggaran-' . $this->scopeSlug() . '-' . now()->format('Y-m-d') . '.xls';

        return response($xml, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf(): Response
    {
        $rencana = $this->data();
        $totalBulan = $this->totalBulan($rencana);

        $logoBase64 = null;
        $logoPath = public_path('images/logo-tikpolri.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = view('rencana.pdf', [
            'rencana' => $rencana,
            'total' => $rencana->sum('pagu'),
            'totalBulan' => $totalBulan,
            'scope' => $this->scopeLabel(),
            'logoBase64' => $logoBase64,
        ])->render();

        $dompdf = new Dompdf([
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'rencana-pendistribusian-anggaran-' . $this->scopeSlug() . '-' . now()->format('Y-m-d') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function data(): \Illuminate\Support\Collection
    {
        $query = RencanaAnggaran::query();

        $user = auth()->user();
        if ($user && $user->role !== 'super_admin' && $user->unit_kerja) {
            $query->where('satker', $user->unit_kerja);
        }

        return $query->orderBy('satker')->orderBy('id')->get();
    }

    private function totalBulan(\Illuminate\Support\Collection $rencana): array
    {
        $total = [];

        foreach (RencanaAnggaran::BULAN as $bln) {
            $total[$bln] = (float) $rencana->sum($bln);
        }

        return $total;
    }

    private function scopeLabel(): string
    {
        $user = auth()->user();

        return $user && $user->role !== 'super_admin' && $user->unit_kerja
            ? $user->unit_kerja
            : 'Semua Satuan Kerja';
    }

    private function scopeSlug(): string
    {
        $label = strtolower(str_replace(' ', '-', $this->scopeLabel()));

        return $label === 'semua-satuan-kerja' ? 'semua' : $label;
    }
}
