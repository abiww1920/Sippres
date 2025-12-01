<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'email',
        'no_telepon',
        'foto',
        'kelas_id',
        'jurusan_id',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'nama_ortu',
        'no_hp_ortu',
        'status'
    ];

    // Relationships
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class);
    }

    public function sanksi()
    {
        return $this->hasManyThrough(Sanksi::class, Pelanggaran::class, 'siswa_id', 'pelanggaran_id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Helper methods
    public function getTotalPoinPelanggaran()
    {
        return $this->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
    }

    public function getTotalPoinPrestasi()
    {
        return $this->prestasi()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
    }

    public function getPoinBersih()
    {
        return $this->getTotalPoinPrestasi() - $this->getTotalPoinPelanggaran();
    }
}
