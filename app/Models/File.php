<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;

    protected $fillable =[
        'url',
        'fileable_id',
        'fileable_type'
    ];
    public function user():HasMany{
        return $this->hasMany(User::class);
    }
    public function fileable():MorphTo{
        return $this->morphTo();
    }
}
