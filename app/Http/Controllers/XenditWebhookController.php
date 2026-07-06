<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Validasi Token Callback
        $xCallbackToken = $request->header('x-callback-token');
        if ($xCallbackToken !== env('XENDIT_CALLBACK_TOKEN')) {
            return response()->json(['message' => 'Invalid token'], 403);
        }

        // 2. Ambil data
        $externalId = $request->external_id; 
        $status = $request->status;

        // 3. Cari Order beserta relasi items, product, dan user
        $order = Order::with(['items.product', 'user'])->where('external_id', $externalId)->first();
        
        if ($order) {
            if ($status === 'PAID' || $status === 'SETTLED') {
                if ($order->status !== 'paid') {
                    $productIds = [];
                    // Kurangi stok untuk setiap item di order
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->decrement('stock_quantity', $item->quantity);
                            $productIds[] = $item->product_id;
                        }
                    }

                    // Hapus item dari cart user
                    if (!empty($productIds)) {
                        \App\Models\Cart::where('user_id', $order->user_id)
                            ->whereIn('product_id', $productIds)
                            ->delete();
                    }

                    $order->update([
                        'status' => 'paid'
                    ]);
                }
            } elseif ($status === 'EXPIRED') {
                if ($order->status !== 'paid') {
                    $order->update([
                        'status' => 'cancelled'
                    ]);
                }
            }
        }

        return response()->json(['message' => 'Success']);
    }
}
