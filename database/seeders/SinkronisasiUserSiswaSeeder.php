<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Siswa;

class SinkronisasiUserSiswaSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Memulai sinkronisasi user siswa...');
        
        DB::beginTransaction();
        
        try {
            $siswaList = Siswa::all();
            $created = 0;
            $updated = 0;
            $skipped = 0;
            
            foreach ($siswaList as $siswa) {
                // Skip jika NIS kosong atau null
                if (empty($siswa->nis) || is_null($siswa->nis)) {
                    $this->command->warn("Siswa ID {$siswa->id} ({$siswa->nama_siswa}) tidak memiliki NIS, dilewati.");
                    $skipped++;
                    continue;
                }
                
                // Cek apakah sudah ada user untuk siswa ini
                $existingUser = User::where('siswa_id', $siswa->id)->first();
                
                if (!$existingUser) {
                    // Cek apakah username sudah digunakan
                    $existingUsername = User::where('username', $siswa->nis)->first();
                    
                    if (!$existingUsername) {
                        // Buat user baru untuk siswa
                        User::create([
                            'siswa_id' => $siswa->id,
                            'username' => $siswa->nis,
                            'email' => $siswa->email ?? $siswa->nis . '@siswa.smk.com',
                            'password' => Hash::make($siswa->nis),
                            'level' => 'siswa',
                            'can_verify' => false
                        ]);
                        $created++;
                        $this->command->info("User dibuat untuk siswa: {$siswa->nama_siswa} (NIS: {$siswa->nis})");
                    } else {
                        // Update user yang sudah ada dengan siswa_id jika belum ada
                        if (is_null($existingUsername->siswa_id)) {
                            $existingUsername->update([
                                'siswa_id' => $siswa->id,
                                'level' => 'siswa'
                            ]);
                            $updated++;
                            $this->command->info("User diupdate untuk siswa: {$siswa->nama_siswa} (NIS: {$siswa->nis})");
                        } else {
                            $this->command->warn("Username {$siswa->nis} sudah digunakan oleh siswa lain, dilewati.");
                            $skipped++;
                        }
                    }
                } else {
                    $this->command->info("User sudah ada untuk siswa: {$siswa->nama_siswa} (NIS: {$siswa->nis})");
                }
            }
            
            // Hapus user siswa yang tidak memiliki data siswa yang valid
            $siswaIds = Siswa::whereNotNull('nis')->pluck('id')->toArray();
            $deletedUsers = User::where('level', 'siswa')
                ->where(function($query) use ($siswaIds) {
                    $query->whereNull('siswa_id')
                          ->orWhereNotIn('siswa_id', $siswaIds);
                })
                ->delete();
            
            DB::commit();
            
            $this->command->info("Sinkronisasi selesai!");
            $this->command->info("- User dibuat: {$created}");
            $this->command->info("- User diupdate: {$updated}");
            $this->command->info("- User dihapus: {$deletedUsers}");
            $this->command->info("- Dilewati: {$skipped}");
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('Error saat sinkronisasi: ' . $e->getMessage());
            throw $e;
        }
    }
}