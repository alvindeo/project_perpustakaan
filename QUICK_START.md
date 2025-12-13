# 🚀 Quick Start Guide - Library Management System

## Akses Aplikasi

**URL**: http://127.0.0.1:8000 (Server sudah berjalan)

## 🔑 Login Credentials

### Admin/Pustakawan
```
Email: admin@library.com
Password: admin123
```

### Anggota
```
Email: member@library.com
Password: member123
```

## 📚 Fitur Utama

### Untuk Anggota
1. **OPAC** - Cari buku di katalog
2. **Dashboard** - Lihat status peminjaman
3. **Booking** - Pesan buku yang dipinjam
4. **History** - Riwayat peminjaman

### Untuk Admin
1. **Dashboard** - Statistik perpustakaan
2. **Kelola Buku** - CRUD buku + QR code
3. **Kelola Anggota** - CRUD anggota + QR code
4. **Sirkulasi** - Peminjaman & pengembalian
5. **Laporan** - Export PDF

## 🎯 Testing Checklist

- [ ] Login sebagai admin
- [ ] Lihat dashboard admin
- [ ] Tambah buku baru
- [ ] Login sebagai member
- [ ] Cari buku di OPAC
- [ ] Lihat detail buku
- [ ] Proses peminjaman (admin)
- [ ] Proses pengembalian (admin)

## 📁 File Penting

- **Routes**: `routes/web.php`
- **Controllers**: `app/Http/Controllers/`
- **Models**: `app/Models/`
- **Views**: `resources/views/`
- **CSS**: `public/css/style.css`
- **Database**: Sudah di-migrate dan seed

## ⚙️ Konfigurasi

**Database**: library_db  
**Max Borrow Days**: 7 hari  
**Max Books**: 3 buku/anggota  
**Fine**: Rp 1.000/hari  

## 🎨 Teknologi

- Laravel 12
- MySQL
- Blade Templates
- Modern CSS (Gradients & Animations)
- QR Code Generation
- PDF Export

## ✅ Status: READY FOR USE

Semua fitur sudah diimplementasikan dan siap digunakan!
