<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'event_id',
        'layout_tempat_id',
        'total',
        'status',
        'token',
        'tenggat_pembayaran'
    ];

    protected $casts = [
        'tenggat_pembayaran' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function layoutTempat()
    {
        return $this->belongsTo(LayoutLokasi::class, 'layout_tempat_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
