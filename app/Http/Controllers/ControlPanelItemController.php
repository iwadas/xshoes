<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Size;
use App\Models\Color;
use App\Models\Category;
use App\Models\ItemSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControlPanelItemController extends Controller
{
    public function index(Request $request){

        $categoriesWithItems = Category::whereDoesntHave('parent')->with('children.children.items', fn($query)=>$query->with(['images', 'sizes', 'colors'])->with('categories', fn($query)=>$query->orderBy('id')))->get();

        return inertia('ControlPanelItem/Index', [
            'categories' =>  $categoriesWithItems,
            'sizes' => Size::orderBy('id')->get(),
            'colors' => Color::all(),
        ]);
    }

    public function update(Item $item, Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|min:0|numeric',
            'description' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'sizes' => 'required|string',
            'newImages.*' => 'sometimes|file|mimes:png,jpg,webp|max:10000',
            'colors' => 'required|array',
            'colors.*' => 'integer',
        ]);

        //images old
        $images = $item->images()->get();
        foreach($images as $image){
            if(!in_array($image->id, $request->oldImages)){
                Storage::delete($image->image);
                $image->delete();
            }
        };
        //images new
        $categories = $item->categories()->orderBy('id')->get();
        foreach($request->newImages as $image){
            $image_path = $image->store('/'.$categories[0]['name'].'/'.$categories[1]['name'].'/'.$categories[2]['name'], 'public');
            $item->images()->create(['image' => $image_path]);
        };

        foreach($request->sizes_to_adjust as $key=>$value){
            $itemSize = ItemSize::where([['item_id', $item->id], ['size_id', $key]])->first();
            if($itemSize){
                $preAmount = $itemSize->amount;
                if($newValue = $preAmount + $value){
                    $itemSize->update([
                        'amount' => $newValue
                    ]);
                }
            }
        }

        $itemColors = $item->colors()->get();
        foreach($itemColors as $color){
            if(!in_array($color->id, $request->colors)){
                $item->colors()->detach($color->id);
            }
        }
        foreach($request->colors as $color){
            if(!$item->colors()->find($color)){
                $item->colors()->attach($color);
            }
        }

        $item->update(
            $request->only(['price', 'name', 'description'])
        );

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|min:0|numeric',
            'description' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'sizes' => 'required|string',
            'newImages' => 'required|array',
            'newImages.*' => 'file|mimes:png,jpg,webp|max:10000',
            'colors' => 'required|array',
            'colors.*' => 'integer',
        ]);

        $item = Item::create($request->only(['price', 'description', 'name']));

        $categories = [];

        foreach($request->categories as $categoryId){
            $item->attach($categoryId);
            array_push($categories, Category::find($categoryId));
        }

        foreach($request->newImages as $image){
            $image_path = $image->store('/'.$categories[0]['name'].'/'.$categories[1]['name'].'/'.$categories[2]['name'], 'public');
            $item->images()->create(['image' => $image_path]);
        };

        $sizes = Size::where('for', $request->sizes)->get();
        foreach($sizes as $size){
            ItemSize::create([
                'item_id' => $item->id,
                'size_id' => $size->id,
                'amount' => 0,
            ]);
        }

        foreach($request->sizes_to_adjust as $key=>$value){
            $itemSize = ItemSize::where([['item_id', $item->id], ['size_id', $key]])->first();
            if($itemSize){
                $preAmount = $itemSize->amount;
                if($newValue = $preAmount + $value){
                    $itemSize->update([
                        'amount' => $newValue
                    ]);
                }
            }
        }

        foreach($request->colors as $color){
            $item->colors()->attach($color);
        }

        return redirect()->back()->with('success', 'Item created successfully');
    }

    public function toggleBestselling(Item $item){
        $prevState = $item->is_bestseller;
        $item->update([
            'is_bestseller' => !$prevState
        ]);
        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function destroy(Item $item){
        $item->delete();
        return redirect()->back()->with('success', 'Item successfully removed!');
    }


}
