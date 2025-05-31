# PerpusExpress

## Nama & NIM
[Nama Lengkap] - [NIM]

## Deskripsi Aplikasi
PerpusExpress adalah aplikasi manajemen perpustakaan digital yang dibangun menggunakan framework Laravel. Aplikasi ini menyediakan solusi komprehensif untuk mengelola perpustakaan dengan antarmuka yang intuitif dan fitur-fitur yang lengkap.

### Penjelasan Code
Aplikasi ini dibangun menggunakan:
- **Backend**: Laravel 10.x dengan PHP 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, jQuery, DataTables
- **Authentication**: Laravel Breeze

### User Interface
Aplikasi memiliki beberapa halaman utama:
1. **Dashboard**
   - Tampilan utama dengan statistik perpustakaan
   - Grafik peminjaman dan pengembalian
   - Notifikasi peminjaman aktif

2. **Manajemen Buku**
   - Daftar buku dengan fitur pencarian dan filter
   - Form tambah/edit buku
   - Detail buku dengan status ketersediaan

3. **Manajemen Peminjaman**
   - Daftar peminjaman aktif
   - Form peminjaman dan pengembalian
   - Riwayat peminjaman

4. **Manajemen Pengguna**
   - Daftar pengguna dengan role berbeda
   - Form tambah/edit pengguna
   - Profil pengguna

## Cara Instalasi Aplikasi

### 1. Persyaratan Sistem
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Web Server (Apache/Nginx)

### 2. Clone Repository
```bash
git clone https://github.com/username/PerpusExpress.git
cd PerpusExpress
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database
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

### 6. Migrasi Database
```bash
php artisan migrate
```

### 7. Seeding Data
```bash
php artisan db:seed
```

### 8. Compile Assets
```bash
npm run dev
```

### 9. Jalankan Server
```bash
php artisan serve
```

## Kredensial Default

### Admin
- Email: admin@perpus.com
- Password: password

### Petugas
- Email: petugas@perpus.com
- Password: password

## Fitur Utama
1. Manajemen Buku
   - CRUD buku
   - Kategorisasi
   - Pencarian

2. Manajemen Peminjaman
   - Proses peminjaman
   - Pengembalian
   - Perhitungan denda

3. Manajemen Pengguna
   - Multi-level user
   - Profil pengguna
   - Riwayat aktivitas

4. Laporan
   - Laporan peminjaman
   - Statistik perpustakaan
   - Laporan denda

## Struktur Database
Aplikasi menggunakan beberapa tabel utama:
- users
- books
- categories
- borrowings
- fines
- book_status

## Kontribusi
Kontribusi selalu diterima! Berikut cara untuk berkontribusi:
1. Fork repository
2. Buat branch baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 📱 Fitur Keamanan

- Autentikasi multi-level
- Password hashing
- CSRF protection
- XSS protection
- SQL injection prevention
- Session management

## 👨‍💻 Pengembang

- [Nama Pengembang](https://github.com/username)

## 🙏 Ucapan Terima Kasih

Terima kasih kepada semua kontributor yang telah membantu dalam pengembangan PerpusExpress.

---

⭐ Star repository ini jika Anda menyukainya!
