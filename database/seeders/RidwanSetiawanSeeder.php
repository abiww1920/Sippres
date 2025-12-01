<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kelas;

class RidwanSetiawanSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Membuat data Ridwan Setiawan...');
        
        // Buat data guru Ridwan Setiawan
        $guru = Guru::create([
            'nip' => '198505152010011010',
            'nama_guru' => 'Ridwan Setiawan, S.Pd',
            'bidang_studi' => 'Pemrograman Web',
            'status' => 'aktif'
        ]);

        // Update kelas X RPL 1 agar wali kelasnya Ridwan Setiawan
        Kelas::where('nama_kelas', 'X RPL 1')->update([
            'wali_kelas_id' => $guru->id
        ]);

        // Buat user untuk Ridwan Setiawan sebagai wali kelas
        User::create([
            'guru_id' => $guru->id,
            'username' => 'ridwan.setiawan',
            'email' => 'ridwan.setiawan@smk.com',
            'password' => Hash::make('password'),
            'level' => 'wali_kelas',
            'can_verify' => false
        ]);

        $this->command->info('Data Ridwan Setiawan berhasil dibuat!');
        $this->command->info('Username: ridwan.setiawan');
        $this->command->info('Password: password');
    }
}