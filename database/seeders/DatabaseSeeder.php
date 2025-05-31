<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@perpus.com',
            'role' => 'admin',
        ]);

        // Create categories
        $categories = [
            ['nama_kategori' => 'Novel', 'deskripsi' => 'Buku fiksi yang menceritakan kisah panjang'],
            ['nama_kategori' => 'Pendidikan', 'deskripsi' => 'Buku-buku pelajaran dan referensi pendidikan'],
            ['nama_kategori' => 'Teknologi', 'deskripsi' => 'Buku tentang teknologi dan komputer'],
            ['nama_kategori' => 'Sejarah', 'deskripsi' => 'Buku tentang sejarah dan peristiwa masa lalu'],
            ['nama_kategori' => 'Biografi', 'deskripsi' => 'Buku tentang riwayat hidup seseorang'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
