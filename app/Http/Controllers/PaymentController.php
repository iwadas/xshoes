<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\ItemSize;
use App\Models\Shipping;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
// Import the class namespaces first, before using it directly

{
    public function paypalCheckout(Request $request){
        $cart = $request->user()->cart;
        $errors = $this->checkoutValidation($request, $cart);
        if(isset($errors['error'])){
            return $this->redirectWithError($errors['url'], $errors['error']);
        }

        $shipping = Shipping::find($request->shipping_id);

        $price = $this->getCartPrice($cart, $shipping);

        $response = $this->getPaypalResponse($price);

        if($responseUrl = $this->getPaypalResponseUrl($response)){
            
            $payment = $this->createPayment($response['id'], $price, 'paypal', $request->user()->id);
            $this->createOrder($payment, $request);
            $this->detachCartFromUser($cart);

            return response()->json(['url' => $responseUrl]);

        } else {
            return $this->redirectWithError(route('checkout.index'), "We couldn't receive paypal redirect link! Please try again");
        };
    }

    public function stripeCheckout(Request $request){
        $cart = $request->user()->cart;
        $errors = $this->checkoutValidation($request, $cart);
        if(isset($errors['error'])){
            return $this->redirectWithError($errors['url'], $errors['error']);
        }

        $shipping = Shipping::find($request->shipping_id);

        $price = $this->getCartPrice($cart, $shipping);

        $response = $this->getStripeResponse($cart, $shipping);

        if(isset($response->id) && $response->id != ''){
            

            $payment = $this->createPayment($response->id, $price, 'stripe', $request->user()->id);
            $this->createOrder($payment, $request);
            $this->detachCartFromUser($cart);

            return response()->json(['url' => $response->url]);

        } else {
            return $this->redirectWithError(route('checkout.index'), "We couldn't receive stripe redirect link! Please try again");
        };
    }

    public function complete(Request $request, Order $order){

        if($order->payment->status !== 'in_progress'){
            return redirect()->route('home')->with('error', "Something went wrong! Please refresh the website");
        }
        if($request->user()->cart()){
            $request->user()->cart()->delete();
        }
        $order->cart()->update([
            'user_id' => $request->user()->id
        ]);
        $order->payment->delete();
        $order->delete();

        return redirect()->route('checkout.index');
    }

    public function paypalSuccess(Request $request){
        if($response = $this->checkIfPaypalPaymentIsCompleted($request->token)){
            
            $this->updatePaymentAsCompleted($request->token, $request->user(), $response['payment_source']);
            $this->deleteUnfinishedOrders($request);

            return redirect()->route('store.index')->with("success", "Payment completed successfully!");

        } else {
            return redirect()->route('payment.cancel.paypal', ['token' => $request->token]);
        };
    }

    public function stripeSuccess(Request $request){
        if($response = $this->checkIfStipePaymentIsCompleted($request->session_id)){
            
            $this->updatePaymentAsCompleted($request->session_id, $request->user(), $response->customer_details);
            $this->deleteUnfinishedOrders($request);

            return redirect()->route('order.index')->with("success", "Payment completed successfully!");

        } else {
            return redirect()->route('payment.cancel.stripe', ['session_id' => $request->session_id]);
        };
    }

    public function paypalCancel(Request $request){
        $this->attachCartToUser($request);
        $this->deleteUnfinishedOrders($request);
        return $this->deletePayment($request, $request->token);
    }

    public function stripeCancel(Request $request){
        $this->attachCartToUser($request);
        $this->deleteUnfinishedOrders($request);
        return $this->deletePayment($request, $request->session_id);
    }

    private function checkIfPaypalPaymentIsCompleted($token){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($token);
        return isset($response['status']) && $response['status'] === 'COMPLETED' ? $response : false;
    }

    private function checkIfStipePaymentIsCompleted($sessionId){
        if(!$sessionId){
            return false;
        }
        $stripe = new StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->retrieve($sessionId);
        return $response->status === "complete" && $response->payment_status === "paid" ? $response: false;
    }

    private function updatePaymentAsCompleted($key, User $user, $paypmentSource){
        $user->payments()->where('key', $key)->update([
            'status' => 'completed',
            'payment_source' => json_encode($paypmentSource),
        ]);
    }

    private function checkoutValidation(Request $request, $cart){
        if(!$cart){
            return ['url' => route('checkout.index'), 'error' => "Cart is empty!"];
        }
        $shipping = Shipping::find($request->shipping_id);
        if(!$shipping){
            return ['url' => route('checkout.index'), 'error' => "Shipping hasn't been found!"];
        }
        $address = Address::find($request->address_id);
        if(!$address){
            return ['url' => route('checkout.index'), 'error' => "Address hasn't been found!"];
        }
        if($address->user_id != $request->user()->id){
            return ['url' => route('checkout.index'), 'error' => "Address hasn't been found!"];
        }
        
        $adjusted = 0;
        // check whether items are available
        foreach($cart->cart_items()->get() as $cartItem){
            $itemAmount = ItemSize::where([['size_id', $cartItem->size_id], ['item_id', $cartItem->item_id]])->first()->amount;
            $itemBeingSold = Payment::where('status', 'in_progress')
                ->where('created_at', '>=', Carbon::now()->subMinutes(30))
                ->with(['order.cart.cart_items' => function ($query) use ($cartItem) {
                    $query->where('item_id', $cartItem->item_id);
                }])
                ->get()
                ->pluck('order.cart.cart_items.*.amount')
                ->flatten()
                ->sum();

            $availableItemAmount = $itemAmount - $itemBeingSold;
     
            if(!$availableItemAmount){
                $cartItem->delete();
                $adjusted = 1;
            } else if ($availableItemAmount < $cartItem->amount){
                $cartItem->amount = $availableItemAmount;
                $cartItem->save();
                $adjusted = 1;
            }
        }

        if($adjusted){
            return ['url' => route('cart.index'), "error" => "Amount of some products in your cart has been changed due to limited availability!"];   
        }

    }

    private function getCartPrice(Cart $cart, Shipping $shipping){
        $price = $cart->cart_items()
            ->join('items', 'cart_items.item_id', '=', 'items.id')
            ->sum(DB::raw('cart_items.amount * items.price'));
        $price += $shipping->price;
        return $price;
    }

    private function getPaypalResponse(float $price){
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $data = [
            "intent" => "CAPTURE",
            "application_context" => [
                'return_url' => route('payment.success.paypal'),
                'cancel_url' => route('payment.cancel.paypal'),
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

        return $provider->createOrder($data);
    }

    private function getStripeResponse(Cart $cart, Shipping $shipping){
        $stripe = new StripeClient(config('stripe.stripe_sk'));

        $lineItems = [];
        foreach($cart->cart_items()->get() as $cartItem){
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

        return $stripe->checkout->sessions->create([
            'line_items' => [
                ...$lineItems,
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $shipping->name.' shipping',
                        ],
                        'unit_amount' => $shipping->price * 100,
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success.stripe').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel.stripe').'?session_id={CHECKOUT_SESSION_ID}'
        ]);
    }

    private function getPaypalResponseUrl($response){
        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    return $link['href'];
                }
            }
        } else {
            return false;
        }
    }

    private function redirectWithError($url, $error){
        session()->flash('error', $error);
        return response()->json(['error_url' => $url]);
    }

    private function createPayment(string $key, float $price, string $method, int $userId){
        $payment = Payment::create([
            'user_id' => $userId,
            'key' => $key,
            'price' => $price,
            'by' => $method,
        ]);
        return $payment;
    }

    private function createOrder(Payment $payment, Request $request){
        $request->user()->orders()->create([
            'payment_id' => $payment->id,
            'cart_id' => $request->user()->cart->id,
            'shipping_id' => $request->shipping_id,
            'address_id' => $request->address_id,
        ]);
    }

    private function detachCartFromUser(Cart $cart){
        $cart->update([
            'user_id' => null
        ]);
    }

    private function attachCartToUser(Request $request){
        if(!$request->user()->cart){
            $request->user()->payments()->latest()->first()->order->cart->update([
                'user_id' => $request->user()->id
            ]);
        }
    }

    private function deletePayment(Request $request, string $key){
        $payment = $request->user()->payments()->where('key', $key)->first();
        
        if($payment){
            $order = $payment->order();
            $order->delete();
            $payment->update([
                'status' => 'cancelled'
            ]);
        }

        return redirect()->route('cart.index')->with('error', "Payment was cancelled!");
    }

    private function deleteUnfinishedOrders($request){
        $request->user()->orders()->whereDoesntHave('payment', fn($query)=>$query->where("status", 'completed'))->delete();
        $request->user()->payments()->where('status', 'in_progress')->delete();
    }

}
