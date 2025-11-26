<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id')->nullable();
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('level', ['admin', 'kesiswaan', 'guru', 'wali_kelas', 'konselor', 'kepala_sekolah', 'siswa', 'orang_tua']);
            $table->boolean('can_verify')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
