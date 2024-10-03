<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'province',
        'city',
        'postal_code',
        'receive_status'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
