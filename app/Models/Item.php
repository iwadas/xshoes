<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PDO;

class Item extends Model
{
    use HasFactory;

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function images(){
        return $this->hasMany(ItemImage::class);
    }

    public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    public function colors(){
        return $this->belongsToMany(Color::class);
    }

    public function sizes(){
        return $this->belongsToMany(Size::class)->withPivot('amount');
    }

    public function available_sizes(){
        return $this->belongsToMany(Size::class)->wherePivot('amount', '>', 1);
    }

    public function scopeCategoryFilter($query, int $categoryId){
        return $query->when($categoryId ?? false,
            fn($query, $value)=>$query->whereHas('categories', fn($query)=>$query->where('categories.id', $value))
        );
    }

    public function scopeFilter($query, array $filters, string $except = null){
        return 
            $query
                ->when(($filters['brands'] ?? false) && $except != 'brands',
                    function ($query) use ($filters){
                        return $query->whereHas('brands', fn($query)=>$query->whereIn('brands.id', $filters['brands']));
                    }
                )
                ->when(($filters['colors'] ?? false) && $except != 'colors',
                    function ($query) use ($filters){
                        return $query->whereHas('colors', fn($query)=>$query->whereIn('colors.id', $filters['colors']));
                    }
                )
                ->when(($filters['sizes'] ?? false) && $except != 'sizes',
                    function ($query) use ($filters){
                        return $query->whereHas('available_sizes', fn($query)=>$query->whereIn('sizes.id', $filters['sizes']));
                    }
                )


                // ->when($filters['colors'] && ($except != 'sizes') ?? false,
                //     fn($query, $value)=>$query->whereHas('colors', fn($query)=>$query->where('colors.id', $value))
                // )
            ;
    }

}
