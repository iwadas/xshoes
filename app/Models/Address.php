<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'post_code', 'address', 'name', 'surname', 'city', 'phone_number', 'is_main'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
