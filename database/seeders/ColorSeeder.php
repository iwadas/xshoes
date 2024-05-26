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
            [
                'name' => 'black',
                'color' => 	'#000000'
            ],
            [
                'name' => 'white',
                'color' => '#FFFFFF'
            ],
            [
                'name' => 'gray',
                'color' => '#6b7280'
            ],
            [
                'name' => 'blue',
                'color' => '#3b82f6'
            ],
            [
                'name' => 'red',
                'color' => '#dc2626'
            ],
            [
                'name' => 'green',
                'color' => '#22c55e'
            ],
            [
                'name' => 'purple',
                'color' => '#a855f7'
            ],
            [
                'name' => 'pink',
                'color' => '#ec4899'
            ],
            [
                'name' => 'dark_blue',
                'color' => '#1e3a8a'
            ],
            [
                'name' => 'orange',
                'color' => '#f97316'
            ],
            [
                'name' => 'yellow',
                'color' => '#facc15'
            ],
        ]);
    }
}
