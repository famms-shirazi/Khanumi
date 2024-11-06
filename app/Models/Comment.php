<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments_tbl";
    protected $fillable = [
        'text',
        'image',
        'commentable_id',
        'commentable_type',
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
