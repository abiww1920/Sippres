<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->string('no_hp', 15)->nullable()->after('alamat');
            $table->string('nama_ortu', 100)->nullable()->after('no_hp');
            $table->string('no_hp_ortu', 15)->nullable()->after('nama_ortu');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'no_hp', 'nama_ortu', 'no_hp_ortu']);
        });
    }
};