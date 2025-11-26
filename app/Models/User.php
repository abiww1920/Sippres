<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'guru_id',
        'siswa_id',
        'username',
        'email',
        'password',
        'level',
        'can_verify'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'can_verify' => 'boolean',
    ];

    // Relationships
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->level === 'admin';
    }

    public function isKesiswaan()
    {
        return $this->level === 'kesiswaan';
    }

    public function isGuru()
    {
        return $this->level === 'guru';
    }

    public function isWaliKelas()
    {
        return $this->level === 'wali_kelas';
    }

    public function isKonselor()
    {
        return $this->level === 'konselor';
    }

    public function isKepalaSekolah()
    {
        return $this->level === 'kepala_sekolah';
    }

    public function isSiswa()
    {
        return $this->level === 'siswa';
    }

    public function isOrangTua()
    {
        return $this->level === 'orang_tua';
    }
}
