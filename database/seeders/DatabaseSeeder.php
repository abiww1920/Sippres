<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            SinkronisasiUserGuruSeeder::class,
            UserWaliKelasSeeder::class,
            JeniSanksiSeeder::class,
            TahunAjaranSeeder::class,
            JurusanSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            SinkronisasiUserSiswaSeeder::class,
            SiswaFotoSeeder::class,
            JenisPelanggaranSeeder::class,
            PelanggaranSeeder::class,
            PrestasiSeeder::class,
        ]);
    }
}
