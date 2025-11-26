<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JeniPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';

    protected $fillable = [
        'nama_pelanggaran',
        'poin',
        'kategori',
        'sanksi_rekomendasi'
    ];

    // Relationships
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
