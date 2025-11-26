<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bimbingan Konseling</title>
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
        <h2>LAPORAN BIMBINGAN KONSELING</h2>
        <p>Guru BK/Konselor</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Topik</th>
                <th>Tindakan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $l)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $l->tanggal->format('d/m/Y') }}</td>
                <td>{{ $l->siswa->nis }}</td>
                <td>{{ $l->siswa->nama_siswa }}</td>
                <td>{{ $l->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $l->topik }}</td>
                <td>{{ $l->tindakan }}</td>
                <td>{{ ucfirst($l->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data bimbingan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
