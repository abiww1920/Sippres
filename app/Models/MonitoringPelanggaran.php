<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_konseling';

    protected $fillable = [
        'siswa_id',
        'guru_konselor',
        'topik',
        'tindakan',
        'status'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruKonselor()
    {
        return $this->belongsTo(Guru::class, 'guru_konselor');
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['terdaftar', 'diproses', 'tindak_lanjut']);
    }
}
