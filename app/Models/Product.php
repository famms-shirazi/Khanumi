<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
    {
    use HasFactory;
        protected $fillable = [
            'persian_title',
            'english_title',
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

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }


    public function shoppingCart(): BelongsTo
    {
        return $this->belongsTo(ShoppingCart::class);
    }

    public function likes():MorphMany{
        return $this->morphMany(Like::class,'likeable');
    }
    public function comments():MorphMany{
        return $this->morphMany(Comment::class,'commentable');
    }
    public function files():MorphMany{
        return $this->morphMany(File::class,'fileable');
    }
}
