<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use App\Models\Category;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => $request->user() ? $request->user() : null,
            'role' => $request->user() ? $request->user()->roles()->get() : null,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error')
            ],
            'categories' => Category::whereDoesntHave('parent')->with('children', fn($query)=>$query->with('children'))->get(),
            'cart_items' => $request->user()  
                ? ($request->user()->cart 
                    ? $request->user()->cart->cart_items()->with('item', fn($query)=>$query->with('images', fn($query)=>$query->where('main', true)))->with('size')->get() 
                    : null) 
                : null,
            'uncompleted_orders_count' => $request->user() 
                ? $request->user()->orders()->whereHas('payment', fn($query)=>$query->where('status', 'in_progress'))->count()
                : null,
        ]);
    }
}
