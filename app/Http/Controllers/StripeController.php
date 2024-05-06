<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Payment;
use App\Models\ItemSize;
use App\Models\Shipping;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        if(!$request->user()->cart){
            return $this->returnError('Your cart is empty!');
        }

        $shipping = Shipping::find($request->shipping_id);
        if(!$shipping){
            return $this->returnError("Shipping hasn't been found!");
        }
        $address = Address::find($request->address_id);
        if(!$address){
            return $this->returnError("Address hasn't been found!");
        }
        if($address->user_id != $request->user()->id){
            return $this->returnError("Address hasn't been found!");  
        }


        $price = $request->user()->cart->cart_items()
        ->join('items', 'cart_items.item_id', '=', 'items.id')
        ->sum(DB::raw('cart_items.amount * items.price'));
        $price += $shipping->price;

        $stripe = new StripeClient(config('stripe.stripe_sk'));

        $lineItems = [];
        foreach($request->user()->cart->cart_items()->get() as $cartItem){
            array_push($lineItems, [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cartItem->item->name." ".$cartItem->size->name,
                    ],
                    'unit_amount' => $cartItem->item->price*100,
                ],
                'quantity' => $cartItem->amount,
            ]);
        }    


        $response = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment_success.stripe').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment_cancel.stripe'),
        ]);

        if(isset($response->id) && $response->id != ''){
            $payment = $request->user()->payments()->create([
                'key' => $response['id'],
                'price' => $price,
                'by' => 'stripe',
            ]);

            $request->user()->orders()->create([
                'payment_id' => $payment->id,
                'cart_id' => $request->user()->cart->id,
                'shipping_id' => $request->shipping_id,
                'address_id' => $request->address_id,
            ]);

            return response()->json(['url' => $response->url]);
        } else {
            session()->put('flash', ['error' => 'Something went wrong!']);
            return response()->json(['url' => route('cart.index')]);
        }
    }

    public function success(Request $request)
    {
        if(isset($request->session_id)) {

            $stripe = new StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            if($response->status === "complete" && $response->payment_status === "paid"){
                $payment = $request->user()->payments()->where('key', $response->id)->first();
                if($payment){
                    $payment->update([
                        'status' => 'completed',
                        'payment_source' =>json_encode($response->customer_details)
                    ]);
                    
                    $this->deleteUnfinishedOrders($request);

                    $this->adjustAvailableItems($payment);
                    // detach cart from user
                    $payment->order->cart->update([
                        'user_id' => null
                    ]);

                } else {
                    return redirect()->route('cart.index')->with('error', "Something went wrong!");
                }

            }

            return redirect()->route('order.index')->with("success", "Payment completed successfully!");
        } else {
            return redirect()->route('payment_cancel.stripe');
        }
    }

    public function cancel(Request $request)
    {
        $this->deleteUnfinishedOrders($request);

        $payment = $request->user()->payments()->where('key', $request->session_id)->first();
        
        if($payment){
            $order = $payment->order();
            $order->delete();
            $payment->update([
                'status' => 'cancelled'
            ]);
        }

        return redirect()->route('cart.index')->with('error', "Payment was cancelled!");
    }

    private function returnError($error, $errorCode=404){
        return response()->json(['error' => $error], $errorCode);
    }

    private function deleteUnfinishedOrders(Request $request){
        $request->user()->orders()->whereDoesntHave('payment', fn($query)=>$query->where("status", 'completed'))->delete();
    }

    private function adjustAvailableItems(Payment $payment){
        foreach($payment->order->cart->cart_items()->get() as $cartItem){
            $itemSize = ItemSize::where('item_id', $cartItem->item_id)->where('size_id', $cartItem->size_id)->first();
            $itemSize->amount = $itemSize->amount - $cartItem->amount;
            $itemSize->save();
        }
    }
}
