<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Payment;
use App\Models\CartItem;
use App\Models\ItemSize;
use App\Models\Shipping;
use App\Models\Tracking;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach($users as $user){
            //give user address
            $address = Address::factory()->create(['user_id' => $user->id]);
            
            for($j=0; $j<rand(1,5); $j++){

                //prepare cart
                $cart = Cart::create();
                $price = 0;

                $itemSizes = ItemSize::inRandomOrder()->take(rand(1,4))->get();
                foreach($itemSizes as $itemSize){
                    $amount = rand(1,3);
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'item_id' => $itemSize->item_id,
                        'size_id' => $itemSize->size_id,
                        'amount' => $amount
                    ]);
                    $price += Item::find($itemSize->item_id)->price;
                }
   
                //get random shipping
                $shipping = Shipping::inRandomOrder()->first();
                $price += $shipping->price;
                
                //create payment
                $payment = Payment::factory()->create(['user_id' => $user->id, 'price' => $price]);

                //create tracking
                $tracking = Tracking::factory()->create();

                $user->orders()->create([
                    'payment_id' => $payment->id,
                    'cart_id' => $cart->id,
                    'address_id' => $address->id,
                    'shipping_id' => $shipping->id,
                    'tracking_id' => $tracking->id,
                ]);
            }
        }

        



    }
}
