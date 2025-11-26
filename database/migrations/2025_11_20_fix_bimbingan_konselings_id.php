<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop dan recreate tabel dengan struktur yang benar
        Schema::dropIfExists('bimbingan_konselings');
        
        Schema::create('bimbingan_konselings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('topik', 200);
            $table->text('tindakan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('waktu')->nullable();
            $table->enum('status', ['terdaftar', 'diproses', 'selesai', 'tindak_lanjut', 'terjadwal', 'proses'])->default('terdaftar');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingan_konselings');
    }
};
