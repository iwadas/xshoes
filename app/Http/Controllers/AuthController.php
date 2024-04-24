<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        return inertia('Auth/Register');
    }

    public function register_authenticate(Request $request){

        $user = User::create($request->validate([
            'name' => 'unique:users|string|max:16',
            'email' => 'unique:users|required|email',
            'password' => 'required|min:4|confirmed'
        ]));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Your account has been successfully created!');
    }

    public function login(Request $request){
        return inertia('Auth/Login');
    }

    public function login_authenticate(Request $request){
        
        if(!Auth::attempt($request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]), true)){
            throw ValidationException::withMessages([
                'email' => 'Credentials don\'t match'
            ])->status(422);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('home'))->with('success', 'Logged in successfully');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out!');
    }

}
