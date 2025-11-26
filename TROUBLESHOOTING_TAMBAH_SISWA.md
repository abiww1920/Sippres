# TROUBLESHOOTING TAMBAH SISWA

## Masalah yang Dilaporkan
- Form tambah siswa di admin tampil berhasil
- Data tidak tersimpan ke database
- Tidak ada error yang terlihat

## Langkah Diagnosa

### 1. Jalankan Script Diagnosa
```bash
diagnose_siswa_issue.bat
```

### 2. Cek Manual Database
```bash
debug_tambah_siswa.php
```

### 3. Test Form Simulation
```bash
test_form_siswa.php
```

### 4. Cek Log Laravel
```bash
check_logs.bat
```

## Kemungkinan Penyebab & Solusi

### A. Masalah Database Connection
**Gejala**: Error connection atau timeout
**Solusi**:
```bash
# Cek koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
```

### B. Masalah Validation
**Gejala**: Form submit tapi redirect kembali
**Solusi**: Cek validation rules di controller
- NIS harus unique
- Kelas_id harus exists di tabel kelas
- Field required harus diisi

### C. Masalah CSRF Token
**Gejala**: 419 error atau form tidak submit
**Solusi**: Pastikan `@csrf` ada di form

### D. Masalah JavaScript
**Gejala**: Form tidak submit sama sekali
**Solusi**: Buka browser console, cek error JavaScript

### E. Masalah Permission
**Gejala**: Error saat upload foto
**Solusi**:
```bash
chmod 755 public/uploads/siswa/
```

### F. Masalah Model Fillable
**Gejala**: Data tidak tersimpan meski tidak error
**Solusi**: Cek fillable array di model Siswa

## Perbaikan yang Sudah Dilakukan

### 1. Controller SiswaController
- ✅ Menambahkan logging untuk debug
- ✅ Menambahkan try-catch error handling
- ✅ Menggunakan `only()` untuk filter data
- ✅ Set default status jika tidak ada

### 2. Model Siswa
- ✅ Memastikan semua field ada di fillable array

### 3. View admin/siswa/index.blade.php
- ✅ Menambahkan console logging untuk debug
- ✅ Form validation error handling

## Cara Testing

### 1. Test via Browser
1. Login sebagai admin
2. Buka `/admin/siswa`
3. Klik "Tambah Siswa"
4. Isi form dengan data valid
5. Buka browser console (F12)
6. Submit form
7. Cek console untuk log

### 2. Test via Script
```bash
php test_form_siswa.php
```

### 3. Cek Database Langsung
```sql
SELECT COUNT(*) FROM siswa;
-- Submit form
SELECT COUNT(*) FROM siswa;
-- Harus bertambah 1
```

## Debug Steps

### Step 1: Cek Form Action
```html
<!-- Pastikan action URL benar -->
<form action="{{ route('admin.siswa.store') }}" method="POST">
```

### Step 2: Cek Route
```bash
php artisan route:list | grep siswa
```

### Step 3: Cek Controller Method
```php
// Pastikan method store ada dan accessible
public function store(Request $request) { ... }
```

### Step 4: Cek Database
```bash
php artisan tinker
>>> App\Models\Siswa::count()
>>> // Submit form
>>> App\Models\Siswa::count() // Should increase
```

## Log Locations

### Laravel Log
```
storage/logs/laravel.log
```

### Browser Console
```
F12 > Console tab
```

### Network Tab
```
F12 > Network tab > Submit form > Check response
```

## Common Issues & Solutions

### Issue 1: "Route not found"
**Solution**: Check routes/web.php for admin.siswa.store route

### Issue 2: "CSRF token mismatch"
**Solution**: Ensure @csrf is in form and session is working

### Issue 3: "Validation failed"
**Solution**: Check validation rules match form fields

### Issue 4: "Column not found"
**Solution**: Check migration and model fillable array

### Issue 5: "Permission denied"
**Solution**: Check file/folder permissions for uploads

## Quick Fix Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Check permissions
chmod -R 755 storage/
chmod -R 755 public/uploads/

# Run migrations
php artisan migrate

# Check database
php artisan tinker
```

## Contact Points for Further Debug

1. Check browser network tab for HTTP status codes
2. Check Laravel log for detailed error messages  
3. Use `dd()` in controller to debug step by step
4. Test with minimal data first (only required fields)
5. Check if other CRUD operations work (edit, delete)

## Final Verification

After fixing, verify:
- [ ] Form submits without JavaScript errors
- [ ] Data appears in database
- [ ] Success message shows
- [ ] Redirect works properly
- [ ] File upload works (if applicable)