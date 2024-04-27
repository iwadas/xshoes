<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Size::insert([
            ['name' => '35', 'for' => 'shoes'],
            ['name' => '36', 'for' => 'shoes'],
            ['name' => '37', 'for' => 'shoes'],
            ['name' => '38', 'for' => 'shoes'],
            ['name' => '39', 'for' => 'shoes'],
            ['name' => '40', 'for' => 'shoes'],
            ['name' => '41', 'for' => 'shoes'],
            ['name' => '42', 'for' => 'shoes'],
            ['name' => '43', 'for' => 'shoes'],
            ['name' => '44', 'for' => 'shoes'],
            ['name' => '45', 'for' => 'shoes'],
            ['name' => '46', 'for' => 'shoes'],
            ['name' => '47', 'for' => 'shoes'],
            ['name' => 'XXS', 'for' => 'clothes'],
            ['name' => 'XS', 'for' => 'clothes'],
            ['name' => 'S', 'for' => 'clothes'],
            ['name' => 'M', 'for' => 'clothes'],
            ['name' => 'L', 'for' => 'clothes'],
            ['name' => 'XL', 'for' => 'clothes'],
            ['name' => '2XL', 'for' => 'clothes'],
        ]);
    }
}
