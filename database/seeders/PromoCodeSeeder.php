<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromoCode::insert([
            [
                'name' => 'SUMMER20',
                'discount' => 20,
                'type' => 'percentage',
                'price_from' => 150,
                'for_new_users' => false,
                'available_till' => '2024-09-30'
            ],
            [
                'name' => 'NEWCUSTOMER',
                'discount' => 100,
                'type' => 'fixed',
                'for_new_users' => true,
                'price_from' => 500,
                'available_till' => '2030-01-01'
            ]
        ]);
    }
}
