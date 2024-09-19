<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'Persian_title',
        'English_title',
    ];

    public function brands(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}