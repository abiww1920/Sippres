<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'guru_pencatat',
        'jenis_pelanggaran_id',
        'tahun_ajaran_id',
        'poin',
        'keterangan',
        'foto_bukti',
        'status_verifikasi',
        'catatan_verifikasi',
        'created_by'
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guruPencatat()
    {
        return $this->belongsTo(Guru::class, 'guru_pencatat');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JeniPelanggaran::class, 'jenis_pelanggaran_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class);
    }

    public function monitoring()
    {
        return $this->hasMany(MonitoringPelanggaran::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status_verifikasi', 'menunggu');
    }

    public function scopeDiverifikasi($query)
    {
        return $query->where('status_verifikasi', 'diverifikasi');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', 'ditolak');
    }
}