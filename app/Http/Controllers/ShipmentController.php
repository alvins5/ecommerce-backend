<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Shipment::with('order')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'tracking_number' => 'required|string|unique:shipments',
            'courier' => 'required|string',
            'shipped_date' => 'required|date',
        ]);

        return Shipment::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return $shipment->load('order');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'courier' => 'sometimes|string',
            'shipped_date' => 'sometimes|date',
        ]);

        $shipment->update($validated);
        return $shipment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return response()->json(['message' => 'Shipment deleted successfully'], 200);
    }
}
