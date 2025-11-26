<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\JeniPelanggaran;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API untuk get jenis pelanggaran (untuk auto-suggestion)
Route::get('/jenis-pelanggaran/{id}', function($id) {
    $jenis = JeniPelanggaran::findOrFail($id);
    return response()->json([
        'id' => $jenis->id,
        'nama_pelanggaran' => $jenis->nama_pelanggaran,
        'poin' => $jenis->poin,
        'kategori' => $jenis->kategori,
        'sanksi_rekomendasi' => $jenis->sanksi_rekomendasi,
        'kategori_label' => ucfirst(str_replace('_', ' ', $jenis->kategori)),
        'kategori_badge' => $this->getKategoriBadge($jenis->kategori)
    ]);
})->middleware('auth');

function getKategoriBadge($kategori) {
    $badges = [
        'ringan' => 'success',
        'sedang' => 'warning',
        'berat' => 'danger',
        'sangat_berat' => 'dark'
    ];
    return $badges[$kategori] ?? 'secondary';
}
