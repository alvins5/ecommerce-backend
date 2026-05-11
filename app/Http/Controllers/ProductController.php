<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image_url' => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        return Product::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product->load(['category', 'brand']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'brand_id' => 'sometimes|exists:brands,id',
            'image_url' => 'sometimes|string',
            'stock_quantity' => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    /**
     * Get products by brand.
     */
    public function byBrand($brand)
    {
        return Product::where('brand_id', $brand)->with(['category', 'brand'])->get();
    }
}
