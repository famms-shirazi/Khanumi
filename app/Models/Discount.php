<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'expiration_date',
        'expiration_time'
    ];

    public function Products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
