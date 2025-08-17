<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'total_pembayaran',
        'status',
        'faktur_midtrans',
        'midtrans_token',
        'metode_pembayaran',
        'waktu_settlement'
    ];

    protected $casts = [
        'waktu_settlement' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
