<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaFotoSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama dan tambah 5 siswa baru dengan foto
        Siswa::query()->delete();
        
        Siswa::create([
            'id' => 1,
            'nis' => '2024001',
            'nama_siswa' => 'Ahmad Rizki Pratama',
            'foto' => '1.png',
            'kelas_id' => 4, // XI RPL 2 (Handi Radiman)
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
            'no_hp' => '081234567890',
            'nama_ortu' => 'Budi Pratama',
            'no_hp_ortu' => '081234567891',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'id' => 2,
            'nis' => '2024002',
            'nama_siswa' => 'Siti Nurhaliza',
            'foto' => '2.png',
            'kelas_id' => 4, // XI RPL 2 (Handi Radiman)
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Sudirman No. 25, Bandung',
            'no_hp' => '081234567892',
            'nama_ortu' => 'Andi Nurhaliza',
            'no_hp_ortu' => '081234567893',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'id' => 3,
            'nis' => '2024003',
            'nama_siswa' => 'Dedi Kurniawan',
            'foto' => '3.png',
            'kelas_id' => 4, // XI RPL 2 (Handi Radiman)
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Asia Afrika No. 15, Bandung',
            'no_hp' => '081234567894',
            'nama_ortu' => 'Sari Kurniawan',
            'no_hp_ortu' => '081234567895',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'id' => 4,
            'nis' => '2024004',
            'nama_siswa' => 'Maya Sari Dewi',
            'foto' => '4.png',
            'kelas_id' => 1, // XII RPL 1
            'jenis_kelamin' => 'P',
            'alamat' => 'Jl. Braga No. 30, Bandung',
            'no_hp' => '081234567896',
            'nama_ortu' => 'Rudi Dewi',
            'no_hp_ortu' => '081234567897',
            'status' => 'aktif'
        ]);

        Siswa::create([
            'id' => 5,
            'nis' => '2024005',
            'nama_siswa' => 'Fajar Ramadhan',
            'foto' => '5.png',
            'kelas_id' => 1, // XII RPL 1
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Dago No. 45, Bandung',
            'no_hp' => '081234567898',
            'nama_ortu' => 'Ina Ramadhan',
            'no_hp_ortu' => '081234567899',
            'status' => 'aktif'
        ]);
    }
}