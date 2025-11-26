<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;

class UserGuruSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua guru dari database
        $guruList = Guru::all();
        
        foreach ($guruList as $guru) {
            // Cek apakah user sudah ada
            $existingUser = User::where('guru_id', $guru->id)->first();
            
            if (!$existingUser) {
                // Buat user dengan NIP sebagai username dan email
                User::create([
                    'username' => $guru->nip,
                    'email' => $guru->nip . '@smk.com',
                    'password' => Hash::make('guru123'), // Password default
                    'level' => 'guru',
                    'guru_id' => $guru->id,
                    'can_verify' => false
                ]);
            }
        }
        
        echo "User guru berhasil dibuat untuk " . $guruList->count() . " guru\n";
    }
}
