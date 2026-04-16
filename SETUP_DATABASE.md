# Setup Database Kolaborasi Relawan

## Untuk Teman (Penerima Project)

### Cara Import Database

1. **Buka MySQL Command Line atau phpMyAdmin**

2. **Buat database baru:**
```sql
CREATE DATABASE kolaborasi_relawan;
```

3. **Import file SQL:**

**Opsi A - Command Line:**
```bash
mysql -u root -p kolaborasi_relawan < kolaborasi_relawan.sql
```
Tekan Enter, lalu masukkan password MySQL (kosong untuk XAMPP default)

**Opsi B - phpMyAdmin:**
- Buka `http://localhost/phpmyadmin`
- Pilih database `kolaborasi_relawan`
- Tab "Import"
- Upload file `kolaborasi_relawan.sql`
- Click "Go"

4. **Verifikasi:**
```sql
USE kolaborasi_relawan;
SHOW TABLES;
```

## Untuk Developer Lokal

- Database sudah ada di folder project
- Edit `config.php` jika perlu ubah username/password MySQL
- Default: `root` (password kosong)

## Update Database

Setiap kali ada perubahan struktur table, jalankan:
```bash
php export_database.php
```
Lalu commit file `kolaborasi_relawan.sql` ke git.
