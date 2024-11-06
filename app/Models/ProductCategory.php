<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table  = "products_categories_tbl";

    protected $fillable = [
        'title',
        'parent_id'
    ];

    public function children(){
        return $this->hasMany(ProductCategory::class,'parent_id');
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id');
    }
}
