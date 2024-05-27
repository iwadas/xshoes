<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PromoCodeController extends Controller
{

    private array $validationRules = [
        'name' => 'required|string|min:3|max:20',
        'discount' => 'required|numeric|min:0|max:10000',
        'price_from' => 'required|numeric|min:10',
        'type' => 'required|in:percentage,fixed',
        'available_till' => 'required|date',
        'for_new_users' => 'required|boolean',
    ];

    private array $labels = ['for_new_users', 'discount', 'name', 'type', 'available_till', 'price_from'];

    public function index(){
        return inertia('ControlPanelPromoCode/Index', [
            'promoCodes' => [
                'active' => PromoCode::where('available_till', '>=', Carbon::now())->get(),
                'inactive' => PromoCode::where('available_till', '<', Carbon::now())->get(),
            ]
        ]);
    }
    
    public function create(){
        return inertia('ControlPanelPromoCode/Create');
    }

    public function store(Request $request){
        $validatedData = $request->validate($this->validationRules);
        $this->checkValues($validatedData);
        PromoCode::create($validatedData);
        return redirect()->route('control_panel.promo_code.index')->with("success", "New promo code added!");
    
    }

    public function update(Request $request, PromoCode $promoCode){
        if(!($validationRule = $this->validationRules[$request->label])){
            return redirect()->back()->with('error', 'Validation rule not found for '.$request->label);
        }
        $request->validate([
            $request->label => $validationRule
        ]);
        $promoCodeValues = $promoCode->only(array_keys($this->validationRules));
        $promoCodeValues[$request->label] = $request[$request->label];
        $this->checkValues($promoCodeValues);
        $promoCode->update($promoCodeValues);

        return redirect()->back()->with('success', 'Promo code updated successfully');

    }

    private function checkValues(array $promoCode){
        if($promoCode['type'] == 'percentage'){
            if($promoCode['discount'] > 70){
                throw ValidationException::withMessages(['discount' => 'Maximum amount for discount is 70%']);
            }
        } else {
            if($promoCode['discount'] / $promoCode['price_from'] > 7/10){
                throw ValidationException::withMessages(['discount' => 'Value of dicount cannot be greated than 70% of price from amount']);
            }
        }
    }

    public function verify(Request $request){

        $request->validate([
            'promo_code_name' => 'string'
        ]);

        $promoCode = PromoCode::where('name', $request->promo_code_name)->first();
        if(!$promoCode){
            return response()->json(['error' => 'Wrong code!'], 403);
        }
        if ($promoCode->available_till < Carbon::now()) {
            return response()->json(['error' => 'Promo code has expired!'], 403);
        }
        
        $totalPrice = $request->user()->cart->cart_items()
        ->join('items', 'cart_items.item_id', '=', 'items.id')
        ->sum(DB::raw('cart_items.amount * items.price'));
        
        if($totalPrice < $promoCode->price_from){
            return response()->json(['error' => 'Code can be applied when you have items with value of '.$promoCode->price_from.'$ or more!'], 403);
        }

        if($promoCode->available_till < now()){
            return response()->json(['error' => 'Code is no longer available!'], 403);
        }

        if($promoCode->for_new_users){
            if(!$request->user()->payments()->where('status', 'completed')->exists()){
                return response()->json(['error' => 'This code can only be used on first order!']);
            }
        }

        $request->user()->cart->update([
            'promo_code_id' => $promoCode->id
        ]);
        // return response()->json(['value' => $totalPrice]);
        return response()->json([
            'success' => 'Success! Discount applied',
            'promo_code' => $promoCode,
        ]);
    }
}
