<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LayoutLokasi extends Model
{
    use HasFactory;

    protected $table = 'layout_lokasi';

    protected $fillable = [
        'event_id',
        'jenis',
        'layout_tenant',
        'kapasitas_total',
    ];

    protected $casts = [
        'layout_tenant' => 'array'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
