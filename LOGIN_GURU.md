# Login Guru

## Cara Login Guru

Guru dapat login menggunakan NIP sebagai username dan NIP sebagai password (default).

## Data Login Guru yang Tersedia:

### Guru Existing:
1. **Wali Kelas**
   - Username: `walikelas`
   - Password: `walikelas123`
   - Email: walikelas@smk.com

2. **Guru**
   - Username: `guru`
   - Password: `guru123`
   - Email: guru@smk.com

3. **Konselor**
   - Username: `konselor`
   - Password: `konselor123`
   - Email: konselor@smk.com

4. **Kepala Sekolah**
   - Username: `kepsek`
   - Password: `kepsek123`
   - Email: kepsek@smk.com

### Guru Baru (Login dengan NIP):
1. **Ahmad Fauzi, S.Pd**
   - Username: `198501012010011001`
   - Password: `198501012010011001`
   - Email: 198501012010011001@guru.smk.com
   - Bidang Studi: Fisika

2. **Siti Nurhaliza, S.Kom**
   - Username: `198702152011012002`
   - Password: `198702152011012002`
   - Email: 198702152011012002@guru.smk.com
   - Bidang Studi: Pemrograman

3. **Budi Santoso, S.Pd**
   - Username: `198903202012011003`
   - Password: `198903202012011003`
   - Email: 198903202012011003@guru.smk.com
   - Bidang Studi: Bahasa Inggris

## Fitur yang Dapat Diakses Guru:
- Dashboard Guru
- Input Pelanggaran Siswa
- Lihat Riwayat Pelanggaran yang Dicatat
- Kelola Data Pelanggaran

## Sistem Login:
- Guru login menggunakan email/username dan password
- Setelah login, guru akan diarahkan ke `/guru/dashboard`
- Sistem akan mengecek `guru_id` pada user untuk menentukan data guru yang terkait

## Login Wali Kelas (Guru dengan Peran Ganda):

### Ahmad Fauzi, S.Pd (Guru + Wali Kelas XI RPL 1)
**Sebagai Guru:**
- Username: `198501012010011001`
- Password: `198501012010011001`
- Redirect: `/guru/dashboard`

**Sebagai Wali Kelas:**
- Username: `198501012010011001_wali`
- Password: `198501012010011001`
- Redirect: `/walikelas/dashboard`

### Siti Nurhaliza, S.Kom (Guru + Wali Kelas X TKJ 1)
**Sebagai Guru:**
- Username: `198702152011012002`
- Password: `198702152011012002`
- Redirect: `/guru/dashboard`

**Sebagai Wali Kelas:**
- Username: `198702152011012002_wali`
- Password: `198702152011012002`
- Redirect: `/walikelas/dashboard`

## Kelas yang Tersedia:
1. **XII RPL 1** - Wali Kelas: Wali Kelas (existing)
2. **XI RPL 1** - Wali Kelas: Ahmad Fauzi, S.Pd
3. **X TKJ 1** - Wali Kelas: Siti Nurhaliza, S.Kom