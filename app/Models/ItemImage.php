<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'item_id'];

    protected $appends = ['src'];

    public function getSrcAttribute(){
        return $this->image ? asset("storage/{$this->image}") : asset("storage/default/no_image.png");
    }

}
