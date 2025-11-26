<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserWaliKelasSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Membuat user wali kelas...');
        
        // Ahmad Fauzi sebagai wali kelas (selain sebagai guru)
        User::create([
            'guru_id' => 5,
            'username' => '198501012010011001_wali',
            'email' => '198501012010011001.wali@guru.smk.com',
            'password' => Hash::make('198501012010011001'),
            'level' => 'wali_kelas',
            'can_verify' => false
        ]);

        // Siti Nurhaliza sebagai wali kelas (selain sebagai guru)
        User::create([
            'guru_id' => 6,
            'username' => '198702152011012002_wali',
            'email' => '198702152011012002.wali@guru.smk.com',
            'password' => Hash::make('198702152011012002'),
            'level' => 'wali_kelas',
            'can_verify' => false
        ]);

        $this->command->info('User wali kelas berhasil dibuat!');
    }
}