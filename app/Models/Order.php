<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'payment_id', 'cart_id', 'shipping_id', 'address_id', 'tracking_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function payment(){
        return $this->belongsTo(Payment::class);
    }

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    
    public function shipping(){
        return $this->belongsTo(Shipping::class);
    }
    
    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function tracking(){
        return $this->belongsTo(Tracking::class);
    }

}
