<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class ControlPanelSalesController extends Controller
{
    public function index(Request $request){

        $time = $request->time ? $request->time : 'day';
        $date = $this->getCarbonTime($time);
        $orders = Order::whereHas('payment', fn($query)=>$query->where('status', 'completed'))
            ->when($date,
                fn($query, $value)=>$query->where('created_at', '>=', $value)
            )
            ->with('payment')
            ->with(
                'cart.cart_items', fn($query)=>$query->with(['item.images', 'size'])
            )
            ->orderBy('created_at', 'desc')
            ->get();

        // calculate total income, by summing all order->payments->price
        $items = [];
        foreach($orders as $order){
            foreach($order->cart->cart_items as $cartItem){
                if(isset($items[$cartItem->item_id])){
                    $items[$cartItem->item_id]['sold'] += $cartItem->amount;
                    if(isset($items[$cartItem->item_id]['sizes'][$cartItem->size->name])){
                        $items[$cartItem->item_id]['sizes'][$cartItem->size->name] += $cartItem->amount;
                    } else {
                        $items[$cartItem->item_id]['sizes'][$cartItem->size->name] = $cartItem->amount;
                    }
                } else {
                    $items[$cartItem->item_id] = ['item' => $cartItem->item, 'sold' => $cartItem->amount, 'sizes' => [$cartItem->size->name => $cartItem->amount]];
                }
            }
        }

        usort($items, function($a, $b) {
            return $b['sold'] >= $a['sold'];
        });

        return inertia('ControlPanelSales/Index', [
            'orders' => $orders,
            'items' => $items,
            'time' => $time
        ]);
    }

    private function getCarbonTime($time){
        switch ($time) {
            case 'month':
                return Carbon::now()->startOfMonth();
            case 'year':
                return Carbon::now()->startOfYear();
            default:
                return Carbon::today();
        }
    }
}
