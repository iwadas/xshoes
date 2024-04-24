<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'color'];
    protected $appends = ['src'];

    public function getSrcAttribute(){
        return $this->image ? asset("storage/{$this->image}") : null;
    }

}
