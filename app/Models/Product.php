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

        protected $table  = "products_tbl";

        protected $fillable = ['persian_title', 'english_title', 'slug', 'product_size', 'price', 'product_introduction_text', 'consumption_guide_text', 'inventory', 'special_offer', 'brand_id'];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

//    public function specialOffer(): BelongsTo
//    {
//        return $this->belongsTo(::class);
//    }
    public function shoppingCarts(): BelongsToMany
    {
        return $this->belongsToMany(ShoppingCart::class,'product_shopping_cart_tbl');
    }
}
