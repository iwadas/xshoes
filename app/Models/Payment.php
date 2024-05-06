<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'key', 'price', 'payment_source', 'by'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }    

}
