<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'status',
        'keterangan',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
} 