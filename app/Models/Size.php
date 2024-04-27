<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    public function items(){
        return $this->belongsToMany(Item::class)->withPivot('amount');
    }

    public function available_items(){
        return $this->belongsToMany(Item::class)->wherePivot('amount', '>', 1);
    }

}
