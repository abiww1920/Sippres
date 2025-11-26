<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $siswaData = [
            [
                'nis' => '2024001',
                'nama_siswa' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@smk.com',
                'kelas_id' => 1,
                'jurusan_id' => 1,
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 15',
                'no_hp' => '081234567890',
                'nama_ortu' => 'Budi Santoso',
                'no_hp_ortu' => '081234567891',
                'status' => 'aktif'
            ],
            [
                'nis' => '2024002',
                'nama_siswa' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@smk.com',
                'kelas_id' => 1,
                'jurusan_id' => 1,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Sudirman No. 22',
                'no_hp' => '081234567892',
                'nama_ortu' => 'Andi Wijaya',
                'no_hp_ortu' => '081234567893',
                'status' => 'aktif'
            ],
            [
                'nis' => '2024003',
                'nama_siswa' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@smk.com',
                'kelas_id' => 2,
                'jurusan_id' => 2,
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Gatot Subroto No. 8',
                'no_hp' => '081234567894',
                'nama_ortu' => 'Sari Dewi',
                'no_hp_ortu' => '081234567895',
                'status' => 'aktif'
            ],
            [
                'nis' => '2024004',
                'nama_siswa' => 'Maya Sari',
                'email' => 'maya.sari@smk.com',
                'kelas_id' => 2,
                'jurusan_id' => 2,
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Ahmad Yani No. 45',
                'no_hp' => '081234567896',
                'nama_ortu' => 'Rudi Hartono',
                'no_hp_ortu' => '081234567897',
                'status' => 'aktif'
            ],
            [
                'nis' => '2024005',
                'nama_siswa' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@smk.com',
                'kelas_id' => 3,
                'jurusan_id' => 3,
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Diponegoro No. 12',
                'no_hp' => '081234567898',
                'nama_ortu' => 'Lina Marlina',
                'no_hp_ortu' => '081234567899',
                'status' => 'aktif'
            ]
        ];

        foreach ($siswaData as $data) {
            Siswa::create($data);
        }
    }
}