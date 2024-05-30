<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return inertia('Home', [
            'news' => News::all(),
            'bestsellers' => Item::where("is_bestseller", true)
                ->with(['brands', 'colors', 'available_sizes'])
                ->with(['categories' =>  fn($query)=>$query->orderBy('categories.id')])
                ->with('images')->get()
        ]);
    }

    public function help(){
        return inertia('Help');
    }
}
