<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        Kelas::query()->delete();
        
        Kelas::create([
            'id' => 1,
            'nama_kelas' => 'XII RPL 1',
            'jurusan' => 'RPL',
            'wali_kelas_id' => 1 // Deni Danis
        ]);
        
        Kelas::create([
            'id' => 2,
            'nama_kelas' => 'XII RPL 2',
            'jurusan' => 'RPL', 
            'wali_kelas_id' => 2 // Syifa Febrianti
        ]);
        
        Kelas::create([
            'id' => 3,
            'nama_kelas' => 'XI RPL 1', 
            'jurusan' => 'RPL',
            'wali_kelas_id' => 3 // Ahmad Fauzi
        ]);
        
        Kelas::create([
            'id' => 4,
            'nama_kelas' => 'XI RPL 2',
            'jurusan' => 'RPL',
            'wali_kelas_id' => 11 // Handi Radiman S.sn
        ]);
        
        Kelas::create([
            'id' => 5,
            'nama_kelas' => 'X RPL 1',
            'jurusan' => 'RPL',
            'wali_kelas_id' => 9 // Ani Rahmawati
        ]);
    }
}