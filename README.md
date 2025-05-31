# PerpusExpress

## Deskripsi Proyek

PerpusExpress adalah aplikasi manajemen perpustakaan sederhana yang dibangun menggunakan framework Laravel. Aplikasi ini memungkinkan pengguna (user) untuk melihat daftar buku dan riwayat peminjaman mereka, serta memungkinkan administrator (admin) untuk mengelola data buku, peminjaman, dan kategori.

## Fitur Utama

- Manajemen Buku (Tambah, Edit, Hapus)
- Daftar Peminjaman (untuk User dan Admin)
- Manajemen Kategori (untuk Admin)
- Autentikasi Pengguna (Login, Register)
- Profil Pengguna

## Persyaratan (Prerequisites)

Pastikan Anda telah menginstal perangkat lunak berikut:

- Web Server (seperti Apache atau Nginx)
- PHP (versi 8.1 atau lebih tinggi, sesuai dengan persyaratan Laravel 10/11)
- Composer
- Database Server (seperti MySQL atau MariaDB)
- Node.js dan npm/Yarn (untuk mengkompilasi aset frontend)

Jika Anda menggunakan XAMPP, sebagian besar persyaratan ini sudah terpenuhi.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan mengatur proyek:

1.  **Clone Repository:**

    ```bash
    git clone <URL_REPOSITORY_ANDA>
    cd PerpusExpress
    ```

2.  **Instal Dependencies PHP:**

    ```bash
    composer install
    ```

3.  **Salin File Environment:**

    ```bash
    cp .env.example .env
    ```

4.  **Generate Application Key:**

    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi Database:**

    Edit file `.env` dan atur kredensial database Anda:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=username_database_anda
    DB_PASSWORD=password_database_anda
    ```

6.  **Jalankan Migrasi Database:**

    Ini akan membuat tabel-tabel yang dibutuhkan di database Anda.

    ```bash
    php artisan migrate
    ```

7.  **Instal Dependencies Frontend (jika ada perubahan pada aset frontend):**

    ```bash
    npm install
    # atau yarn install
    ```

8.  **Compile Aset Frontend:**

    ```bash
    npm run dev
    # atau npm run build (untuk produksi)
    ```

## Cara Menjalankan Aplikasi

Anda dapat menjalankan aplikasi menggunakan server pengembangan bawaan Laravel:

```bash
php artisan serve
```

Atau, jika Anda menggunakan XAMPP/Web Server lainnya, letakkan folder proyek ini di direktori `htdocs` (atau root dokumen server Anda) dan akses melalui browser.

## Teknologi yang Digunakan

-   Laravel
-   PHP
-   MySQL (atau database kompatibel)
-   Bootstrap
-   Composer
-   npm/Yarn

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan buat *fork* repositori dan kirimkan *pull request*.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT.

---

*Dibuat dengan cinta oleh [Nama Anda/Tim Anda]*
