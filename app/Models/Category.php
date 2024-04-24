<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'icon', 'parent_id'];
    protected $appends = ['src'];

    public function items(){
        return $this->belongsToMany(Item::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getSrcAttribute(){
        return $this->image ? asset("storage/{$this->image}") : null;
    }

}
