<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        return inertia('Home', [
            'news' => News::all()
        ]);
    }

    public function help(){
        return inertia('Help');
    }
}
