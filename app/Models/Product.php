<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    function category_info(){
        return $this->belongsTo(Category::class,'category_id');
    }

    function subcategory_info(){
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

    function unit_info(){
        return $this->belongsTo(Unit::class,'unit_id');
    }
}
