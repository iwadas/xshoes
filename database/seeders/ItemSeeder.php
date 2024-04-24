<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $menShoesSneakersCategory = Category::find(5);
        $pathMenSneakers = 'men/shoes/sneakers/';
        $this->appendCategoriesAndImages($menShoesSneakersCategory, 'Travis Fragment', ["Jordan", "Nike", "Travis Scott"], 1000, $this->getPaths($pathMenSneakers, 'fragment/', 3, '.jpg'));
        $this->appendCategoriesAndImages($menShoesSneakersCategory, 'Jordan 4 Red Cement', ["Nike", "Jordan"], 250, $this->getPaths($pathMenSneakers, 'red_cement/', 2));
        $this->appendCategoriesAndImages($menShoesSneakersCategory, 'Jordan 1 Lost & Found', ["Nike", "Jordan"], 300, $this->getPaths($pathMenSneakers, 'lost_and_found/', 3));
        $this->appendCategoriesAndImages($menShoesSneakersCategory, 'Jordan 1 University Blue', ["Nike", "Jordan"], 220, $this->getPaths($pathMenSneakers, 'university_blue/', 1, '.png'));

        $menShoesFlipFlopsCategory = Category::find(6);
        $pathMenFlipFlops = 'men/shoes/flip_flops/';
        $this->appendCategoriesAndImages($menShoesFlipFlopsCategory, 'Yeezy Slides Slate Gray', ["Adidas", "Yeezy"], 80, $this->getPaths($pathMenFlipFlops, 'slides/', 2));
        $this->appendCategoriesAndImages($menShoesFlipFlopsCategory, 'Yeezy Foam Runner Onyx', ["Adidas", "Yeezy"], 100, $this->getPaths($pathMenFlipFlops, 'foam/', 2));

        $menShoesSportCategory = Category::find(7);
        $pathMenSport = 'men/shoes/sport/';
        $this->appendCategoriesAndImages($menShoesSportCategory, 'Nike Mercurial', ['Nike'], 250, $this->getPaths($pathMenSport, 'mercurial/', 3));
        $this->appendCategoriesAndImages($menShoesSportCategory, 'Nike ZOOM Fly 5', ['Nike'], 200, $this->getPaths($pathMenSport, 'zoom/', 1));

        $menClothesHats = Category::find(9);
        $pathMenHats = 'men/clothes/hats/';
        $this->appendCategoriesAndImages($menClothesHats, 'Palm Angels Cap', ['Palm Angels'], 100, $this->getPaths($pathMenHats, 'pa_cap/', 2));
        $this->appendCategoriesAndImages($menClothesHats, 'Dsquared2 Icon Cap', ['Disquared2'], 120, $this->getPaths($pathMenHats, 'dsq2_cap/', 2));
  
        $menClothesTops = Category::find(10);
        $pathMenHats = 'men/clothes/tops/';
        $this->appendCategoriesAndImages($menClothesTops, 'Bape Shark Purple Camo Fullzip', ['Bathing Ape'], 400, $this->getPaths($pathMenHats, 'shark_zip/', 2));
        $this->appendCategoriesAndImages($menClothesTops, 'Supreme Box Logo Hoodie', ['Supreme'], 300, $this->getPaths($pathMenHats, 'sup_box/', 2));
        $this->appendCategoriesAndImages($menClothesTops, 'Corteiz T-shirt', ['Corteiz'], 130, $this->getPaths($pathMenHats, 'corteiz/', 1));
        $this->appendCategoriesAndImages($menClothesTops, 'Stone Island Crewneck', ['Stone Island'], 240, $this->getPaths($pathMenHats, 'si_crew/', 1, '.avif'));
        $this->appendCategoriesAndImages($menClothesTops, 'Balenciaga Longsleeve', ['Balenciaga'], 180, $this->getPaths($pathMenHats, 'bal_sleeve/', 1, '.jpg'));
        
        $menClothesTrousers = Category::find(11);
        $pathMenTrousers = 'men/clothes/trousers/';
        $this->appendCategoriesAndImages($menClothesTrousers, 'Palm Angles Track Pants', ['Palm Angels'], 350, $this->getPaths($pathMenTrousers, 'pa_track/', 1, '.avif'));
        $this->appendCategoriesAndImages($menClothesTrousers, 'Bape Shark Shorts', ['Bathing Ape'], 400, $this->getPaths($pathMenTrousers, 'shark_shorts/', 3));
        $this->appendCategoriesAndImages($menClothesTrousers, 'Evisu Denim', ['Evisu'], 450, $this->getPaths($pathMenTrousers, 'evisu/', 1, '.png'));

    }

    private function getPaths(string $folders, string $file, int $count, string $ext='.webp'){
        $path = [];
        for($i=1; $i<=$count; $i++){
            $path[] = $folders.$file.$i.$ext;
        }
        return $path;
    }


    private function appendCategoriesAndImages(Category $category, string $name, array $brands, float $price, array $images){
        $item = Item::factory()->create([
            'name' => $name,
            'price' => $price,
        ]);

        //attaching brand
        foreach($brands as $brand){
            $brandId = Brand::where('name', $brand)->first()->id;
            $item->brands()->attach($brandId);
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
