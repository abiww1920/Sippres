<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #333; }
        .badge-danger { background-color: #dc3545; }
        .badge-primary { background-color: #007bff; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PELANGGARAN SISWA</h1>
        <p>Sistem Informasi Pelanggaran dan Sanksi Siswa</p>
        <p>Periode: {{ $dari ? date('d/m/Y', strtotime($dari)) : 'Semua' }} - {{ $sampai ? date('d/m/Y', strtotime($sampai)) : 'Semua' }}</p>
    </div>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i') }}</p>
        <p><strong>Total Pelanggaran:</strong> {{ count($pelanggaranList) }}</p>
    </div>

    <div class="summary">
        <strong>Ringkasan:</strong>
        <ul style="margin: 5px 0; padding-left: 20px;">
            <li>Total Pelanggaran: {{ count($pelanggaranList) }}</li>
            <li>Rata-rata Poin: {{ number_format($pelanggaranList->avg('poin'), 1) }}</li>
            <li>Siswa Terlibat: {{ $pelanggaranList->unique('siswa_id')->count() }}</li>
        </ul>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 18%;">Siswa</th>
                <th style="width: 12%;">Kelas</th>
                <th style="width: 20%;">Jenis Pelanggaran</th>
                <th style="width: 12%;">Kategori</th>
                <th style="width: 8%;">Poin</th>
                <th style="width: 13%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelanggaranList as $pelanggaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pelanggaran->created_at->format('d/m/Y') }}</td>
                <td>{{ $pelanggaran->siswa->nama_siswa }}</td>
                <td>{{ $pelanggaran->siswa->kelas->nama_kelas }}</td>
                <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                <td>
                    @php
                        $kategori = $pelanggaran->jenisPelanggaran->kategori;
                        $badgeClass = match($kategori) {
                            'Ringan' => 'badge-success',
                            'Sedang' => 'badge-warning',
                            'Berat' => 'badge-danger',
                            'Sangat Berat' => 'badge-danger',
                            default => 'badge-primary'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $kategori }}</span>
                </td>
                <td style="text-align: center;">{{ $pelanggaran->poin }}</td>
                <td>
                    @if($pelanggaran->status_verifikasi == 'menunggu')
                        <span class="badge badge-warning">Menunggu</span>
                    @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                        <span class="badge badge-success">Diverifikasi</span>
                    @else
                        <span class="badge badge-danger">Ditolak</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
        <p>Sistem Informasi Pelanggaran Siswa</p>
    </div>
</body>
</html>
