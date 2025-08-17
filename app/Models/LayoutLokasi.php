<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LayoutLokasi extends Model
{
    use HasFactory;

    protected $table = 'layout_lokasi';

    protected $fillable = [
        'event_id',
        'section',
        'row',
        'number',
        'harga',
        'status',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function booking(): HasOne
    {
        return $this->hasMany(Booking::class, 'layout_tempat_id');
    }
}
