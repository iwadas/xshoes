<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['category', 'brands', 'colors', 'sizes']);
        $selectedCategory = Category::find($filters['category'] ?? null);

        $items = Item::with(['brands', 'colors', 'available_sizes'])
            ->with(['categories' =>  fn($query)=>$query->orderBy('categories.id')])
            ->with('images', fn($query)=>$query->where('main', true))
            ->categoryFilter($filters['category'] ?? 0);
    
        $itemsId = $items->pluck('id');

        $sizes = Size::whereHas('items', fn($query)=>$query->whereIn('items.id', $itemsId))
            ->withCount(
                [
                    'available_items' => fn($query)=>$query->whereIn('items.id', $itemsId)->filter($filters, 'sizes')
                ])
            ->get();

        $brands = Brand::whereHas('items', fn($query)=>$query->whereIn('items.id', $itemsId))
            ->withCount(
                [
                    'items' => fn($query)=>$query->whereIn('items.id', $itemsId)->filter($filters, 'brands')
                ])
            ->orderBy('items_count', 'desc')
            ->get();

        $colors = Color::whereHas('items', fn($query)=>$query->whereIn('items.id', $itemsId))
            ->withCount(
                [
                    'items' => fn($query)=>$query->whereIn('items.id', $itemsId)->filter($filters, 'colors')
                ])
            ->orderBy('items_count', 'desc')
            ->get();

        $items = $items->filter($filters)->paginate(12)->withQueryString();

        return inertia('Store/Index', [
            'chosenCategories' => $this->getChosenCategories($selectedCategory), 
            'subCategories' =>  $this->getSubCategories($selectedCategory),
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'items' => $items,
            'filters' => $filters
        ]);
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
    public function show(Request $request, Item $item)
    {
        return inertia('Store/Show', [
            'item' => $item->load('images', 'brands', 'sizes', 'colors')
                ->load(['categories' =>  fn($query)=>$query->orderBy('categories.id')]),
            'selectedSize' => (int) $request->selectedSize
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
    public function update(){

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function getChosenCategories(Category $category = null){
        $result = [];
        if($category) {
            do{
                array_unshift($result, $category);
            }
            while($category = $category->parent()->first());
        }
        return $result;
    }

    private function getSubCategories(Category $category = null){
        if(!$category){
            return Category::whereDoesntHave('parent')->withCount('items')->with('children', fn($query)=>$query->withCount('items')->with('children', fn($query)=>$query->withCount('items')))->get();
        }
        $childrenCategories = $category->children()->withCount('items')->with('children', fn($query)=>$query->withCount('items'))->get();
        if($childrenCategories->isEmpty()){
            return null;
        } else {
            return $childrenCategories;
        }
    }
}
