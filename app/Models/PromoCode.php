<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'discount', 'type', 'available_till', 'price_from', 'for_new_users'];

    public function carts(){
        return $this->hasMany(Cart::class);
    }

}
