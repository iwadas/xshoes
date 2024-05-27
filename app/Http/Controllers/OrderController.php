<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return inertia("Order/Index", [
            'orders' => $request->user()->orders()
                ->whereHas('payment', fn($query)=>$query->where('status', 'completed'))
                ->with('shipping', 'address', 'payment', 'tracking', 'cart')
                ->with('cart.cart_items', 
                    fn($query)=>$query->with('size')->with('item.images',
                        fn($query)=>$query->where('main', true))
                )
                ->orderBy('created_at', 'desc')
                ->get(),
            'uncompleted_orders' => $request->user()->orders()
                ->whereHas('payment', fn($query)=>$query->where('status', 'in_progress'))
                ->with('shipping', 'address', 'payment', 'cart')
                ->with('cart.cart_items', 
                    fn($query)=>$query->with('size')->with('item.images',
                        fn($query)=>$query->where('main', true))
                )
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }


    public function destroy(Request $request, Order $order){
        if($request->user()->id === $order->user_id){
            $request->order->payment->delete();
            $request->order->delete();
        }
        return redirect()->back()->with('success', 'Order was cancelled successfully!');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return inertia("Order/Show", [
            // 'order' => $order->load(['shipping', 'address', 'payment', 'tracking'])->load(['cart.cart_items' => fn($query)=>$query->with('item.images', 'size')])
            'order' => $order->load(['shipping', 'address', 'payment', 'tracking'])->load(['cart' => fn($query)=>$query->with('promo_code')->with('cart_items', fn($query)=>$query->with('item.images', 'size'))])
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

}
