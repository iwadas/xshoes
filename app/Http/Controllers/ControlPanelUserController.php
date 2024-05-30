<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ControlPanelUserController extends Controller
{
    public function index(Request $request){
        return inertia('ControlPanelUser/Index', [
            'users' => User::with('roles')->withTrashed()->when($request->search ?? false,
                fn($query, $value)=>$query->where('name', 'like', '%'.$value.'%')->orWhere('email', 'like', '%'.$value.'%')->orWhere('id', 'like', '%'.$value.'%')
            )->orderBy('id', 'desc')->paginate(20)->withQueryString(),
            'search' => $request->search,
        ]);
    }

    public function update(Request $request, User $user){
        if(!$request->user()->roles()->where('name', 'admin')->exists()){
            return abort(403);
        }
        if($user->roles()->count()){
            return redirect()->back()->with('error', 'This user already is moderator!');
        }

        $moderatorRole = Role::where('name', 'moderator')->first();
        $user->roles()->attach($moderatorRole);
        return redirect()->back()->with('success', $user->name.' has been promoted to moderator!');
        
    }
    
    public function destroy(Request $request, User $user){
        if($user->roles()->count() && !$request->user()->roles()->where('name', 'admin')->exists()){
            return abort(403);
        }
        $user->delete();
        return redirect()->back()->with('success', $user->name.' has been banned!');
    }
    
    public function restore(Request $request, User $user){
        $user->restore();
        return redirect()->back()->with('success', $user->name.' has been unbanned!');
    }

}
