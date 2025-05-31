<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'jumlah_denda',
        'status_pembayaran',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'date',
        'jumlah_denda' => 'decimal:2',
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }
} 