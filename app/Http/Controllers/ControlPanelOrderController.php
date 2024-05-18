<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tracking;
use Illuminate\Http\Request;

class ControlPanelOrderController extends Controller
{
    public function index(Request $request){
        $status = $request->status ? $request->status : 'received';

        return inertia("ControlPanelOrder/Index", [
            'orders' => Order::whereHas('tracking', fn($query)=>$query->where('status', $status))
                ->when($request->search ?? false, 
                    fn($query, $value)=>$query->whereHas('user', fn($query)=>$query->where('name', 'like', '%'.$value.'%')->orWhere('email', 'like', '%'.$value.'%'))
                )
                ->with('shipping', 'tracking', 'address', 'payment', 'user')
                ->with('cart.cart_items', fn($query)=>$query->with(['item.images', 'size']))
                ->paginate(10)->withQueryString(),
            'status' => $status,
            'search' => $request->search
        ]);
    }

    public function update(Request $request, Order $order){
        $request->validate([
            'url' => 'required|string|min:10|starts_with:http://,https://'
        ]);
        Tracking::where('id', $order->tracking_id)->first()->update([
            'status' => 'shipped',
            'url' => $request->input('url')
        ]);

        return redirect()->back()->with('success', 'Order status successfully updated!');
    }

    public function complete(Order $order){
        $tracking = Tracking::where('id', $order->tracking_id)->first();
        if($tracking->status == 'shipped'){
            $tracking->update([
                'status' => 'completed',
            ]);
            return redirect()->back()->with('success', 'Order status successfully updated!');
        } else {
            return redirect()->back()->with('error', 'This order does not have status of shipped. Please refresh page!');
        }

    }
}
