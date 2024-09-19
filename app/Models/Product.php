<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
    {
    use HasFactory;
        protected $fillable = [
            'Persian_title',
            'English_title',
            'product_size',
            'price',
            'product_introduction_text',
            'consumption_guide_text'
    ];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function shoppingCarts(): BelongsToMany
    {
        return $this->belongsToMany(ShoppingCart::class);
    }
}
