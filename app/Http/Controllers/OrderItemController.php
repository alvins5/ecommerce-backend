<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OrderItems::with(['order', 'product'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return OrderItems::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItems $orderItem)
    {
        return $orderItem->load(['order', 'product']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItems $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:1',
        ]);

        $orderItem->update($validated);
        return $orderItem;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItems $orderItem)
    {
        $orderItem->delete();
        return response()->json(['message' => 'Order item deleted successfully'], 200);
    }
}
