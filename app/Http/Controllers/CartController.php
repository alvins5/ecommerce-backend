<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cart::with(['user', 'product.brand', 'product.category'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($validated['quantity'] > $product->stock_quantity) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia',
                'errors' => [
                    'quantity' => ["Stok tersedia hanya {$product->stock_quantity} item."]
                ]
            ], 422);
        }

        $cart = Cart::create($validated);
        return $cart->load(['user', 'product.brand', 'product.category']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return $cart->load(['user', 'product.brand', 'product.category']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
        ]);

        if (isset($validated['quantity'])) {
            $product = $cart->product;

            if ($validated['quantity'] > $product->stock_quantity) {
                return response()->json([
                    'message' => 'Jumlah melebihi stok yang tersedia',
                    'errors' => [
                        'quantity' => ["Stok tersedia hanya {$product->stock_quantity} item."]
                    ]
                ], 422);
            }
        }

        $cart->update($validated);
        return $cart->load(['product.brand', 'product.category']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(['message' => 'Cart item deleted successfully'], 200);
    }
}
