<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $sizes = [
        'shoes' => [
            'men' => ['40', '41', '42', '43', '44', '45', '46', '47']
        ],
        'clothes' => [
            'men' => ['XS', 'S', 'M', 'L', 'Xl', '2XL']
        ]
    ];
  
    private $amount = [
        'super_low' => 5,
        'low' => 10,
        'medium' => 20,
        'high' => 30,
        'super_high' => 50,
    ];


    public function run(): void
    {
        $menShoesSneakersCategory = Category::find(5);
        $pathMenSneakers = 'men/shoes/sneakers/';
        $this->appendCategoriesAndImagesSizes($menShoesSneakersCategory, 'Travis Fragment', ["Jordan", "Nike", "Travis Scott"], 1000, $this->getPaths($pathMenSneakers, 'fragment/', 2, '.jpg'), ['blue', 'black', 'white'], 'shoes', 'men', 'super_low');
        $this->appendCategoriesAndImagesSizes($menShoesSneakersCategory, 'Jordan 4 Red Cement', ["Nike", "Jordan"], 250, $this->getPaths($pathMenSneakers, 'red_cement/', 2), ['white', 'black', 'red'], 'shoes', 'men', 'high');
        $this->appendCategoriesAndImagesSizes($menShoesSneakersCategory, 'Jordan 1 Lost & Found', ["Nike", "Jordan"], 300, $this->getPaths($pathMenSneakers, 'lost_and_found/', 3), ['white', 'black', 'red'], 'shoes', 'men', 'low');
        $this->appendCategoriesAndImagesSizes($menShoesSneakersCategory, 'Jordan 1 University Blue', ["Nike", "Jordan"], 220, $this->getPaths($pathMenSneakers, 'university_blue/', 1, '.png'), ['white', 'black', 'blue'], 'shoes', 'men', 'high');

        $menShoesFlipFlopsCategory = Category::find(6);
        $pathMenFlipFlops = 'men/shoes/flip_flops/';
        $this->appendCategoriesAndImagesSizes($menShoesFlipFlopsCategory, 'Yeezy Slides Slate Gray', ["Adidas", "Yeezy"], 80, $this->getPaths($pathMenFlipFlops, 'slides/', 2), ['gray'], 'shoes', 'men', 'super_high');
        $this->appendCategoriesAndImagesSizes($menShoesFlipFlopsCategory, 'Yeezy Foam Runner Onyx', ["Adidas", "Yeezy"], 100, $this->getPaths($pathMenFlipFlops, 'foam/', 2), ['black'], 'shoes', 'men', 'super_high');

        $menShoesSportCategory = Category::find(7);
        $pathMenSport = 'men/shoes/sport/';
        $this->appendCategoriesAndImagesSizes($menShoesSportCategory, 'Nike Mercurial', ['Nike'], 250, $this->getPaths($pathMenSport, 'mercurial/', 3), ['green', 'black'], 'shoes', 'men', 'high');
        $this->appendCategoriesAndImagesSizes($menShoesSportCategory, 'Nike ZOOM Fly 5', ['Nike'], 200, $this->getPaths($pathMenSport, 'zoom/', 1), ['yellow', 'pink'], 'shoes', 'men', 'medium');

        $menClothesHats = Category::find(9);
        $pathMenHats = 'men/clothes/hats/';
        $this->appendCategoriesAndImagesSizes($menClothesHats, 'Palm Angels Cap', ['Palm Angels'], 100, $this->getPaths($pathMenHats, 'pa_cap/', 2), ['black'], 'clothes', 'men', 'low');
        $this->appendCategoriesAndImagesSizes($menClothesHats, 'Dsquared2 Icon Cap', ['Disquared2'], 120, $this->getPaths($pathMenHats, 'dsq2_cap/', 2), ['black'], 'clothes', 'men', 'low');
  
        $menClothesTops = Category::find(10);
        $pathMenHats = 'men/clothes/tops/';
        $this->appendCategoriesAndImagesSizes($menClothesTops, 'Bape Shark Purple Camo Fullzip', ['Bathing Ape'], 400, $this->getPaths($pathMenHats, 'shark_zip/', 2), ['purple', 'pink'], 'clothes', 'men', 'medium');
        $this->appendCategoriesAndImagesSizes($menClothesTops, 'Supreme Box Logo Hoodie', ['Supreme'], 300, $this->getPaths($pathMenHats, 'sup_box/', 2), ['black'], 'clothes', 'men', 'high');
        $this->appendCategoriesAndImagesSizes($menClothesTops, 'Corteiz T-shirt', ['Corteiz'], 130, $this->getPaths($pathMenHats, 'corteiz/', 1), ['black'], 'clothes', 'men', 'medium');
        $this->appendCategoriesAndImagesSizes($menClothesTops, 'Stone Island Crewneck', ['Stone Island'], 240, $this->getPaths($pathMenHats, 'si_crew/', 1, '.avif'), ['black'], 'clothes', 'men', 'medium');
        $this->appendCategoriesAndImagesSizes($menClothesTops, 'Balenciaga Longsleeve', ['Balenciaga'], 180, $this->getPaths($pathMenHats, 'bal_sleeve/', 1, '.jpg'), ['black'], 'clothes', 'men', 'low');
        
        $menClothesTrousers = Category::find(11);
        $pathMenTrousers = 'men/clothes/trousers/';
        $this->appendCategoriesAndImagesSizes($menClothesTrousers, 'Palm Angles Track Pants', ['Palm Angels'], 350, $this->getPaths($pathMenTrousers, 'pa_track/', 1, '.avif'), ['black'], 'clothes', 'men', 'medium');
        $this->appendCategoriesAndImagesSizes($menClothesTrousers, 'Bape Shark Shorts', ['Bathing Ape'], 400, $this->getPaths($pathMenTrousers, 'shark_shorts/', 3), ['blue', 'white'], 'clothes', 'men', 'low');
        $this->appendCategoriesAndImagesSizes($menClothesTrousers, 'Evisu Denim', ['Evisu'], 450, $this->getPaths($pathMenTrousers, 'evisu/', 1, '.png'), ['black', 'yellow'], 'clothes', 'men', 'super_low');

    }

    private function getPaths(string $folders, string $file, int $count, string $ext='.webp'){
        $path = [];
        for($i=1; $i<=$count; $i++){
            $path[] = $folders.$file.$i.$ext;
        }
        return $path;
    }


    private function appendCategoriesAndImagesSizes(Category $category, string $name, array $brands, float $price, array $images, array $colors, string $size1, string $size2, string $sizeAmount ){
        $item = Item::factory()->create([
            'name' => $name,
            'price' => $price,
        ]);

        //attaching brand
        foreach($brands as $brand){
            $brandId = Brand::where('name', $brand)->first()->id;
            $item->brands()->attach($brandId);
        }
        
        //attaching colors
        foreach($colors as $color){
            $colorId = Color::where('name', $color)->first()->id;
            $item->colors()->attach($colorId);
        }

        //attaching sizes
        foreach($this->sizes[$size1][$size2] as $size){
            $sizeId = Size::where('name', $size)->first()->id;
            $item->sizes()->attach($sizeId, ['amount' => max(0, rand(-10, $this->amount[$sizeAmount]))]);
        }
        
        // creating main picture
        ItemImage::create([
            'image' => $images[0],
            'item_id' => $item->id,
            'main' => true,
        ]);
        unset($images[0]);

        foreach($images as $image){
            ItemImage::create([
                'image' => $image,
                'item_id' => $item->id
            ]);
        }

        while($category){
            $item->categories()->attach($category->id);
            $category = $category->parent;
        }

    }
}
