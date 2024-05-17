<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request){

        if(!$request->user()->cart){
            return redirect()->route('home')->with('error', 'Something went wrong! Please refresh website');
        }

        return inertia('Checkout/Index',[
            'promoCode' => $request->user()->cart->promo_code()->first(),
            'addresses' => $request->user()->addresses()->get(),
            'shippings' => Shipping::all(),
        ]);
    }

}
