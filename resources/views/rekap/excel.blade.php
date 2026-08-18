@php echo '<?xml version="1.0" encoding="UTF-8"?>' @endphp
{!! '<?mso-application progid="Excel.Sheet"?>' !!}
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
    <Styles>
        <Style ss:ID="Judul">
            <Font ss:Bold="1" ss:Size="14" ss:Color="#C8102E"/>
            <Alignment ss:Horizontal="Center"/>
        </Style>
        <Style ss:ID="Subjudul">
            <Font ss:Size="11"/>
            <Alignment ss:Horizontal="Center"/>
        </Style>
        <Style ss:ID="Header">
            <Font ss:Bold="1" ss:Color="#FFFFFF" ss:Size="10"/>
            <Interior ss:Color="#C8102E" ss:Pattern="Solid"/>
            <Alignment ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
        </Style>
        <Style ss:ID="Angka">
            <NumberFormat ss:Format="#,##0"/>
        </Style>
        <Style ss:ID="Total">
            <Font ss:Bold="1"/>
            <Borders>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
            </Borders>
        </Style>
        <Style ss:ID="Wrap">
            <Alignment ss:WrapText="1" ss:Vertical="Top"/>
        </Style>
    </Styles>

    <Worksheet ss:Name="Rekap Anggaran">
        <Table>
            <Column ss:Width="35"/>
            <Column ss:Width="75"/>
            <Column ss:Width="120"/>
            <Column ss:Width="110"/>
            <Column ss:Width="160"/>
            <Column ss:Width="95"/>
            <Column ss:Width="70"/>
            <Column ss:Width="200"/>

            <Row ss:Height="24">
                <Cell ss:MergeAcross="7" ss:StyleID="Judul">
                    <Data ss:Type="String">REKAP PENGAJUAN ANGGARAN</Data>
                </Cell>
            </Row>
            <Row>
                <Cell ss:MergeAcross="7" ss:StyleID="Subjudul">
                    <Data ss:Type="String">Bidang TIK Kepolisian Daerah Jawa Timur</Data>
                </Cell>
            </Row>
            <Row>
                <Cell ss:MergeAcross="7">
                    <Data ss:Type="String">Dibuat: {{ now()->format('d M Y H:i') }} - {{ $pengajuan->count() }} pengajuan</Data>
                </Cell>
            </Row>
            <Row ss:Height="4"/>

            <Row>
                <Cell ss:StyleID="Header"><Data ss:Type="String">No</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Tanggal</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Sub Satuan Kerja</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Urusan</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Uraian</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Pengaju</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Jumlah (Rp)</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Status</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Catatan</Data></Cell>
            </Row>

            @forelse($pengajuan as $i => $item)
            <Row>
                <Cell><Data ss:Type="Number">{{ $i + 1 }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->unit_kerja }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->urusan ?? '-' }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->uraian ?? '-' }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->user?->name ?? '-' }}</Data></Cell>
                <Cell ss:StyleID="Angka"><Data ss:Type="Number">{{ $item->jumlah }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->status }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->catatan ?? '-' }}</Data></Cell>
            </Row>
            @empty
            <Row>
                <Cell ss:MergeAcross="7">
                    <Data ss:Type="String">Belum ada data pengajuan anggaran.</Data>
                </Cell>
            </Row>
            @endforelse

            <Row>
                <Cell ss:MergeAcross="5" ss:StyleID="Total">
                    <Data ss:Type="String">TOTAL</Data>
                </Cell>
                <Cell ss:StyleID="Total"><Data ss:Type="Number">{{ $total }}</Data></Cell>
                <Cell ss:StyleID="Total"/>
                <Cell ss:StyleID="Total"/>
            </Row>
        </Table>
    </Worksheet>
</Workbook>
