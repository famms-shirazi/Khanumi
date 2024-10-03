<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'commentable_id',
        'commentable_type'
    ];

    public function commentable():MorphTo
    {
        return $this->morphTo();
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
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
