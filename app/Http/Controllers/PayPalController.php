<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
// Import the class namespaces first, before using it directly

{
   
    public function payment(Request $request){

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

        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                'return_url' => route('payment_success.paypal'),
                'cancel_url' => route('payment_cancel.paypal'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $price,
                    ]
                ],
            ],
        ];

        $response = $provider->createOrder($data);

        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){

                    $payment = $request->user()->payments()->create([
                        'key' => $response['id'],
                        'price' => $price,
                    ]);
            
                    $request->user()->orders()->create([
                        'payment_id' => 1,
                        'payment_id' => $payment->id,
                        'cart_id' => $request->user()->cart->id,
                        'shipping_id' => $request->shipping_id,
                        'address_id' => $request->address_id,
                    ]);

                    return response()->json(['url' => $link['href']]);
                }
            }
        }

        return $this->returnError("Something went wrong!");

    }
    public function success(Request $request){
        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if(isset($response['status']) && $response['status'] === 'COMPLETED') {

            $payment = $request->user()->payments()->where('key', $request->token)->first();
            $payment->update([
                'status' => 'completed',
                'payment_source' =>json_encode($response['payment_source'])
            ]);
        
            $this->deleteUnfinishedOrders($request);
            // detach cart from user
            $payment->order->cart->update([
                'user_id' => null
            ]);

            return redirect()->route('order.index');
        } else {
            return redirect()->route('payment_cancel.paypal');
        }
    }
    public function cancel(Request $request){
        $this->deleteUnfinishedOrders($request);

        $payment = $request->user()->payments()->where('key', $request->token)->first();
        
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

    private function deleteUnfinishedOrders($request){
        $request->user()->orders()->whereDoesntHave('payment', fn($query)=>$query->where("status", 'completed'))->delete();
    }


}
