<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JeniSanksi extends Model
{
    use HasFactory;

    protected $table = 'jenis_sanksi';

    protected $fillable = [
        'nama_sanksi',
        'kategori',
        'deskripsi'
    ];
}