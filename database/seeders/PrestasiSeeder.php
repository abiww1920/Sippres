<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\User;

class PrestasiSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Siswa::take(10)->get();
        $admin = User::where('level', 'admin')->first();
        
        if ($siswa->count() > 0 && $admin) {
            $prestasi = [
                [
                    'nama_prestasi' => 'Juara 1 Lomba Matematika',
                    'tingkat' => 'kabupaten',
                    'juara' => 'Juara 1',
                    'tanggal' => '2024-03-15',
                    'keterangan' => 'Meraih juara 1 dalam lomba matematika tingkat kabupaten'
                ],
                [
                    'nama_prestasi' => 'Juara 2 Lomba Bahasa Indonesia',
                    'tingkat' => 'provinsi',
                    'juara' => 'Juara 2',
                    'tanggal' => '2024-04-20',
                    'keterangan' => 'Meraih juara 2 dalam lomba bahasa Indonesia tingkat provinsi'
                ],
                [
                    'nama_prestasi' => 'Juara 3 Lomba Fisika',
                    'tingkat' => 'nasional',
                    'juara' => 'Juara 3',
                    'tanggal' => '2024-05-10',
                    'keterangan' => 'Meraih juara 3 dalam lomba fisika tingkat nasional'
                ],
                [
                    'nama_prestasi' => 'Juara Harapan 1 Lomba Kimia',
                    'tingkat' => 'sekolah',
                    'juara' => 'Harapan 1',
                    'tanggal' => '2024-02-28',
                    'keterangan' => 'Meraih juara harapan 1 dalam lomba kimia tingkat sekolah'
                ],
                [
                    'nama_prestasi' => 'Juara 1 Lomba Desain Grafis',
                    'tingkat' => 'kecamatan',
                    'juara' => 'Juara 1',
                    'tanggal' => '2024-06-05',
                    'keterangan' => 'Meraih juara 1 dalam lomba desain grafis tingkat kecamatan'
                ],
                [
                    'nama_prestasi' => 'Juara 2 Lomba Programming',
                    'tingkat' => 'provinsi',
                    'juara' => 'Juara 2',
                    'tanggal' => '2024-07-12',
                    'keterangan' => 'Meraih juara 2 dalam lomba programming tingkat provinsi'
                ],
                [
                    'nama_prestasi' => 'Juara 1 Lomba Robotika',
                    'tingkat' => 'internasional',
                    'juara' => 'Juara 1',
                    'tanggal' => '2024-08-18',
                    'keterangan' => 'Meraih juara 1 dalam lomba robotika tingkat internasional'
                ],
                [
                    'nama_prestasi' => 'Juara 3 Lomba Debat',
                    'tingkat' => 'kabupaten',
                    'juara' => 'Juara 3',
                    'tanggal' => '2024-09-22',
                    'keterangan' => 'Meraih juara 3 dalam lomba debat tingkat kabupaten'
                ]
            ];

            foreach ($prestasi as $index => $p) {
                if (isset($siswa[$index])) {
                    Prestasi::create([
                        'siswa_id' => $siswa[$index]->id,
                        'nama_prestasi' => $p['nama_prestasi'],
                        'tingkat' => $p['tingkat'],
                        'juara' => $p['juara'],
                        'tanggal' => $p['tanggal'],
                        'keterangan' => $p['keterangan'],
                        'created_by' => $admin->id
                    ]);
                }
            }
        }
    }
}