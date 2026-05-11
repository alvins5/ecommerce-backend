<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Brand::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return Brand::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'brand_name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $brand->update($validated);
        return $brand;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }
}
