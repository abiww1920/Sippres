<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaran;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        $tahunAjaran = [
            [
                'tahun_ajaran' => '2023/2024',
                'semester' => 'ganjil',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2023/2024',
                'semester' => 'genap',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2024/2025',
                'semester' => 'ganjil',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran' => '2024/2025',
                'semester' => 'genap',
                'status_aktif' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($tahunAjaran as $data) {
            TahunAjaran::create($data);
        }
    }
}