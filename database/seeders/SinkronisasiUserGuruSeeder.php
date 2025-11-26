<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Guru;

class SinkronisasiUserGuruSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Memulai sinkronisasi user guru...');
        
        DB::beginTransaction();
        
        try {
            $guruList = Guru::all();
            $created = 0;
            $updated = 0;
            $skipped = 0;
            
            foreach ($guruList as $guru) {
                // Skip jika NIP kosong atau null
                if (empty($guru->nip) || is_null($guru->nip)) {
                    $this->command->warn("Guru ID {$guru->id} ({$guru->nama_guru}) tidak memiliki NIP, dilewati.");
                    $skipped++;
                    continue;
                }
                
                // Cek apakah sudah ada user untuk guru ini
                $existingUser = User::where('guru_id', $guru->id)->first();
                
                if (!$existingUser) {
                    // Cek apakah username sudah digunakan
                    $existingUsername = User::where('username', $guru->nip)->first();
                    
                    if (!$existingUsername) {
                        // Buat user baru untuk guru
                        User::create([
                            'guru_id' => $guru->id,
                            'username' => $guru->nip,
                            'email' => $guru->nip . '@guru.smk.com',
                            'password' => Hash::make($guru->nip),
                            'level' => 'guru',
                            'can_verify' => false
                        ]);
                        $created++;
                        $this->command->info("User dibuat untuk guru: {$guru->nama_guru} (NIP: {$guru->nip})");
                    } else {
                        // Update user yang sudah ada dengan guru_id jika belum ada
                        if (is_null($existingUsername->guru_id)) {
                            $existingUsername->update([
                                'guru_id' => $guru->id,
                                'level' => 'guru'
                            ]);
                            $updated++;
                            $this->command->info("User diupdate untuk guru: {$guru->nama_guru} (NIP: {$guru->nip})");
                        } else {
                            $this->command->warn("Username {$guru->nip} sudah digunakan oleh guru lain, dilewati.");
                            $skipped++;
                        }
                    }
                } else {
                    $this->command->info("User sudah ada untuk guru: {$guru->nama_guru} (NIP: {$guru->nip})");
                }
            }
            
            DB::commit();
            
            $this->command->info("Sinkronisasi selesai!");
            $this->command->info("- User dibuat: {$created}");
            $this->command->info("- User diupdate: {$updated}");
            $this->command->info("- Dilewati: {$skipped}");
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('Error saat sinkronisasi: ' . $e->getMessage());
            throw $e;
        }
    }
}