<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Bulanan Kelas - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { width: 80px; height: 80px; }
        .title { font-size: 18px; font-weight: bold; margin: 10px 0; }
        .subtitle { font-size: 14px; margin: 5px 0; }
        .section { margin: 20px 0; }
        .section-title { font-size: 14px; font-weight: bold; background: #f0f0f0; padding: 8px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .stats-box { display: inline-block; width: 30%; margin: 1%; padding: 15px; border: 1px solid #ddd; text-align: center; }
        .stats-number { font-size: 24px; font-weight: bold; color: #2c5aa0; }
        .footer { margin-top: 50px; }
        .signature { float: right; text-align: center; margin-top: 50px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="title">LAPORAN BULANAN KELAS</div>
        <div class="subtitle">{{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</div>
        <div class="subtitle">Kelas: {{ $kelasWali->pluck('nama_kelas')->join(', ') }}</div>
        <div class="subtitle">Wali Kelas: {{ $guru->nama_guru }}</div>
        <div style="margin-top: 10px;">Tanggal Pembuatan: {{ date('d F Y') }}</div>
    </div>

    <!-- Ringkasan Eksekutif -->
    <div class="section">
        <div class="section-title">RINGKASAN EKSEKUTIF</div>
        <div class="stats-box">
            <div class="stats-number">{{ $kelasWali->sum(function($kelas) { return $kelas->siswa->count(); }) }}</div>
            <div>Total Siswa</div>
        </div>
        <div class="stats-box">
            <div class="stats-number">{{ $pelanggarans->count() }}</div>
            <div>Total Pelanggaran</div>
        </div>
        <div class="stats-box">
            <div class="stats-number">{{ $prestasis->count() }}</div>
            <div>Total Prestasi</div>
        </div>
    </div>

    @if(in_array('pelanggaran', $konten))
    <!-- Statistik Pelanggaran -->
    <div class="section">
        <div class="section-title">STATISTIK PELANGGARAN</div>
        @if($pelanggarans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggarans as $index => $pelanggaran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pelanggaran->siswa->nama_siswa }}</td>
                        <td>{{ $pelanggaran->siswa->kelas->nama_kelas }}</td>
                        <td>{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                        <td>{{ $pelanggaran->jenisPelanggaran->poin }}</td>
                        <td>{{ $pelanggaran->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada pelanggaran pada bulan ini.</p>
        @endif
    </div>
    @endif

    @if(in_array('prestasi', $konten))
    <!-- Statistik Prestasi -->
    <div class="section">
        <div class="section-title">STATISTIK PRESTASI</div>
        @if($prestasis->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Prestasi</th>
                        <th>Tingkat</th>
                        <th>Juara</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestasis as $index => $prestasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $prestasi->siswa->nama_siswa }}</td>
                        <td>{{ $prestasi->siswa->kelas->nama_kelas }}</td>
                        <td>{{ $prestasi->jenis_prestasi }}</td>
                        <td>{{ $prestasi->tingkat }}</td>
                        <td>{{ $prestasi->juara }}</td>
                        <td>{{ $prestasi->tanggal_prestasi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada prestasi pada bulan ini.</p>
        @endif
    </div>
    @endif

    <!-- Analisis dan Evaluasi -->
    <div class="section">
        <div class="section-title">ANALISIS DAN EVALUASI</div>
        <p><strong>Kondisi Kelas:</strong></p>
        <ul>
            <li>Total pelanggaran bulan ini: {{ $pelanggarans->count() }} kasus</li>
            <li>Total prestasi bulan ini: {{ $prestasis->count() }} prestasi</li>
            <li>Tingkat kedisiplinan: {{ $pelanggarans->count() == 0 ? 'Sangat Baik' : ($pelanggarans->count() <= 5 ? 'Baik' : 'Perlu Perbaikan') }}</li>
        </ul>
    </div>

    <!-- Rekomendasi -->
    <div class="section">
        <div class="section-title">REKOMENDASI TINDAK LANJUT</div>
        <ul>
            @if($pelanggarans->count() > 10)
                <li>Perlu intensifikasi bimbingan kelas dan koordinasi dengan orang tua</li>
                <li>Implementasi program pembinaan khusus untuk siswa bermasalah</li>
            @elseif($pelanggarans->count() > 5)
                <li>Tingkatkan monitoring dan pendampingan siswa</li>
                <li>Koordinasi dengan guru mata pelajaran</li>
            @else
                <li>Pertahankan kondisi kedisiplinan yang baik</li>
                <li>Berikan apresiasi kepada siswa berprestasi</li>
            @endif
            
            @if($prestasis->count() > 0)
                <li>Berikan apresiasi dan motivasi kepada siswa berprestasi</li>
                <li>Jadikan siswa berprestasi sebagai role model</li>
            @endif
        </ul>
    </div>

    <!-- Footer -->
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