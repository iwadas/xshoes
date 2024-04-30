<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'promo_code_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cart_items(){
        return $this->hasMany(CartItem::class);
    }

    public function promo_code(){
        return $this->belongsTo(PromoCode::class);
    }

}
