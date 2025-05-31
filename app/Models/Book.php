<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'isbn',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'category_id',
        'jumlah_halaman',
        'deskripsi',
        'stok',
        'lokasi_rak',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function bookStatus()
    {
        return $this->hasMany(BookStatus::class);
    }
} 