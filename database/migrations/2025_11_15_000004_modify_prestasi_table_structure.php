<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['guru_pencatat']);
            $table->dropForeign(['jenis_prestasi_id']);
            $table->dropForeign(['tahun_ajaran_id']);
            
            // Drop columns
            $table->dropColumn(['guru_pencatat', 'jenis_prestasi_id', 'tahun_ajaran_id', 'poin', 'status_verifikasi']);
            
            // Add new columns
            $table->string('nama_prestasi')->after('siswa_id');
            $table->enum('tingkat', ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'])->after('nama_prestasi');
            $table->string('juara')->after('tingkat');
            $table->date('tanggal')->after('juara');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['nama_prestasi', 'tingkat', 'juara', 'tanggal']);
            $table->foreignId('guru_pencatat')->constrained('guru')->onDelete('cascade');
            $table->foreignId('jenis_prestasi_id')->constrained('jenis_prestasi')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->integer('poin');
            $table->enum('status_verifikasi', ['menunggu', 'diverifikasi', 'ditolak', 'revisi'])->default('menunggu');
        });
    }
};
