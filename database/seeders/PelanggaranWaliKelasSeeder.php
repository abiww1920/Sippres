<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggaran;
use Carbon\Carbon;

class PelanggaranWaliKelasSeeder extends Seeder
{
    public function run()
    {
        // Tambah pelanggaran untuk siswa di kelas XI RPL 2 (Handi Radiman)
        
        Pelanggaran::create([
            'siswa_id' => 1, // Ahmad Rizki Pratama
            'guru_pencatat' => 11, // Handi Radiman
            'jenis_pelanggaran_id' => 1, // Terlambat
            'tahun_ajaran_id' => 1,
            'poin' => 5,
            'keterangan' => 'Terlambat masuk kelas 15 menit',
            'status_verifikasi' => 'menunggu',
            'created_at' => Carbon::now()->subDays(2)
        ]);

        Pelanggaran::create([
            'siswa_id' => 2, // Siti Nurhaliza
            'guru_pencatat' => 11, // Handi Radiman
            'jenis_pelanggaran_id' => 2, // Tidak mengerjakan tugas
            'tahun_ajaran_id' => 1,
            'poin' => 3,
            'keterangan' => 'Tidak mengerjakan tugas pemrograman',
            'status_verifikasi' => 'menunggu',
            'created_at' => Carbon::now()->subDays(1)
        ]);

        Pelanggaran::create([
            'siswa_id' => 3, // Dedi Kurniawan
            'guru_pencatat' => 11, // Handi Radiman
            'jenis_pelanggaran_id' => 5, // Ribut di kelas
            'tahun_ajaran_id' => 1,
            'poin' => 5,
            'keterangan' => 'Ribut saat pelajaran berlangsung',
            'status_verifikasi' => 'diverifikasi',
            'created_at' => Carbon::now()->subDays(3)
        ]);
    }
}
