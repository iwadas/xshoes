<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoCodeController extends Controller
{
    public function verify(Request $request){

        $request->validate([
            'promo_code_name' => 'string'
        ]);

        $promoCode = PromoCode::where('name', $request->promo_code_name)->first();
        if(!$promoCode){
            return response()->json(['error' => 'Wrong code!'], 403);
        }
        
        $totalPrice = $request->user()->cart->cart_items()
        ->join('items', 'cart_items.item_id', '=', 'items.id')
        ->sum(DB::raw('cart_items.amount * items.price'));
        
        if($totalPrice < $promoCode->price_from){
            return response()->json(['error' => 'Code can be applied when you have items with value of '.$promoCode->price_from.'$ or more!'], 403);
        }

        if($promoCode->available_till < now()){
            return response()->json(['error' => 'Code is no longer available!'], 403);
        }

        if($promoCode->for_new_users){
            // if(!$request->user()->orders()->exists()){
            //     return response()->json(['error' => 'This code can only be used on first order!']) 
            // }
        }

        $request->user()->cart->update([
            'promo_code_id' => $promoCode->id
        ]);
        // return response()->json(['value' => $totalPrice]);
        return response()->json([
            'success' => 'Success! Discount applied',
            'promo_code' => $promoCode,
        ]);
    }
}
