<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{
    use HasFactory;

    protected $table = "discounts_tbl";

    protected $fillable = [
        'amount',
    ];

    public function Products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
