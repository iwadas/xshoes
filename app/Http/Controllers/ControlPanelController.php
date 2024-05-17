<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class ControlPanelController extends Controller
{

    public function index(Request $request){
        return inertia("ControlPanel/Index");
    }
    
}
