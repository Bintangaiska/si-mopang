<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Pengajuan Anggaran</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 10px;
            color: #111827;
        }
        .header {
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 3px solid #C8102E;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header .logo { height: 58px; }
        .header .title {
            flex: 1;
            text-align: center;
        }
        .header .title h1 {
            font-size: 15px;
            color: #C8102E;
            letter-spacing: 1px;
        }
        .header .title p {
            font-size: 11px;
            color: #374151;
            margin-top: 2px;
        }
        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #4B5563;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead th {
            background: #C8102E;
            color: #ffffff;
            padding: 7px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }
        table tbody td {
            border-bottom: 1px solid #E5E7EB;
            padding: 6px;
            vertical-align: top;
        }
        table tbody tr:nth-child(even) {
            background: #F9FAFB;
        }
        .num { text-align: right; }
        .total-row td {
            border-top: 2px solid #111827;
            font-weight: bold;
            padding: 8px 6px;
        }
        .status {
            padding: 2px 8px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 9px;
        }
        .status-selesai { background: #DCFCE7; color: #166534; }
        .status-diproses { background: #FEF9C3; color: #854D0E; }
        .status-ditolak { background: #FEE2E2; color: #991B1B; }
        .footer {
            margin-top: 22px;
            text-align: right;
            font-size: 10px;
            color: #4B5563;
        }
        .empty {
            padding: 24px;
            text-align: center;
            color: #6B7280;
        }
    </style>
</head>
<body>

    <div class="header">
        @if($logoBase64)
            <img class="logo" src="{{ $logoBase64 }}" alt="Logo">
        @endif
        <div class="title">
            <h1>REKAP PENGAJUAN ANGGARAN</h1>
            <p>Bidang TIK Kepolisian Daerah Jawa Timur</p>
        </div>
    </div>

    <div class="meta">
        <span>Periode: Semua data pengajuan</span>
        <span>Dibuat: {{ now()->format('d M Y H:i') }}</span>
    </div>

    @if($pengajuan->isEmpty())
        <p class="empty">Belum ada data pengajuan anggaran.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:10%">Tanggal</th>
                    <th style="width:15%">Sub Satuan Kerja</th>
                    <th style="width:13%">Urusan</th>
                    <th style="width:17%">Uraian</th>
                    <th style="width:17%">Pengaju</th>
                    <th style="width:13%" class="num">Jumlah (Rp)</th>
                    <th style="width:9%">Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td>{{ $item->unit_kerja }}</td>
                    <td>{{ $item->urusan ?? '-' }}</td>
                    <td>{{ $item->uraian ?? '-' }}</td>
                    <td>{{ $item->user?->name ?? '-' }}</td>
                    <td class="num">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badge = match ($item->status) {
                                'Selesai' => 'status-selesai',
                                'Diproses' => 'status-diproses',
                                'Ditolak' => 'status-ditolak',
                                default => '',
                            };
                        @endphp
                        <span class="status {{ $badge }}">{{ $item->status }}</span>
                    </td>
                    <td>{{ $item->catatan ?? '-' }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="6">TOTAL</td>
                    <td class="num">{{ number_format($total, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Dokumen ini dihasilkan oleh sistem SI-MOPANG — {{ now()->format('d M Y') }}</p>
    </div>

</body>
</html>
