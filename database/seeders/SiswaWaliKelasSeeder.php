<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaWaliKelasSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Menambahkan siswa untuk kelas wali kelas...');
        
        // Siswa untuk kelas XI RPL 1 (kelas_id = 2, wali kelas Ahmad Fauzi)
        Siswa::create([
            'nis' => '2023001',
            'nama_siswa' => 'Ahmad Rizki',
            'email' => '2023001@siswa.smk.com',
            'kelas_id' => 2,
            'jurusan_id' => 1,
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 10',
            'no_hp' => '081234567801',
            'nama_ortu' => 'Budi Santoso',
            'no_hp_ortu' => '081234567802',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'nis' => '2023002',
            'nama_siswa' => 'Siti Nurhaliza',
            'email' => '2023002@siswa.smk.com',
            'kelas_id' => 2,
            'jurusan_id' => 1,
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Sudirman No. 15',
            'no_hp' => '081234567803',
            'nama_ortu' => 'Andi Wijaya',
            'no_hp_ortu' => '081234567804',
            'status' => 'aktif'
        ]);

        // Siswa untuk kelas X TKJ 1 (kelas_id = 3, wali kelas Siti Nurhaliza)
        Siswa::create([
            'nis' => '2024001',
            'nama_siswa' => 'Dedi Kurniawan',
            'email' => '2024001@siswa.smk.com',
            'kelas_id' => 3,
            'jurusan_id' => 2,
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Gatot Subroto No. 20',
            'no_hp' => '081234567805',
            'nama_ortu' => 'Sari Dewi',
            'no_hp_ortu' => '081234567806',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'nis' => '2024002',
            'nama_siswa' => 'Maya Sari',
            'email' => '2024002@siswa.smk.com',
            'kelas_id' => 3,
            'jurusan_id' => 2,
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Ahmad Yani No. 25',
            'no_hp' => '081234567807',
            'nama_ortu' => 'Rudi Hartono',
            'no_hp_ortu' => '081234567808',
            'status' => 'aktif'
        ]);

        $this->command->info('Siswa berhasil ditambahkan!');
    }
}