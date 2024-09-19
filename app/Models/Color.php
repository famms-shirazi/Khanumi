<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['unique_id'];

    public function product():BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }
}
