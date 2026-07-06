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
            'shipping_address' => 'required|string',
        ]);

        // Ambil isi keranjang user
        $carts = \App\Models\Cart::where('user_id', $validated['user_id'])->with('product')->get();
        
        // Hitung total harga dengan aman di backend
        $totalAmount = 0;
        foreach ($carts as $cart) {
            if ($cart->product) {
                $totalAmount += $cart->product->price * $cart->quantity;
            }
        }
        $validated['total_amount'] = $totalAmount;

        $order = Order::create($validated);

        // Pindahkan isi cart ke order_items
        foreach ($carts as $cart) {
            if ($cart->product) {
                \App\Models\OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity
                ]);
            }
        }

        return $order;
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return $order->load(['user', 'items.product']);
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

    /**
     * Process payment with Xendit
     */
    public function pay(Order $order)
    {
        \Xendit\Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
        $apiInstance = new \Xendit\Invoice\InvoiceApi();

        $createInvoiceRequest = new \Xendit\Invoice\CreateInvoiceRequest([
            'external_id' => 'ORDER-' . $order->id . '-' . time(),
            'description' => 'Pembayaran Order #' . $order->id,
            'amount' => (int) $order->total_amount,
            'payer_email' => $order->user->email,
            'customer' => [
                'email' => $order->user->email,
                'given_names' => $order->user->name ?? 'Pelanggan',
            ],
            'customer_notification_preference' => [
                'invoice_created' => ['email'],
                'invoice_reminder' => ['email'],
                'invoice_paid' => ['email'],
            ],
            'success_redirect_url' => env('FRONTEND_URL', 'http://localhost:5173') . '/payment-success',
            'failure_redirect_url' => env('FRONTEND_URL', 'http://localhost:5173') . '/payment-failed',
        ]);

        try {
            $result = $apiInstance->createInvoice($createInvoiceRequest);
            
            // Simpan data invoice ke database
            $order->update([
                'status' => 'pending',
                'invoice_url' => $result['invoice_url'],
                'external_id' => $result['external_id'],
            ]);

            return response()->json(['payment_url' => $result['invoice_url']]);
        } catch (\Xendit\XenditSdkException $e) {
            return response()->json(['message' => 'Payment gateway error: ' . $e->getMessage()], 500);
        }
    }
}
