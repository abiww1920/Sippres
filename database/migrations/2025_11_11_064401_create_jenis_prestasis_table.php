<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prestasi', 200);
            $table->integer('poin');
            $table->enum('kategori', ['akademik', 'non_akademik']);
            $table->string('penghargaan', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_prestasi');
    }
};
