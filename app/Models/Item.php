<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function images(){
        return $this->hasMany(ItemImage::class);
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

}
