<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JeniSanksi;

class JeniSanksiSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSanksi = [
            [
                'nama_sanksi' => 'Teguran Lisan',
                'kategori' => 'Ringan',
                'deskripsi' => 'Pemberian teguran secara lisan kepada siswa'
            ],
            [
                'nama_sanksi' => 'Teguran Tertulis',
                'kategori' => 'Ringan',
                'deskripsi' => 'Pemberian surat teguran tertulis kepada siswa'
            ],
            [
                'nama_sanksi' => 'Membersihkan Lingkungan Sekolah',
                'kategori' => 'Sedang',
                'deskripsi' => 'Siswa diwajibkan membersihkan area tertentu di sekolah'
            ],
            [
                'nama_sanksi' => 'Skorsing 1 Hari',
                'kategori' => 'Sedang',
                'deskripsi' => 'Siswa tidak diperbolehkan mengikuti kegiatan belajar selama 1 hari'
            ],
            [
                'nama_sanksi' => 'Skorsing 3 Hari',
                'kategori' => 'Berat',
                'deskripsi' => 'Siswa tidak diperbolehkan mengikuti kegiatan belajar selama 3 hari'
            ],
            [
                'nama_sanksi' => 'Panggilan Orang Tua',
                'kategori' => 'Sedang',
                'deskripsi' => 'Memanggil orang tua siswa untuk konsultasi'
            ],
            [
                'nama_sanksi' => 'Bimbingan Konseling',
                'kategori' => 'Ringan',
                'deskripsi' => 'Siswa diwajibkan mengikuti sesi bimbingan konseling'
            ],
            [
                'nama_sanksi' => 'Poin Pelanggaran',
                'kategori' => 'Ringan',
                'deskripsi' => 'Pemberian poin pelanggaran sesuai dengan jenis pelanggaran'
            ]
        ];

        foreach ($jenisSanksi as $sanksi) {
            JeniSanksi::create($sanksi);
        }
    }
}