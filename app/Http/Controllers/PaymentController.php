<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Payments::with('paymentMethod')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,success,failed,refunded',
        ]);

        return Payments::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payments $payment)
    {
        return $payment->load('paymentMethod');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payments $payment)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,success,failed,refunded',
            'amount' => 'sometimes|numeric|min:0',
        ]);

        $payment->update($validated);
        return $payment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payments $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully'], 200);
    }
}
