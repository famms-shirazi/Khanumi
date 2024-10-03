<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
            'status_id',
            'unique_id',
            'user_id'
    ];

    public function orderDetail():HasOne{
        return $this->hasOne(OrderDetails::class);
    }
    public function transaction():HasOne{
        return $this->hasOne(Transaction::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
