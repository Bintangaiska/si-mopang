<?php

namespace App\Http\Controllers;

use App\Models\PengajuanAnggaran;
use Dompdf\Dompdf;
use Illuminate\Http\Response;

class RekapController extends Controller
{
    public function exportPdf(): Response
    {
        $pengajuan = PengajuanAnggaran::with('user')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $logoBase64 = null;
        $logoPath = public_path('images/logo-tikpolri.png');
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = view('rekap.pdf', [
            'pengajuan' => $pengajuan,
            'total' => $pengajuan->sum('jumlah'),
            'logoBase64' => $logoBase64,
        ])->render();

        $dompdf = new Dompdf([
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $filename = 'rekap-anggaran-' . now()->format('Y-m-d') . '.pdf';

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportExcel(): Response
    {
        $pengajuan = PengajuanAnggaran::with('user')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $xml = view('rekap.excel', [
            'pengajuan' => $pengajuan,
            'total' => $pengajuan->sum('jumlah'),
        ])->render();

        $xml = preg_replace('/^\s+|\s+$/m', '', $xml);

        $filename = 'rekap-anggaran-' . now()->format('Y-m-d') . '.xls';

        return response($xml, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportExcelAdmin(): Response
    {
        $pengajuan = PengajuanAnggaran::with('user')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        $xml = view('rekap.excel', [
            'pengajuan' => $pengajuan,
            'total' => $pengajuan->sum('jumlah'),
        ])->render();

        $xml = preg_replace('/^\s+|\s+$/m', '', $xml);

        $filename = "rekap-semua-" . now()->format('Y-m-d') . '.xls';

        return response($xml, 200, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
