# 📋 Catatan Setup — SIPCF (Sistem Informasi Pelayanan Carrera Futsal)

Panduan ini ditujukan untuk **orang yang pertama kali mengunduh** project ini.

---

## 📌 Prasyarat

Pastikan sudah terinstall di komputer Anda:

| Software | Versi Minimum | Keterangan |
|----------|---------------|------------|
| **Laragon** | 6.x | Sudah include Apache, MySQL, PHP |
| **PHP** | 8.1+ | Bawaan Laragon |
| **MySQL** | 8.0+ | Bawaan Laragon |
| **Composer** | 2.x | Bawaan Laragon |
| **Git** | 2.x | Untuk clone repository |

---

## 🚀 Langkah Instalasi

### 1. Clone Repository

Buka terminal di folder `C:\laragon\www\`, lalu jalankan:

```bash
git clone https://github.com/YusufAbd05/SIPCF.git
cd SIPCF
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

File `.env` sudah tersedia di root project. **Ubah nama database** sesuai kebutuhan:

```env
# Buka file .env, lalu sesuaikan bagian DATABASE:

database.default.hostname = localhost
database.default.database = db_sipcf    # <-- Ganti sesuai nama database Anda
database.default.username = root
database.default.password =             # <-- Kosong jika default Laragon
database.default.DBDriver = MySQLi
database.default.port = 3306
```

> ⚠️ **Penting:** Jika menggunakan Laragon dengan port default, `baseURL` juga perlu disesuaikan. Jika akses via `http://localhost/SIPCF/`, ubah menjadi:
> ```env
> app.baseURL = 'http://localhost/SIPCF/'
> ```

### 4. Buat Database

Buka **phpmyadmin** atau terminal MySQL, lalu buat database baru:

```sql
CREATE DATABASE db_carrera;
```

### 5. Jalankan Migration

Migration akan membuat semua tabel yang dibutuhkan secara otomatis:

```bash
php spark migrate
```

Tabel yang akan dibuat:
- `t_user` — Data pengguna (Admin & Membership)
- `t_lapang` — Data lapangan
- `t_lapang_tarif` — Tarif per lapangan
- `t_sewa_lapangan` — Data booking/sewa
- `t_pembayaran` — Data pembayaran

### 6. Buat User Admin Pertama

Karena belum ada seeder, jalankan query SQL berikut di **phpmyadmin** atau terminal MySQL untuk membuat akun admin:

```sql
USE db_carrera;

INSERT INTO t_user (nama, email, no_hp, password, role)
VALUES (
    'Administrator',
    'admin@sipcf.com',
    '081234567890',
    '$2y$10$ndpR1zqbUIwmVfW27jTNVuqBrsr3sVlIclB1O2wWBXrRxcV7spxC.',
    'Admin'
);
```

**Akun login yang dibuat:**

| Field | Nilai |
|-------|-------|
| Email | `admin@sipcf.com` |
| Password | `admin123` |
| Role | Admin |

> 💡 **Jika ingin generate password lain**, jalankan di terminal:
> ```bash
> php -r "echo password_hash('password_baru_anda', PASSWORD_DEFAULT);"
> ```
> Lalu ganti hash di query INSERT di atas.

### 7. Jalankan Aplikasi

Pastikan **Laragon sudah Start** (Apache & MySQL aktif), lalu akses:

```
http://localhost/SIPCF/
```

Untuk login ke halaman admin:

```
http://localhost/SIPCF/login
```

---

## 📂 Struktur Folder Penting

```
SIPCF/
├── app/
│   ├── Config/
│   │   └── Routes.php          ← Semua definisi route
│   ├── Controllers/
│   │   ├── AuthController.php  ← Login & Logout
│   │   ├── BookingController.php
│   │   ├── LapangController.php
│   │   ├── LaporanController.php
│   │   ├── TarifController.php
│   │   └── UserController.php
│   ├── Database/
│   │   └── Migrations/         ← File migration database
│   ├── Filters/
│   │   └── AuthFilter.php      ← Proteksi halaman admin
│   ├── Models/
│   │   ├── BookingModel.php
│   │   ├── LapangModel.php
│   │   ├── PembayaranModel.php
│   │   ├── TarifModel.php
│   │   └── UserModel.php
│   └── Views/
│       ├── admin/              ← Halaman admin (dashboard, booking, laporan, dll)
│       ├── template/admin/     ← Layout template (sidebar, header, footer)
│       └── ...                 ← Halaman publik (booking, membership)
├── public/
│   └── css/style.css           ← Semua stylesheet
└── .env                        ← Konfigurasi environment
```

---

## 🔑 Halaman yang Tersedia

### Halaman Publik (tanpa login)
| URL | Keterangan |
|-----|------------|
| `/` | Landing page |
| `/booking` | Formulir booking |
| `/membership` | Info membership |
| `/login` | Halaman login |

### Halaman Admin (perlu login)
| URL | Keterangan |
|-----|------------|
| `/admin` | Dashboard |
| `/admin/booking` | Kelola Booking |
| `/admin/lapang` | Kelola Lapangan |
| `/admin/tarif` | Kelola Tarif |
| `/admin/users` | Kelola User |
| `/admin/laporan` | Laporan Keuangan |

---

## ❗ Troubleshooting

| Masalah | Solusi |
|---------|--------|
| `Whoops! Page Not Found` | Pastikan `.env` → `app.baseURL` sudah benar |
| `Unable to connect to database` | Cek nama database di `.env`, pastikan MySQL Laragon sudah **Start** |
| `php spark migrate` error | Pastikan database sudah dibuat terlebih dahulu (`CREATE DATABASE db_sipcf`) |
| Halaman admin redirect ke login terus | Pastikan sudah INSERT user admin dan login dengan email & password yang benar |
| CSS / styling tidak muncul | Pastikan `app.baseURL` sesuai dengan URL akses (cek trailing slash) |
