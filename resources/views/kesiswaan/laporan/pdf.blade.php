<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Kesiswaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELANGGARAN SISWA</h2>
        <p>Bagian Kesiswaan</p>
        @if(isset($filter['tanggal_dari']) && isset($filter['tanggal_sampai']))
            <p>Periode: {{ date('d/m/Y', strtotime($filter['tanggal_dari'])) }} - {{ date('d/m/Y', strtotime($filter['tanggal_sampai'])) }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggarans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
                <td>{{ $p->siswa->nis }}</td>
                <td>{{ $p->siswa->nama_siswa }}</td>
                <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td>{{ $p->poin }}</td>
                <td>{{ $p->createdBy->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-align: right;">Total Poin:</th>
                <th colspan="2">{{ $pelanggarans->sum('poin') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
