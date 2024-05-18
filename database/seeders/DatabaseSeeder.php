<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\OrderSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NewsSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            ItemSeeder::class,
            PromoCodeSeeder::class,
            ShippingSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            OrderSeeder::class
        ]);


        // \App\Models\User::factory(10)->create();

    }
}
