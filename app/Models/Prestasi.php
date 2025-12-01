<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected $fillable = [
        'siswa_id',
        'jenis_prestasi',
        'nama_prestasi',
        'tingkat',
        'juara',
        'tanggal_prestasi',
        'keterangan',
        'poin',
        'sertifikat',
        'status_verifikasi',
        'catatan_verifikasi',
        'created_by'
    ];

    protected $casts = [
        'tanggal_prestasi' => 'date',
    ];

    // Relationships
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper method to get poin based on tingkat and juara
    public function getPoinAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $basePoin = [
            'sekolah' => 10,
            'kecamatan' => 20,
            'kabupaten' => 30,
            'provinsi' => 40,
            'nasional' => 50,
            'internasional' => 60
        ];

        $multiplier = [
            'Juara 1' => 1.0,
            'Juara 2' => 0.8,
            'Juara 3' => 0.6,
            'Harapan' => 0.4
        ];

        $base = $basePoin[$this->tingkat] ?? 10;
        $mult = $multiplier[$this->juara] ?? 0.4;

        return (int) ($base * $mult);
    }
}
