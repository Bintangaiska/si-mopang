<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rencana Pendistribusian Anggaran</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 8px;
            color: #111827;
        }
        .header {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 3px solid #C8102E;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header .logo { height: 50px; }
        .header .title {
            flex: 1;
            text-align: center;
        }
        .header .title h1 {
            font-size: 14px;
            color: #C8102E;
            letter-spacing: 1px;
        }
        .header .title p {
            font-size: 10px;
            color: #374151;
            margin-top: 2px;
        }
        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #4B5563;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead th {
            background: #C8102E;
            color: #ffffff;
            padding: 5px 3px;
            text-align: center;
            font-size: 7.5px;
            text-transform: uppercase;
        }
        table tbody td {
            border-bottom: 1px solid #E5E7EB;
            padding: 4px 3px;
            vertical-align: top;
        }
        table tbody tr:nth-child(even) {
            background: #F9FAFB;
        }
        .num { text-align: right; }
        .total-row td {
            border-top: 2px solid #111827;
            font-weight: bold;
            padding: 5px 3px;
            background: #F3F4F6;
        }
        .empty {
            padding: 20px;
            text-align: center;
            color: #6B7280;
        }
        .footer {
            margin-top: 18px;
            text-align: right;
            font-size: 9px;
            color: #4B5563;
        }
    </style>
</head>
<body>

    <div class="header">
        @if($logoBase64)
            <img class="logo" src="{{ $logoBase64 }}" alt="Logo">
        @endif
        <div class="title">
            <h1>RENCANA PENDISTRIBUSIAN ANGGARAN DIPA</h1>
            <p>Bidang TIK Kepolisian Daerah Jawa Timur — 2026</p>
        </div>
    </div>

    <div class="meta">
        <span>Satuan Kerja: {{ $scope }}</span>
        <span>Dibuat: {{ now()->format('d M Y H:i') }}</span>
    </div>

    @if($rencana->isEmpty())
        <p class="empty">Belum ada data rencana anggaran.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:3%">No</th>
                    <th style="width:11%">Subsatker</th>
                    <th style="width:24%">Uraian</th>
                    <th style="width:9%" class="num">Pagu</th>
                    @foreach(\App\Models\RencanaAnggaran::BULAN_LABEL as $label)
                        <th style="width:4.4%" class="num">{{ $label }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rencana as $i => $item)
                <tr>
                    <td class="num">{{ $i + 1 }}</td>
                    <td>{{ $item->satker }}</td>
                    <td>{{ $item->item }}</td>
                    <td class="num">{{ number_format($item->pagu, 0, ',', '.') }}</td>
                    @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                        <td class="num">{{ $item->{$bln} > 0 ? number_format($item->{$bln}, 0, ',', '.') : '-' }}</td>
                    @endforeach
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align:center">TOTAL</td>
                    <td class="num">{{ number_format($total, 0, ',', '.') }}</td>
                    @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                        <td class="num">{{ $totalBulan[$bln] > 0 ? number_format($totalBulan[$bln], 0, ',', '.') : '-' }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Dokumen ini dihasilkan oleh sistem SI-MOPANG — {{ now()->format('d M Y') }}</p>
    </div>

</body>
</html>
