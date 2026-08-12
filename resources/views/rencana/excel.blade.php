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
            <Font ss:Bold="1" ss:Color="#FFFFFF" ss:Size="9"/>
            <Interior ss:Color="#C8102E" ss:Pattern="Solid"/>
            <Alignment ss:Vertical="Center" ss:Horizontal="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
        </Style>
        <Style ss:ID="Angka">
            <NumberFormat ss:Format="#,##0"/>
            <Alignment ss:Horizontal="Right"/>
        </Style>
        <Style ss:ID="Total">
            <Font ss:Bold="1"/>
            <Borders>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
            </Borders>
            <Alignment ss:Horizontal="Right"/>
        </Style>
        <Style ss:ID="Wrap">
            <Alignment ss:WrapText="1" ss:Vertical="Top"/>
        </Style>
    </Styles>

    <Worksheet ss:Name="Rencana Anggaran">
        <Table>
            <Column ss:Width="35"/>
            <Column ss:Width="110"/>
            <Column ss:Width="220"/>
            <Column ss:Width="100"/>
            @foreach(range(1, 12) as $m)
            <Column ss:Width="45"/>
            @endforeach

            <Row ss:Height="24">
                <Cell ss:MergeAcross="15" ss:StyleID="Judul">
                    <Data ss:Type="String">RENCANA PENDISTRIBUSIAN ANGGARAN DIPA BID TIK POLDA JATIM 2026</Data>
                </Cell>
            </Row>
            <Row>
                <Cell ss:MergeAcross="15" ss:StyleID="Subjudul">
                    <Data ss:Type="String">Bidang TIK Kepolisian Daerah Jawa Timur</Data>
                </Cell>
            </Row>
            <Row>
                <Cell ss:MergeAcross="15">
                    <Data ss:Type="String">Satuan Kerja: {{ $scope }} - Dibuat: {{ now()->format('d M Y H:i') }} - {{ $rencana->count() }} item</Data>
                </Cell>
            </Row>
            <Row ss:Height="4"/>

            <Row>
                <Cell ss:StyleID="Header"><Data ss:Type="String">No</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Subsatker</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Uraian</Data></Cell>
                <Cell ss:StyleID="Header"><Data ss:Type="String">Pagu</Data></Cell>
                @foreach(\App\Models\RencanaAnggaran::BULAN_LABEL as $label)
                <Cell ss:StyleID="Header"><Data ss:Type="String">{{ $label }}</Data></Cell>
                @endforeach
            </Row>

            @forelse($rencana as $i => $item)
            <Row>
                <Cell><Data ss:Type="Number">{{ $i + 1 }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->satker }}</Data></Cell>
                <Cell ss:StyleID="Wrap"><Data ss:Type="String">{{ $item->item }}</Data></Cell>
                <Cell ss:StyleID="Angka"><Data ss:Type="Number">{{ $item->pagu }}</Data></Cell>
                @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                <Cell ss:StyleID="Angka"><Data ss:Type="Number">{{ $item->{$bln} }}</Data></Cell>
                @endforeach
            </Row>
            @empty
            <Row>
                <Cell ss:MergeAcross="15">
                    <Data ss:Type="String">Belum ada data rencana anggaran.</Data>
                </Cell>
            </Row>
            @endforelse

            @if($rencana->count() > 0)
            <Row>
                <Cell ss:MergeAcross="2" ss:StyleID="Total">
                    <Data ss:Type="String">TOTAL</Data>
                </Cell>
                <Cell ss:StyleID="Total"><Data ss:Type="Number">{{ $total }}</Data></Cell>
                @foreach(\App\Models\RencanaAnggaran::BULAN as $bln)
                <Cell ss:StyleID="Total"><Data ss:Type="Number">{{ $totalBulan[$bln] }}</Data></Cell>
                @endforeach
            </Row>
            @endif
        </Table>
    </Worksheet>
</Workbook>
