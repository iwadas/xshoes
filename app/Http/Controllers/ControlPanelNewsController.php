<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ControlPanelNewsController extends Controller
{
    public function index(Request $request){
        return inertia('ControlPanelNews/Index', [
            'newsArray' => News::all()
        ]);
    }

    public function store(Request $request){
    
        $validatedData = $request->validate([
            'image' => 'required|file|mimes:jpg,webp,jpeg,png',
            'color' => 'required',
            'header' => 'required',
        ]);

        $storedImage = $request->image->store('new_images', 'public');
        $validatedData['image'] = $storedImage;

        News::create($validatedData);
        return redirect()->back()->with('success', 'News uploaded successfully');
    }
    
    public function destroy(News $news){
        $news->delete();
        return redirect()->back()->with('success', 'News deleted successfully');
    }
}
