<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::insert([
            ['name' => 'black'],
            ['name' => 'white'],
            ['name' => 'gray'],
            ['name' => 'blue'],
            ['name' => 'red'],
            ['name' => 'green'],
            ['name' => 'purple'],
            ['name' => 'pink'],
            ['name' => 'dark blue'],
            ['name' => 'orange'],
            ['name' => 'yellow'],
        ]);
    }
}
