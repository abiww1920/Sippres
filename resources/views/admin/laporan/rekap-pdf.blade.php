<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { text-align: center; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-center { text-align: center; }
        .summary { margin: 20px 0; padding: 15px; background: #f9f9f9; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h2>REKAP BULANAN PELANGGARAN & PRESTASI</h2>
    <div class="info">
        Periode: {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}
    </div>

    <div class="summary">
        <strong>Ringkasan:</strong><br>
        Total Pelanggaran: {{ $pelanggaran->count() }}<br>
        Total Prestasi: {{ $prestasi->count() }}
    </div>

    <h3>Rekap Per Kelas</h3>
    <table>
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th width="50%">Nama Kelas</th>
                <th width="20%" class="text-center">Total Pelanggaran</th>
                <th width="20%" class="text-center">Total Prestasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapPerKelas as $index => $kelas)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $kelas->nama_kelas }}</td>
                <td class="text-center">{{ $kelas->total_pelanggaran }}</td>
                <td class="text-center">{{ $kelas->total_prestasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 11px;">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
