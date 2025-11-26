<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 50)->unique();
            $table->string('nama_siswa', 100);
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'drop_out', 'cuti'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
