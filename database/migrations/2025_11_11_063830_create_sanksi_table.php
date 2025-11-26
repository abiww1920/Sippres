<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sanksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggaran_id')->constrained('pelanggaran')->onDelete('cascade');
            $table->string('jenis_sanksi', 200);
            $table->text('deskripsi_sanksi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['direncanakan', 'berjalan', 'selesai', 'ditunda', 'dibatalkan'])->default('direncanakan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sanksi');
    }
};

