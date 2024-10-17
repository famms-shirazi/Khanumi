<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalalian;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['unique_id'];

    protected $table = 'colors_tbl';

    // relation methods
    public function product():BelongsTo
    {
        return $this->BelongsTo(Product::class);
    }

    // set and get methods

    // protected function createdAt(){
    //     return Attribute::make(
    //         get:fn($value) => Jalalian::forge($value)->format('datetime'),
    //     );
    // }

    protected function getCreatedAtAttribute($value){
        return Jalalian::forge($value)->format('%Y-%m-%d H:i:s');
    }

    protected function getUpdatedAtAttribute($value){
        return Jalalian::forge($value)->format('%Y-%m-%d H:i:s');
    }
}
