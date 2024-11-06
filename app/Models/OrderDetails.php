<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetails extends Model
{
    use HasFactory;

    protected $table = "order_details_tbl";
    public function brands(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
