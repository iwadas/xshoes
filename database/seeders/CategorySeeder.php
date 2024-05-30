<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryMen = Category::create([
            'name' => 'men',
            'icon' => 'fa-person',
            'image' => 'categories/men.jpg'
        ]);

        $categoryWomen = Category::create([
            'name' => 'women',
            'icon' => 'fa-person-dress',
            'image' => 'categories/women.webp'
        ]);

        $categoryKid = Category::create([
            'name' => 'kid',
            'icon' => 'fa-child',
            'image' => 'categories/kid.jpg'
        ]);

        $menShoes = $this->createSubCategory($categoryMen->id, 'shoes', 'fa-shoe-prints');
        $menShoesSneakers = $this->createSubCategory($menShoes->id, 'sneakers', 'fa-person-running');
        $menShoesFlipFlops = $this->createSubCategory($menShoes->id, 'flip flops', 'fa-umbrella-beach');
        $menShoesSport = $this->createSubCategory($menShoes->id, 'sport', 'fa-futbol');
        
        $menClothes = $this->createSubCategory($categoryMen->id, 'clothes', 'fa-shirt');
        $menClothesHats = $this->createSubCategory($menClothes->id, 'hats', 'fa-hat-cowboy');
        $menClothesTops = $this->createSubCategory($menClothes->id, 'tops', 'fa-shirt');
        $menClothingTrousers = $this->createSubCategory($menClothes->id, 'trousers', 'fa-socks');
        
        $womenShoes = $this->createSubCategory($categoryWomen->id, 'shoes', 'fa-shoe-prints');
        $womenShoesSneakers = $this->createSubCategory($womenShoes->id, 'sneakers', 'fa-person-running');
        $womenShoesFlipFlops = $this->createSubCategory($womenShoes->id, 'flip flops', 'fa-umbrella-beach');
        $womenShoesSport = $this->createSubCategory($womenShoes->id, 'sport', 'fa-futbol');
        
        $womenClothes = $this->createSubCategory($categoryWomen->id, 'clothes', 'fa-shirt');
        $womenClothesHats = $this->createSubCategory($womenClothes->id, 'hats', 'fa-hat-cowboy');
        $womenClothesTops = $this->createSubCategory($womenClothes->id, 'tops', 'fa-shirt');
        $womenClothingDresses = $this->createSubCategory($womenClothes->id, 'dresses', 'fa-person-dress');
   
        $kidShoes = $this->createSubCategory($categoryKid->id, 'shoes', 'fa-shoe-prints');
        $kidShoesSneakers = $this->createSubCategory($kidShoes->id, 'sneakers', 'fa-person-running');
        $kidShoesFlipFlops = $this->createSubCategory($kidShoes->id, 'flip flops', 'fa-umbrella-beach');
        $kidShoesSport = $this->createSubCategory($kidShoes->id, 'sport', 'fa-futbol');
        
        $kidClothes = $this->createSubCategory($categoryKid->id, 'clothes', 'fa-shirt');
        $kidClothesHats = $this->createSubCategory($kidClothes->id, 'hats', 'fa-hat-cowboy');
        $kidClothesTops = $this->createSubCategory($kidClothes->id, 'tops', 'fa-shirt');
        $kidClothingTrousers = $this->createSubCategory($kidClothes->id, 'trousers', 'fa-socks');
        $kidClothingDresses = $this->createSubCategory($kidClothes->id, 'dresses', 'fa-person-dress');
    }

    private function createSubCategory(int $parentId, string $name, string $icon, string $image = null){
        $newCategory = Category::create([
            'name' => $name,
            'icon' => $icon,
            'image' => $image,
            'parent_id'=> $parentId
        ]);

        return $newCategory;
    }

}
