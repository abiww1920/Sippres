# Konselor Routes Reference

## 📍 Base URL
```
http://localhost/UjikomAbi
```

## 🔐 Middleware
```
role:konselor
```

---

## 📋 Routes List

### Dashboard
| Method | Route | Name | Controller | Description |
|--------|-------|------|-----------|-------------|
| GET | `/konselor/dashboard` | `konselor.dashboard` | DashboardController@index | Dashboard dengan statistik |

---

### Bimbingan Konseling

#### List & Create
| Method | Route | Name | Controller | Description |
|--------|-------|------|-----------|-------------|
| GET | `/konselor/bimbingan` | `konselor.bimbingan.index` | BimbinganController@index | Daftar bimbingan |
| GET | `/konselor/bimbingan/create` | `konselor.bimbingan.create` | BimbinganController@create | Form input bimbingan |
| POST | `/konselor/bimbingan` | `konselor.bimbingan.store` | BimbinganController@store | Simpan bimbingan baru |

#### Detail, Edit, Delete
| Method | Route | Name | Controller | Description |
|--------|-------|------|-----------|-------------|
| GET | `/konselor/bimbingan/{bimbingan}` | `konselor.bimbingan.show` | BimbinganController@show | Detail bimbingan |
| GET | `/konselor/bimbingan/{bimbingan}/edit` | `konselor.bimbingan.edit` | BimbinganController@edit | Form edit bimbingan |
| PUT | `/konselor/bimbingan/{bimbingan}` | `konselor.bimbingan.update` | BimbinganController@update | Update bimbingan |
| DELETE | `/konselor/bimbingan/{bimbingan}` | `konselor.bimbingan.destroy` | BimbinganController@destroy | Hapus bimbingan |

---

### Siswa

| Method | Route | Name | Controller | Description |
|--------|-------|------|-----------|-------------|
| GET | `/konselor/siswa` | `konselor.siswa.index` | SiswaController@index | Daftar siswa |
| GET | `/konselor/siswa/{siswa}` | `konselor.siswa.show` | SiswaController@show | Detail siswa |

---

### Laporan

| Method | Route | Name | Controller | Description |
|--------|-------|------|-----------|-------------|
| GET | `/konselor/laporan` | `konselor.laporan.index` | LaporanController@index | Laporan bimbingan |
| GET | `/konselor/laporan/export-excel` | `konselor.laporan.export-excel` | LaporanController@exportExcel | Export ke Excel |
| GET | `/konselor/laporan/export-pdf` | `konselor.laporan.export-pdf` | LaporanController@exportPdf | Export ke PDF |

---

## 🔗 URL Examples

### Dashboard
```
GET /konselor/dashboard
```

### Bimbingan
```
GET /konselor/bimbingan                    # Daftar
GET /konselor/bimbingan/create             # Form input
POST /konselor/bimbingan                   # Simpan
GET /konselor/bimbingan/1                  # Detail
GET /konselor/bimbingan/1/edit             # Form edit
PUT /konselor/bimbingan/1                  # Update
DELETE /konselor/bimbingan/1               # Hapus
```

### Siswa
```
GET /konselor/siswa                        # Daftar
GET /konselor/siswa/1                      # Detail
```

### Laporan
```
GET /konselor/laporan                      # Laporan
GET /konselor/laporan/export-excel         # Export Excel
GET /konselor/laporan/export-pdf           # Export PDF
```

---

## 🎯 Route Names (untuk Blade)

### Dashboard
```blade
{{ route('konselor.dashboard') }}
```

### Bimbingan
```blade
{{ route('konselor.bimbingan.index') }}
{{ route('konselor.bimbingan.create') }}
{{ route('konselor.bimbingan.store') }}
{{ route('konselor.bimbingan.show', $bimbingan->id) }}
{{ route('konselor.bimbingan.edit', $bimbingan->id) }}
{{ route('konselor.bimbingan.update', $bimbingan->id) }}
{{ route('konselor.bimbingan.destroy', $bimbingan->id) }}
```

