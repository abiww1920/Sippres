<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada
        Guru::query()->delete();
        
        // Guru untuk user wali kelas
        Guru::create([
            'id' => 1,
            'nip' => 'walikelas',
            'nama_guru' => 'Wali Kelas',
            'bidang_studi' => 'Matematika',
            'status' => 'aktif'
        ]);

        // Guru untuk user guru
        Guru::create([
            'id' => 2,
            'nip' => 'guru',
            'nama_guru' => 'Guru',
            'bidang_studi' => 'Bahasa Indonesia',
            'status' => 'aktif'
        ]);

        // Guru untuk user konselor
        Guru::create([
            'id' => 3,
            'nip' => 'konselor',
            'nama_guru' => 'Konselor',
            'bidang_studi' => 'Bimbingan Konseling',
            'status' => 'aktif'
        ]);

        // Guru untuk kepala sekolah
        Guru::create([
            'id' => 4,
            'nip' => 'kepsek',
            'nama_guru' => 'Kepala Sekolah',
            'bidang_studi' => 'Manajemen',
            'status' => 'aktif'
        ]);

        // Guru tambahan
        Guru::create([
            'id' => 5,
            'nip' => '198501012010011001',
            'nama_guru' => 'Ahmad Fauzi, S.Pd',
            'bidang_studi' => 'Fisika',
            'status' => 'aktif'
        ]);

        Guru::create([
            'id' => 6,
            'nip' => '198702152011012002',
            'nama_guru' => 'Siti Nurhaliza, S.Kom',
            'bidang_studi' => 'Pemrograman',
            'status' => 'aktif'
        ]);

        Guru::create([
            'id' => 7,
            'nip' => '198903202012011003',
            'nama_guru' => 'Budi Santoso, S.Pd',
            'bidang_studi' => 'Bahasa Inggris',
            'status' => 'aktif'
        ]);

        Guru::create([
            'id' => 8,
            'nip' => '199001202011011008',
            'nama_guru' => 'Bambang Supriyanto, S.Pd',
            'bidang_studi' => 'Kesiswaan',
            'status' => 'aktif'
        ]);

        Guru::create([
            'id' => 9,
            'nip' => '198803152012012009',
            'nama_guru' => 'Ani Rahmawati, S.Pd',
            'bidang_studi' => 'Matematika',
            'status' => 'aktif'
        ]);

        // Tambah guru Handi Radiman S.sn
        Guru::create([
            'id' => 11,
            'nip' => '198501012010011005',
            'nama_guru' => 'Handi Radiman S.sn',
            'bidang_studi' => 'Seni Budaya',
            'status' => 'aktif'
        ]);
    }
}