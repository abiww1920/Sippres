<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    use HasFactory;

    protected $table = 'sanksi';

    protected $fillable = [
        'pelanggaran_id',
        'jenis_sanksi',
        'deskripsi_sanksi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relationships
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }
    
    public function jenisSanksi()
    {
        return $this->belongsTo(JeniSanksi::class, 'jenis_sanksi', 'nama_sanksi');
    }

    public function pelaksanaanSanksi()
    {
        return $this->hasMany(PelaksanaanSanksi::class);
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['direncanakan', 'berjalan']);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}