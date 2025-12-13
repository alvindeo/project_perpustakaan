# Library Management System - SMA Dian Nuswantoro

Sistem Manajemen Perpustakaan modern berbasis web untuk SMA Dian Nuswantoro dengan fitur OPAC, sirkulasi, dan pelaporan.

## 🚀 Fitur Utama

### Modul Anggota
- **OPAC (Online Public Access Catalog)**: Pencarian buku berdasarkan judul, pengarang, ISBN, dan kategori
- **Dashboard Profil**: Melihat status peminjaman, riwayat, dan denda
- **Booking Buku**: Memesan buku yang sedang dipinjam (maksimal 1 buku/anggota)
- **Informasi Perpustakaan**: Jam buka, peraturan, event literasi, dan berita

### Modul Administrator
- **Manajemen Koleksi**: CRUD buku dengan ISBN, sinopsis, cover, dan stok
- **Manajemen Anggota**: CRUD anggota (siswa/guru) dengan QR code
- **Sirkulasi**: Peminjaman dan pengembalian dengan scan QR/barcode
- **Laporan & Statistik**: Buku terlaris, keterlambatan, dan denda (export PDF)

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (optional, untuk asset compilation)

## 🛠️ Instalasi

### 1. Clone atau Download Project
```bash
cd c:\laragon\www\project_manpro
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Database
Buat database baru dengan nama `library_db` di MySQL

### 6. Jalankan Migrasi dan Seeder
```bash
php artisan migrate --seed
```

### 7. Buat Storage Link
```bash
php artisan storage:link
```

### 8. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 👥 Akun Demo

### Admin/Pustakawan
- Email: `admin@library.com`
- Password: `admin123`

### Anggota
- Email: `member@library.com`
- Password: `member123`

## 📚 Struktur Database

- **users**: Autentikasi dan profil pengguna (admin, librarian, member)
- **categories**: Kategori buku
- **books**: Katalog buku dengan ISBN, cover, stok
- **members**: Data anggota perpustakaan
- **transactions**: Transaksi peminjaman dan pengembalian
- **bookings**: Reservasi buku
- **fines**: Denda keterlambatan
- **library_infos**: Pengaturan perpustakaan
- **events**: Event literasi dan berita

## 🎨 Teknologi

- **Framework**: Laravel 12
- **Database**: MySQL dengan Eloquent ORM
- **Frontend**: Blade Templates + Modern CSS
- **Authentication**: Laravel built-in
- **QR Code**: SimpleSoftwareIO/simple-qrcode
- **PDF Export**: Barryvdh/laravel-dompdf
- **Excel Export**: Maatwebsite/excel

## 📖 Panduan Penggunaan

### Untuk Anggota
1. Login dengan akun member
2. Cari buku di katalog OPAC
3. Lihat detail buku dan ketersediaan
4. Booking buku jika tidak tersedia
5. Pantau status peminjaman di dashboard

### Untuk Admin/Pustakawan
1. Login dengan akun admin
2. Kelola koleksi buku (tambah/edit/hapus)
3. Kelola data anggota
4. Proses peminjaman dengan scan QR code
5. Proses pengembalian dan hitung denda otomatis
6. Lihat laporan dan statistik

## 🔧 Konfigurasi Perpustakaan

Pengaturan dapat diubah di tabel `library_infos`:
- `max_borrow_days`: Lama peminjaman (default: 7 hari)
- `max_books_per_member`: Maksimal buku per anggota (default: 3)
- `fine_per_day`: Denda per hari (default: Rp 1.000)

## 📝 Fitur Keamanan

- Password hashing dengan bcrypt
- Role-based access control (Admin, Librarian, Member)
- CSRF protection
- Input validation
- Session management

## 🎯 Roadmap

- [ ] Notifikasi email untuk jatuh tempo
- [ ] Integrasi dengan sistem sekolah
- [ ] Mobile app
- [ ] E-book reader
- [ ] Statistik lebih detail

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi:
- Email: perpustakaan@dinus.sch.id
- Telp: (024) 3517261

## 📄 License

Copyright © 2024 SMA Dian Nuswantoro. All rights reserved.
