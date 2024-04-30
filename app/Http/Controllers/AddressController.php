<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validatedData = $this->getValidatedData($request);
        
        $this->unmainAddresses($request);
        
        $request->user()->addresses()->create([
            ...$validatedData,
            'is_main' => true,
        ]);

        return redirect()->back()->with('success', 'Address has been added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Address $address)
    {
        $validatedData = $this->getValidatedData($request);
        
        $this->unmainAddresses($request);

        $request->user()->addresses()->create([
            ...$validatedData,
            'main' => true,
        ]);
        // if ($address->orders()->exists()){
        //     $address->forceDelete();    
        // } else
        $address->delete();
        // }

        return redirect()->back()->with('success', 'Address has been updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->back()->with('success', 'Address has been deleted!');
    }

    private function getValidatedData(Request $request){
        return $request->validate([
            'name' => 'required:min:3',
            'surname' => 'required:min:3',
            'address' => 'required:min:3',
            'post_code' => 'required:min:3',
            'city' => 'required:min:3',
            'phone_number' => 'required:min:9|integer',
        ]);
    }

    private function unmainAddresses(Request $request){
        $request->user()->addresses()->where('is_main', true)->get()->each(function ($address) {
            $address->update(['is_main' => false]);
        });
    }
}
