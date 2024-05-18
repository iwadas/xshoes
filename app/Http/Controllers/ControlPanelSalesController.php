<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class ControlPanelSalesController extends Controller
{
    public function index(Request $request){

        $time = $this->getCarbonTime($request->time);
        $orders = Order::whereHas('payment', fn($query)=>$query->where('status', 'completed'))
            ->when($time,
                fn($query, $value)=>$query->where('created_at', '>=', $value)
            )
            ->with(['cart.cart_items.item', 'payment'])
            ->get();

        // calculate total income, by summing all order->payments->price
        $income = $orders->sum(fn($order) => $order->payment->price);

        $products = [];
        foreach($orders as $order){
            foreach($order->cart->cart_items as $cartItem){
                if(isset($products[$cartItem->item_id])){
                    $products[$cartItem->item_id]['sold'] += $cartItem->amount;
                } else {
                    $products[$cartItem->item_id] = ['item' => $cartItem->item, 'sold' => $cartItem->amount];
                }
            }
        }

        return inertia('ControlPanelSales/Index', [
            'orders' => $orders,
            'income' => $income,
            'products' => $products
        ]);
    }

    private function getCarbonTime($time){
        switch ($time) {
            case 'month':
                return Carbon::now()->startOfMonth();
                break;
            case 'year':
                return  Carbon::now()->startOfYear();
                break;
            case 'all':
                return null;
                break;
            default:
                return Carbon::today();
                break;
        }
    }
}
