<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::insert([
            [
                'header' => 'Social media',
                'color' => '#f43f5e',
                'image' => 'news/influencer.jpg'
            ],
            [
                'header' => 'Summer SALE -20%',
                'color' => '#2563eb',
                'image' => 'news/sale.jpg'
            ],
            [
                'header' => 'Make someone special',
                'color' => '#22c55e',
                'image' => 'news/gift.jpg'
            ],
            [
                'header' => 'Always on time',
                'color' => '#0ea5e9',
                'image' => 'news/delivery.jpg'
            ],
            [
                'header' => 'Best fits',
                'color' => '#2dd4bf',
                'image' => 'news/competition.jpg'
            ],
        ]);
    }
}
