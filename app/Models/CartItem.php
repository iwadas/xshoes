<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'cart_id', 'size_id', 'amount'];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

}
