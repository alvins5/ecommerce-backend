<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with(['user', 'items'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'shipping_address' => 'required|string',
        ]);

        return Order::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order->load(['user', 'items']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,paid,shipped,delivered,cancelled',
            'total_amount' => 'sometimes|numeric|min:0',
            'shipping_address' => 'sometimes|string',
        ]);

        $order->update($validated);
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }

    /**
     * Get items in an order.
     */
    public function items(Order $order)
    {
        return $order->items()->with('product')->get();
    }

    /**
     * Get orders by user.
     */
    public function userOrders($user)
    {
        return Order::where('user_id', $user)->with(['items'])->get();
    }
}
