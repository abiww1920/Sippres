<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
        .content { background: #f8f9fa; padding: 20px; margin: 20px 0; }
        .info-row { margin: 10px 0; }
        .label { font-weight: bold; }
        .footer { text-align: center; color: #6c757d; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🚨 Notifikasi Pelanggaran Siswa</h2>
        </div>
        
        <div class="content">
            <p>Yth. Orang Tua/Wali dari:</p>
            
            <div class="info-row">
                <span class="label">Nama Siswa:</span> {{ $pelanggaran->siswa->nama_siswa }}
            </div>
            <div class="info-row">
                <span class="label">NIS:</span> {{ $pelanggaran->siswa->nis }}
            </div>
            <div class="info-row">
                <span class="label">Kelas:</span> {{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }}
            </div>
            
            <hr>
            
            <div class="info-row">
                <span class="label">Jenis Pelanggaran:</span> {{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}
            </div>
            <div class="info-row">
                <span class="label">Kategori:</span> 
                <span style="color: {{ $pelanggaran->jenisPelanggaran->kategori == 'Sangat Berat' ? '#dc3545' : ($pelanggaran->jenisPelanggaran->kategori == 'Berat' ? '#fd7e14' : '#ffc107') }}">
                    {{ $pelanggaran->jenisPelanggaran->kategori }}
                </span>
            </div>
            <div class="info-row">
                <span class="label">Poin:</span> {{ $pelanggaran->jenisPelanggaran->poin }}
            </div>
            <div class="info-row">
                <span class="label">Tanggal:</span> {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pelanggaran)->format('d/m/Y') }}
            </div>
            
            @if($pelanggaran->keterangan)
            <div class="info-row">
                <span class="label">Keterangan:</span><br>
                {{ $pelanggaran->keterangan }}
            </div>
            @endif
        </div>
        
        <p>Mohon untuk memberikan bimbingan kepada putra/putri Anda agar tidak mengulangi pelanggaran ini.</p>
        
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem Informasi Pelanggaran Siswa</p>
            <p>Jangan membalas email ini</p>
        </div>
    </div>
</body>
</html>
