<?php

namespace Database\Seeders;

use App\Models\Shipping;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shipping::insert([
            [
                'name' => 'DHL',
                'image' => 'shipping/dhl.jpg',
                'price' => 10,
                'delivery_time' => 5
            ],
            [
                'name' => 'dpd',
                'image' => 'shipping/dpd.jpg',
                'price' => 8,
                'delivery_time' => 7
            ],
            [
                'name' => 'FedEx',
                'image' => 'shipping/fedex.jpg',
                'price' => 14,
                'delivery_time' => 4
            ],
        ]);
    }
}
