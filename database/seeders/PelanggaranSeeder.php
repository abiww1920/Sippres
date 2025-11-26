<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JeniPelanggaran;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data siswa, jenis pelanggaran, dan guru
        $siswa = Siswa::all();
        $jenisPelanggaran = JeniPelanggaran::all();
        $guru = Guru::all();
        $tahunAjaran = TahunAjaran::first();

        if ($siswa->isEmpty() || $jenisPelanggaran->isEmpty() || $guru->isEmpty()) {
            $this->command->info('Tidak dapat membuat data pelanggaran: data siswa, jenis pelanggaran, atau guru tidak tersedia');
            return;
        }

        $pelanggaran = [
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Terlambat Masuk Sekolah')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 5,
                'keterangan' => 'Siswa terlambat masuk kelas pukul 07:30, seharusnya masuk pukul 07:00',
                'status_verifikasi' => 'diverifikasi',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Tidak Mengerjakan PR')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 10,
                'keterangan' => 'Tidak mengerjakan PR Matematika yang diberikan kemarin',
                'status_verifikasi' => 'diverifikasi',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Ribut di Kelas')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 20,
                'keterangan' => 'Membuat keributan saat jam pelajaran Bahasa Indonesia',
                'status_verifikasi' => 'menunggu',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Tidak Memakai Seragam Lengkap')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 15,
                'keterangan' => 'Tidak memakai dasi dan sepatu hitam sesuai aturan sekolah',
                'status_verifikasi' => 'diverifikasi',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Membolos')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 25,
                'keterangan' => 'Tidak masuk sekolah tanpa keterangan pada jam pelajaran ke 3-4',
                'status_verifikasi' => 'menunggu',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Tidak Sopan kepada Guru')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 30,
                'keterangan' => 'Berbicara tidak sopan kepada guru saat ditegur',
                'status_verifikasi' => 'diverifikasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Terlambat Masuk Sekolah')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 5,
                'keterangan' => 'Terlambat 15 menit karena macet',
                'status_verifikasi' => 'ditolak',
                'catatan_verifikasi' => 'Alasan tidak dapat diterima, sudah sering terlambat',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6)
            ],
            [
                'siswa_id' => $siswa->random()->id,
                'jenis_pelanggaran_id' => $jenisPelanggaran->where('nama_pelanggaran', 'Berkelahi')->first()->id,
                'guru_pencatat' => $guru->random()->id,
                'tahun_ajaran_id' => $tahunAjaran->id ?? 1,
                'poin' => 75,
                'keterangan' => 'Berkelahi dengan siswa lain di kantin sekolah',
                'status_verifikasi' => 'revisi',
                'catatan_verifikasi' => 'Perlu klarifikasi lebih detail mengenai kronologi kejadian',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7)
            ]
        ];

        foreach ($pelanggaran as $data) {
            Pelanggaran::create($data);
        }

        $this->command->info('Data pelanggaran berhasil dibuat: ' . count($pelanggaran) . ' records');
    }
}