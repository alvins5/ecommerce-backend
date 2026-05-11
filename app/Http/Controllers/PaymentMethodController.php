<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentMethods::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255',
        ]);

        return PaymentMethods::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethods $paymentMethod)
    {
        return $paymentMethod;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethods $paymentMethod)
    {
        $validated = $request->validate([
            'method_name' => 'sometimes|string|max:255',
        ]);

        $paymentMethod->update($validated);
        return $paymentMethod;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethods $paymentMethod)
    {
        $paymentMethod->delete();
        return response()->json(['message' => 'Payment method deleted successfully'], 200);
    }
}
