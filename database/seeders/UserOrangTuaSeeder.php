<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class UserOrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua siswa
        $siswa = Siswa::all();
        
        foreach ($siswa as $s) {
            // Cek apakah user orang tua sudah ada
            $existingUser = User::where('siswa_id', $s->id)
                ->where('level', 'orang_tua')
                ->first();
            
            if (!$existingUser) {
                User::create([
                    'username' => 'ortu_' . $s->nis,
                    'email' => 'ortu_' . $s->nis . '@sekolah.com',
                    'password' => Hash::make($s->no_hp_ortu ?: 'password'),
                    'level' => 'orang_tua',
                    'siswa_id' => $s->id,
                    'can_verify' => false
                ]);
            }
        }
        
        $this->command->info('User orang tua berhasil dibuat untuk ' . $siswa->count() . ' siswa');
    }
}
