@# ✅ PERBAIKAN UPLOAD FOTO BUKTI - SELESAI!

## ❌ MASALAH:
Foto bukti tidak tersedia karena **controller tidak handle upload file**!

## ✅ SOLUSI:

### 1. Update Controller Store
```php
// Tambah validation
'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'

// Handle upload
if ($request->hasFile('foto_bukti')) {
    $file = $request->file('foto_bukti');
    $fotoBukti = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('uploads/pelanggaran'), $fotoBukti);
}

// Simpan ke database
'foto_bukti' => $fotoBukti
```

### 2. Update Controller Update
```php
// Validation (nullable untuk edit)
'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'

// Handle upload + hapus foto lama
if ($request->hasFile('foto_bukti')) {
    // Hapus foto lama
    if ($pelanggaran->foto_bukti) {
        unlink(public_path('uploads/pelanggaran/' . $pelanggaran->foto_bukti));
    }
    // Upload foto baru
    ...
}
```

### 3. Folder Upload
✅ `public/uploads/pelanggaran/` sudah dibuat

---

## 🎯 HASIL:
✅ Foto bukti sekarang ter-upload dengan benar!
✅ Foto tersimpan di: `public/uploads/pelanggaran/`
✅ Nama file: `timestamp_namafile.jpg`

**Status:** FIXED! 🎉
