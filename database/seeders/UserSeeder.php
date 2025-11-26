<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        User::query()->delete();
        
        // Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@smk.com',
            'password' => Hash::make('admin123'),
            'level' => 'admin',
            'can_verify' => true
        ]);

        // Kesiswaan
        User::create([
            'username' => 'kesiswaan',
            'email' => 'kesiswaan@smk.com',
            'password' => Hash::make('kesiswaan123'),
            'level' => 'kesiswaan',
            'can_verify' => true
        ]);

        // Guru - Deni Danis
        User::create([
            'username' => 'deni',
            'email' => 'deni@smk.com',
            'password' => Hash::make('deni123'),
            'level' => 'guru',
            'guru_id' => 1,
            'can_verify' => false
        ]);

        // Guru - Syifa Febrianti
        User::create([
            'username' => 'syifa',
            'email' => 'syifa@smk.com',
            'password' => Hash::make('syifa123'),
            'level' => 'guru',
            'guru_id' => 2,
            'can_verify' => false
        ]);

        // Guru - Ahmad Fauzi
        User::create([
            'username' => 'fauzi',
            'email' => 'fauzi@smk.com',
            'password' => Hash::make('fauzi123'),
            'level' => 'guru',
            'guru_id' => 3,
            'can_verify' => false
        ]);

        // Guru - Rina Wijaya
        User::create([
            'username' => 'rina',
            'email' => 'rina@smk.com',
            'password' => Hash::make('rina123'),
            'level' => 'guru',
            'guru_id' => 4,
            'can_verify' => false
        ]);

        // Guru - Dedi Kurniawan (Guru)
        User::create([
            'username' => 'dedikur',
            'email' => 'dedikur@smk.com',
            'password' => Hash::make('dedikur123'),
            'level' => 'guru',
            'guru_id' => 5,
            'can_verify' => false
        ]);

        // Kepala Sekolah - Dr. Hendra Wijaya
        User::create([
            'username' => 'hendra',
            'email' => 'hendra@smk.com',
            'password' => Hash::make('hendra123'),
            'level' => 'kepala_sekolah',
            'guru_id' => 6,
            'can_verify' => true
        ]);

        // Konselor - Lilis Suryani
        User::create([
            'username' => 'lilis',
            'email' => 'lilis@smk.com',
            'password' => Hash::make('lilis123'),
            'level' => 'konselor',
            'guru_id' => 7,
            'can_verify' => true
        ]);

        // Kesiswaan - Bambang Supriyanto
        User::create([
            'username' => 'bambang',
            'email' => 'bambang@smk.com',
            'password' => Hash::make('bambang123'),
            'level' => 'kesiswaan',
            'guru_id' => 8,
            'can_verify' => true
        ]);

        // Siswa - Ahmad Rizki Pratama
        User::create([
            'username' => 'ahmad',
            'email' => 'ahmad@smk.com',
            'password' => Hash::make('ahmad123'),
            'level' => 'siswa',
            'siswa_id' => 1,
            'can_verify' => false
        ]);

        // Siswa - Siti Nurhaliza
        User::create([
            'username' => 'siti',
            'email' => 'siti@smk.com',
            'password' => Hash::make('siti123'),
            'level' => 'siswa',
            'siswa_id' => 2,
            'can_verify' => false
        ]);

        // Siswa - Dedi Kurniawan
        User::create([
            'username' => 'dedi',
            'email' => 'dedi@smk.com',
            'password' => Hash::make('dedi123'),
            'level' => 'siswa',
            'siswa_id' => 3,
            'can_verify' => false
        ]);

        // Siswa - Maya Sari Dewi
        User::create([
            'username' => 'maya',
            'email' => 'maya@smk.com',
            'password' => Hash::make('maya123'),
            'level' => 'siswa',
            'siswa_id' => 4,
            'can_verify' => false
        ]);

        // Siswa - Fajar Ramadhan
        User::create([
            'username' => 'fajar',
            'email' => 'fajar@smk.com',
            'password' => Hash::make('fajar123'),
            'level' => 'siswa',
            'siswa_id' => 5,
            'can_verify' => false
        ]);

        // Orang Tua
        User::create([
            'username' => 'ortu',
            'email' => 'ortu@gmail.com',
            'password' => Hash::make('ortu123'),
            'level' => 'orang_tua',
            'can_verify' => false
        ]);

        // Handi Radiman sebagai Wali Kelas
        User::create([
            'username' => 'handi',
            'email' => 'handi@smk.com',
            'password' => Hash::make('handi123'),
            'level' => 'wali_kelas',
            'guru_id' => 11, // ID Handi Radiman
            'can_verify' => false
        ]);
    }
}