<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JeniPelanggaran;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $jenisPelanggaran = [
            [
                'nama_pelanggaran' => 'Terlambat Masuk Sekolah',
                'poin' => 5,
                'kategori' => 'ringan',
                'sanksi_rekomendasi' => 'Teguran lisan, membersihkan halaman sekolah'
            ],
            [
                'nama_pelanggaran' => 'Tidak Mengerjakan PR',
                'poin' => 10,
                'kategori' => 'ringan',
                'sanksi_rekomendasi' => 'Teguran tertulis, mengerjakan tugas tambahan'
            ],
            [
                'nama_pelanggaran' => 'Tidak Memakai Seragam Lengkap',
                'poin' => 15,
                'kategori' => 'ringan',
                'sanksi_rekomendasi' => 'Teguran lisan, panggilan orang tua'
            ],
            [
                'nama_pelanggaran' => 'Ribut di Kelas',
                'poin' => 20,
                'kategori' => 'sedang',
                'sanksi_rekomendasi' => 'Teguran tertulis, bimbingan konseling'
            ],
            [
                'nama_pelanggaran' => 'Membolos',
                'poin' => 25,
                'kategori' => 'sedang',
                'sanksi_rekomendasi' => 'Panggilan orang tua, bimbingan konseling'
            ],
            [
                'nama_pelanggaran' => 'Merokok di Area Sekolah',
                'poin' => 50,
                'kategori' => 'berat',
                'sanksi_rekomendasi' => 'Skorsing 1 hari, panggilan orang tua'
            ],
            [
                'nama_pelanggaran' => 'Berkelahi',
                'poin' => 75,
                'kategori' => 'berat',
                'sanksi_rekomendasi' => 'Skorsing 3 hari, panggilan orang tua, bimbingan konseling'
            ],
            [
                'nama_pelanggaran' => 'Membawa Senjata Tajam',
                'poin' => 100,
                'kategori' => 'sangat_berat',
                'sanksi_rekomendasi' => 'Skorsing 1 minggu, panggilan orang tua, lapor polisi'
            ],
            [
                'nama_pelanggaran' => 'Narkoba',
                'poin' => 100,
                'kategori' => 'sangat_berat',
                'sanksi_rekomendasi' => 'Dikeluarkan dari sekolah, lapor polisi'
            ],
            [
                'nama_pelanggaran' => 'Tidak Sopan kepada Guru',
                'poin' => 30,
                'kategori' => 'sedang',
                'sanksi_rekomendasi' => 'Teguran tertulis, panggilan orang tua, bimbingan konseling'
            ]
        ];

        foreach ($jenisPelanggaran as $jenis) {
            JeniPelanggaran::create($jenis);
        }
    }
}