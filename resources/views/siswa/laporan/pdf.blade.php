<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pelanggaran Saya</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 5px 0; }
        .info-siswa { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .status-box { margin-top: 20px; padding: 10px; border: 2px solid #000; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PELANGGARAN SISWA</h2>
        <p>Sistem Poin Pelanggaran Siswa</p>
    </div>

    <div class="info-siswa">
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 100px;"><strong>Nama</strong></td>
                <td style="border: none;">: {{ $siswa->nama_siswa }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>NIS</strong></td>
                <td style="border: none;">: {{ $siswa->nis }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;"><strong>Kelas</strong></td>
                <td style="border: none;">: {{ $siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <h3>Riwayat Pelanggaran</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
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
                <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                <td>{{ $p->poin }}</td>
                <td>{{ $p->createdBy->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" style="text-align: right;">Total Poin:</th>
                <th colspan="2">{{ $totalPoin }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="status-box">
        <h3>Status Sanksi</h3>
        <p><strong>Total Poin:</strong> {{ $totalPoin }}</p>
        <p><strong>Status:</strong> {{ $statusSanksi['status'] }}</p>
        <p><strong>Sanksi:</strong> {{ $statusSanksi['sanksi'] }}</p>
        
        <h4 style="margin-top: 15px;">Keterangan Tingkat Sanksi:</h4>
        <table>
            <tr>
                <th>Range Poin</th>
                <th>Status</th>
                <th>Sanksi</th>
            </tr>
            <tr>
                <td>1-15 poin</td>
                <td>Ringan</td>
                <td>Teguran, dll</td>
            </tr>
            <tr>
                <td>16-30 poin</td>
                <td>Sedang</td>
                <td>Kerja sosial, dll</td>
            </tr>
            <tr>
                <td>31-50 poin</td>
                <td>Berat</td>
                <td>Skorsing, dll</td>
            </tr>
            <tr>
                <td>51+ poin</td>
                <td>Sangat Berat</td>
                <td>Kemungkinan DO</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
