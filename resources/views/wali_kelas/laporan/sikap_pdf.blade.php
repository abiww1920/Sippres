<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penilaian Sikap</title>
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
        <div class="title">LAPORAN PENILAIAN SIKAP</div>
        <div class="subtitle">Periode: {{ ucfirst($periode) }}</div>
        <div class="subtitle">Format: {{ ucfirst($formatSikap) }}</div>
        <div class="subtitle">Kelas: {{ $kelasWali->pluck('nama_kelas')->join(', ') }}</div>
        <div class="subtitle">Wali Kelas: {{ $guru->nama_guru }}</div>
        <div style="margin-top: 10px;">Tanggal: {{ date('d F Y') }}</div>
    </div>

    <div class="section">
        <div class="section-title">PENILAIAN SIKAP SISWA</div>
        <p><em>Laporan penilaian sikap akan diimplementasikan berdasarkan akumulasi data pelanggaran dan prestasi.</em></p>
        
        @if($includeRekomendasi)
        <div class="section-title">REKOMENDASI PERBAIKAN</div>
        <p><em>Rekomendasi akan disertakan berdasarkan analisis data sikap siswa.</em></p>
        @endif
    </div>

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