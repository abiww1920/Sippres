<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggaran</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .info { text-align: center; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2>LAPORAN PELANGGARAN SISWA</h2>
    <div class="info">
        @if($request->tanggal_mulai && $request->tanggal_selesai)
            Periode: {{ date('d/m/Y', strtotime($request->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($request->tanggal_selesai)) }}
        @else
            Semua Data
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="12%">Tanggal</th>
                <th width="10%">NIS</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="35%">Jenis Pelanggaran</th>
                <th width="8%" class="text-center">Poin</th>
                <th width="10%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                <td>{{ $item->siswa->nis }}</td>
                <td>{{ $item->siswa->nama_siswa }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $item->jenisPelanggaran->nama_pelanggaran }}</td>
                <td class="text-center">{{ $item->poin }}</td>
                <td class="text-center">{{ ucfirst($item->status_verifikasi) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 11px;">
        <p>Total Data: {{ $data->count() }} pelanggaran</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
