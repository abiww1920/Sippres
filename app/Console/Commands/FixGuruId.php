<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Guru;

class FixGuruId extends Command
{
    protected $signature = 'fix:guru-id';
    protected $description = 'Fix guru_id for existing users';

    public function handle()
    {
        $this->info('Memulai perbaikan guru_id untuk users...');
        
        // Update user guru dengan guru_id dari tabel guru
        $guruUser = User::where('level', 'guru')->first();
        if ($guruUser) {
            $guru = Guru::where('level', 'guru')->first();
            if ($guru) {
                User::where('level', 'guru')->update(['guru_id' => $guru->id]);
                $this->info("✓ User guru berhasil diupdate dengan guru_id: {$guru->id}");
            }
        }
        
        // Update user wali_kelas dengan guru_id dari tabel guru
        $waliKelasUser = User::where('level', 'wali_kelas')->first();
        if ($waliKelasUser) {
            $waliKelas = Guru::where('level', 'wali_kelas')->first();
            if ($waliKelas) {
                User::where('level', 'wali_kelas')->update(['guru_id' => $waliKelas->id]);
                $this->info("✓ User wali_kelas berhasil diupdate dengan guru_id: {$waliKelas->id}");
            }
        }
        
        // Update user konselor dengan guru_id dari tabel guru
        $konselorUser = User::where('level', 'konselor')->first();
        if ($konselorUser) {
            $konselor = Guru::where('level', 'konselor')->first();
            if ($konselor) {
                User::where('level', 'konselor')->update(['guru_id' => $konselor->id]);
                $this->info("✓ User konselor berhasil diupdate dengan guru_id: {$konselor->id}");
            }
        }
        
        // Update user kepala_sekolah dengan guru_id dari tabel guru
        $kepsekUser = User::where('level', 'kepala_sekolah')->first();
        if ($kepsekUser) {
            $kepsek = Guru::where('level', 'kepala_sekolah')->first();
            if ($kepsek) {
                User::where('level', 'kepala_sekolah')->update(['guru_id' => $kepsek->id]);
                $this->info("✓ User kepala_sekolah berhasil diupdate dengan guru_id: {$kepsek->id}");
            }
        }
        
        $this->info('Perbaikan selesai! Sekarang guru bisa input data pelanggaran.');
        
        return 0;
    }
}