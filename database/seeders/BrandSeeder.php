<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            ['name' => 'Nike'],
            ['name' => 'Jordan'],
            ['name' => 'Adidas'],
            ['name' => 'Yeezy'],
            ['name' => 'Bathing Ape'],
            ['name' => 'Supreme'],
            ['name' => 'Corteiz'],
            ['name' => 'Balenciaga'],
            ['name' => 'Stone Island'],
            ['name' => 'Disquared2'],
            ['name' => 'Palm Angels'],
            ['name' => 'Travis Scott'],
            ['name' => 'Evisu'],
        ]);
    }
}
