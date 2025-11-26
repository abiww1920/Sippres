<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganKonseling extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_konselings';

    protected $fillable = [
        'siswa_id',
        'topik',
        'tindakan',
        'status',
        'tanggal',
        'waktu',
        'deskripsi',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    protected $dates = ['tanggal'];

    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function bimbinganKonseling()
    {
        return $this->hasMany(BimbinganKonseling::class, 'siswa_id');
    }

    public function guruKonselor()
    {
        return $this->belongsTo(Guru::class, 'guru_konselor');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'guru_konselor');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'terjadwal' => 'Terjadwal',
            'proses' => 'Proses',
            'selesai' => 'Selesai',
            default => $this->status
        };
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['terdaftar', 'diproses', 'tindak_lanjut', 'terjadwal', 'proses', 'selesai']);
    }
}

