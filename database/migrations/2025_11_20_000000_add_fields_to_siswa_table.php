<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'email')) {
                $table->string('email')->nullable()->after('nama_siswa');
            }
            if (!Schema::hasColumn('siswa', 'no_telepon')) {
                $table->string('no_telepon')->nullable()->after('email');
            }
            if (!Schema::hasColumn('siswa', 'jurusan_id')) {
                $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null')->after('kelas_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('siswa', 'no_telepon')) {
                $table->dropColumn('no_telepon');
            }
            if (Schema::hasColumn('siswa', 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
        });
    }
};
