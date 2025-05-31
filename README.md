Berikut versi README yang sudah saya rapikan dan format dengan markdown agar lebih jelas dan terstruktur:

---

# PerpusExpress

## Nama & NIM

**Halim Elsa Putra** - 2308107010062

---

## Deskripsi Website

PerpusExpress adalah website manajemen perpustakaan digital yang dibangun menggunakan framework Laravel. Website ini menyediakan solusi komprehensif untuk mengelola perpustakaan dengan antarmuka yang intuitif dan fitur lengkap.

---

## Teknologi yang Digunakan

* **Backend:** Laravel 12.0 (PHP 8.2.12)
* **Database:** MySQL
* **Frontend:** Bootstrap, Tailwind CSS
* **Authentication:** Laravel Breeze

---

## User Interface

Aplikasi memiliki beberapa halaman utama sebagai berikut:

1. **Halaman Autentikasi**

   * Login
   * Register
   * Forgot Password
   * Reset Password

2. **Dashboard**

   * Statistik perpustakaan
   * Grafik peminjaman
   * Notifikasi terbaru
   * Quick actions

3. **Manajemen Buku (Admin)**

   * Daftar buku
   * Tambah, edit, hapus buku
   * Detail buku
   * Pencarian dan filter buku

4. **Manajemen Kategori (Admin)**

   * Daftar kategori
   * Tambah, edit, hapus kategori

5. **Manajemen Peminjaman**

   * Daftar peminjaman aktif
   * Form peminjaman baru
   * Form pengembalian
   * Riwayat peminjaman
   * Status peminjaman

6. **Manajemen Pengguna**

   * Daftar pengguna
   * Tambah pengguna baru
   * Edit profil
   * Ganti password
   * Manajemen role

7. **Halaman User**

   * Katalog buku
   * Pencarian buku
   * Riwayat peminjaman
   * Daftar denda
   * Reservasi buku

8. **Laporan (Admin)**

   * Laporan peminjaman
   * Laporan denda
   * Statistik perpustakaan
   * Export data

9. **Profil Pengguna**

   * Informasi pribadi
   * Riwayat aktivitas
   * Pengaturan akun

10. **Notifikasi**

    * Notifikasi peminjaman
    * Notifikasi pengembalian
    * Notifikasi denda
    * Notifikasi sistem

---

## Cara Instalasi Aplikasi

### 1. Clone Repository

```bash
git clone https://github.com/username/PerpusExpress.git
cd PerpusExpress
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

1. Buat database baru di MySQL
2. Sesuaikan konfigurasi di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpus_express
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi Database

```bash
php artisan migrate
```

### 6. Seeding Data

```bash
php artisan db:seed
```

### 7. Compile Assets

```bash
npm run dev
```

### 8. Jalankan Server

```bash
php artisan serve
```

---

## Kredensial Default

### Admin

* Email: admin@perpus.com
* Password: password

---

## Fitur Utama

1. **Manajemen Buku**

   * CRUD buku
   * Kategorisasi
   * Pencarian

2. **Manajemen Peminjaman**

   * Proses peminjaman
   * Pengembalian
   * Perhitungan denda

3. **Manajemen Pengguna**

   * Profil pengguna
   * Riwayat aktivitas
