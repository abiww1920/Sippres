<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #fd7e14; color: white; padding: 20px; text-align: center; }
        .content { background: #f8f9fa; padding: 20px; margin: 20px 0; }
        .info-row { margin: 10px 0; }
        .label { font-weight: bold; }
        .footer { text-align: center; color: #6c757d; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>⚠️ Notifikasi Sanksi</h2>
        </div>
        
        <div class="content">
            <p>Yth. Orang Tua/Wali dari:</p>
            
            <div class="info-row">
                <span class="label">Nama Siswa:</span> {{ $sanksi->pelanggaran->siswa->nama_siswa }}
            </div>
            <div class="info-row">
                <span class="label">NIS:</span> {{ $sanksi->pelanggaran->siswa->nis }}
            </div>
            <div class="info-row">
                <span class="label">Kelas:</span> {{ $sanksi->pelanggaran->siswa->kelas->nama_kelas ?? '-' }}
            </div>
            
            <hr>
            
            <div class="info-row">
                <span class="label">Jenis Sanksi:</span> {{ $sanksi->jenisSanksi->nama_sanksi }}
            </div>
            <div class="info-row">
                <span class="label">Tanggal Mulai:</span> {{ \Carbon\Carbon::parse($sanksi->tanggal_mulai)->format('d/m/Y') }}
            </div>
            <div class="info-row">
                <span class="label">Tanggal Selesai:</span> {{ \Carbon\Carbon::parse($sanksi->tanggal_selesai)->format('d/m/Y') }}
            </div>
            
            @if($sanksi->keterangan)
            <div class="info-row">
                <span class="label">Keterangan:</span><br>
                {{ $sanksi->keterangan }}
            </div>
            @endif
        </div>
        
        <p>Mohon untuk memastikan putra/putri Anda menjalankan sanksi yang telah ditetapkan.</p>
        
        <div class="footer">
            <p>Email ini dikirim otomatis oleh Sistem Informasi Pelanggaran Siswa</p>
            <p>Jangan membalas email ini</p>
        </div>
    </div>
</body>
</html>
