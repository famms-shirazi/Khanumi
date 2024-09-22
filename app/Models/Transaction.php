<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'type_id',
        'transaction_unique_id'
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
