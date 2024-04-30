<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->user()->cart->promo_code()->first());

        return inertia(
            "Cart/Index",
            [
                'promoCode' => $request->user()->cart ? $request->user()->cart->promo_code()->first() : null
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $itemId = $request->item_id;
        $sizeId = $request->size_id;
        
        $item = Item::find($itemId);
        if (!$item || !$item->sizes()->find($sizeId)) {
            return redirect()->back()->with('error', "This size is no longer available. Please refresh the page!");
        }

        $availableSizesAmount = $item->sizes()->find($sizeId)->pivot->amount;
        if ($availableSizesAmount === 0) {
            return redirect()->back()->with('error', "This size is no longer available. Please refresh the page!");
        }

        // if user doesnt have cart create one
        $cart = $request->user()->cart()->firstOrCreate([]);
        $cartItem = $cart->cart_items()->where(['size_id' => $sizeId, 'item_id'=> $itemId])->first();
        // check whether user already have this item in his cart
        if($cartItem){
            $currentAmount = $cartItem->amount;
            // is it possible to add more of this product?
            if($currentAmount >= $availableSizesAmount){
                return redirect()->back()->with('error', "You have reached cart limit for this product!");
            } else {
                $cartItem->update([
                    'amount' => ++$currentAmount
                ]);
            }
        //create cart_item
        } else {
            $cart->cart_items()->create([
                'size_id' => $sizeId,
                'item_id' => $itemId,
            ]);
        }
        
        return redirect()->back()->with('success', 'Item successfully added to cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {

        $size = $cartItem->item->sizes()->find($cartItem->size_id);
        if(!$size){
            return redirect()->back()->with('error', 'Size is no longer available!');
        }

        $maxAmount = $size->pivot->amount;
        $previousAmount = $cartItem->amount;
        $newAmount = $request->amount;

        if($newAmount > $maxAmount){
            $cartItem->update([
                'amount' => $maxAmount
            ]);
            return redirect()->back()->with('error', 'Sorry, you cannot add more than '.$maxAmount.' of this product!');
        };
        
        $difference = $newAmount - $previousAmount;
        
        if($difference != 0){
            $cartItem->update([
                'amount' => $newAmount
            ]);
        }

        $message = $difference > 0 ? 'Product succesfully added to cart' : 'Quantity of the product changed!';

        return redirect()->back()->with('success',  $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CartItem $cartItem){

        $cartItem->delete();
        return redirect()->back()->with('success', 'Product was removed from your cart!');

    }
}
