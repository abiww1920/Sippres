<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Per Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .title { font-size: 18px; font-weight: bold; margin: 10px 0; }
        .subtitle { font-size: 14px; margin: 5px 0; }
        .section { margin: 20px 0; }
        .section-title { font-size: 14px; font-weight: bold; background: #f0f0f0; padding: 8px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 50px; }
        .signature { float: right; text-align: center; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PER SISWA</div>
        <div class="subtitle">Kelas: {{ $kelasWali->pluck('nama_kelas')->join(', ') }}</div>
        <div class="subtitle">Wali Kelas: {{ $guru->nama_guru }}</div>
        <div style="margin-top: 10px;">Tanggal: {{ date('d F Y') }}</div>
    </div>

    @foreach($siswaList as $siswa)
    <div class="section">
        <div class="section-title">DATA SISWA: {{ $siswa->nama_siswa }}</div>
        
        <table>
            <tr>
                <td width="20%"><strong>NIS</strong></td>
                <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
                <td><strong>Nama</strong></td>
                <td>{{ $siswa->nama_siswa }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>{{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}</td>
            </tr>
        </table>

        @if($siswa->pelanggaran->count() > 0)
        <h4>Riwayat Pelanggaran</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Poin</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa->pelanggaran as $index => $pelanggaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pelanggaran->created_at->format('d/m/Y') }}</td>
                    <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</td>
                    <td>{{ $pelanggaran->jenisPelanggaran->poin ?? 0 }}</td>
                    <td>{{ $pelanggaran->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p><em>Tidak ada riwayat pelanggaran</em></p>
        @endif

        @if($siswa->prestasi->count() > 0)
        <h4>Riwayat Prestasi</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis Prestasi</th>
                    <th>Tingkat</th>
                    <th>Juara</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa->prestasi as $index => $prestasi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $prestasi->tanggal_prestasi ?? $prestasi->created_at->format('d/m/Y') }}</td>
                    <td>{{ $prestasi->jenis_prestasi ?? $prestasi->nama_prestasi }}</td>
                    <td>{{ $prestasi->tingkat }}</td>
                    <td>{{ $prestasi->juara }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p><em>Tidak ada riwayat prestasi</em></p>
        @endif

        <hr style="margin: 30px 0;">
    </div>
    @endforeach

    <div class="footer">
        <div class="signature">
            <p>{{ date('d F Y') }}</p>
            <p>Wali Kelas</p>
            <br><br><br>
            <p><u>{{ $guru->nama_guru }}</u></p>
            <p>NIP: {{ $guru->nip }}</p>
        </div>
    </div>
</body>
</html>