### Siswa
```blade
{{ route('konselor.siswa.index') }}
{{ route('konselor.siswa.show', $siswa->id) }}
```

### Laporan
```blade
{{ route('konselor.laporan.index') }}
{{ route('konselor.laporan.export-excel') }}
{{ route('konselor.laporan.export-pdf') }}
```

---

## 📝 Query Parameters

### Laporan Filter
```
GET /konselor/laporan?bulan=2025-11&status=selesai
```

**Parameters:**
- `bulan` (optional): Format YYYY-MM (e.g., 2025-11)
- `status` (optional): terjadwal, proses, selesai

---

## 🔐 Authentication

Semua routes memerlukan:
1. User harus login (`middleware:auth`)
2. User harus memiliki role 'konselor' (`middleware:role:konselor`)

---

## 📊 HTTP Methods

| Method | Purpose |
|--------|---------|
| GET | Retrieve data / Display form |
| POST | Create new data |
| PUT | Update existing data |
| DELETE | Delete data |

---

## 🎨 Response Types

### HTML (Default)
- Menampilkan view blade
- Redirect ke halaman lain

### JSON (Optional)
- Untuk API calls
- Laporan export

---

## 🚀 Testing Routes

### Menggunakan Artisan Tinker
```bash
php artisan tinker
```

```php
// Test route
route('konselor.dashboard')
route('konselor.bimbingan.index')
route('konselor.siswa.index')
route('konselor.laporan.index')
```

### Menggunakan Postman
```
GET http://localhost/UjikomAbi/konselor/dashboard
Authorization: Bearer {token}
```

---

## 📋 Route Groups

### Konselor Group
```php
Route::middleware('role:konselor')->group(function () {
    // Dashboard
    Route::get('/konselor/dashboard', ...);
    
    // Bimbingan
    Route::resource('/konselor/bimbingan', ...);
    
    // Siswa
    Route::resource('/konselor/siswa', ...);
    
    // Laporan
    Route::get('/konselor/laporan', ...);
    Route::get('/konselor/laporan/export-excel', ...);
    Route::get('/konselor/laporan/export-pdf', ...);
});
```

---

## 🔍 Route Debugging

### List semua routes
```bash
php artisan route:list
```

### Filter routes Konselor
```bash
php artisan route:list --name=konselor
```

### Show route details
```bash
php artisan route:list --name=konselor.dashboard
```

---

## 📌 Important Notes

1. **Semua routes memerlukan authentication**
   - User harus login terlebih dahulu
   - Session harus valid

2. **Role-based access control**
   - Hanya user dengan role 'konselor' yang bisa akses
   - Jika role berbeda, akan mendapat error 403 Unauthorized

3. **Model Binding**
   - Route parameter `{bimbingan}` dan `{siswa}` menggunakan model binding
   - Otomatis inject model ke controller

4. **CSRF Protection**
   - POST, PUT, DELETE memerlukan CSRF token
   - Sudah included di form blade

5. **Pagination**
   - Routes index menggunakan pagination
   - Default 10 items per page

---

## 🎯 Common Use Cases

### Membuat Bimbingan Baru
```
1. GET /konselor/bimbingan/create (tampilkan form)
2. POST /konselor/bimbingan (submit form)
3. Redirect ke /konselor/bimbingan (daftar)
```

### Edit Bimbingan
```
1. GET /konselor/bimbingan/1/edit (tampilkan form)
2. PUT /konselor/bimbingan/1 (submit form)
3. Redirect ke /konselor/bimbingan (daftar)
```

### Hapus Bimbingan
```
1. DELETE /konselor/bimbingan/1 (submit delete)
2. Redirect ke /konselor/bimbingan (daftar)
```

### Export Laporan
```
1. GET /konselor/laporan (tampilkan filter)
2. GET /konselor/laporan/export-excel?bulan=2025-11 (download)
```

---

## 📞 Support

Jika ada masalah dengan routes:
1. Cek `routes/web.php`
2. Jalankan `php artisan route:cache`
3. Clear cache: `php artisan cache:clear`
4. Verifikasi middleware
5. Cek user role di database

---

**Last Updated**: 2025-11-20
