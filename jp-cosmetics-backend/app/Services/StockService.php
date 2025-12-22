<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Reduce stock based on an order's details.
     * Throws exception if stock is insufficient.
     */
    public function reduceStockByOrderId(int $orderId): void
    {
        DB::transaction(function () use ($orderId) {

            $order = Order::with('details:id,order_id,product_attribute_id,quantity')
                ->findOrFail($orderId);

            foreach ($order->details as $detail) {

                if (!$detail->product_attribute_id) {
                    continue;
                }

                $attr = ProductAttribute::where('id', $detail->product_attribute_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$attr) {
                    throw new \Exception("Product attribute not found: {$detail->product_attribute_id}");
                }

                if ($attr->stock < $detail->quantity) {
                    throw new \Exception("Insufficient stock for attribute {$attr->id}. Available: {$attr->stock}, Needed: {$detail->quantity}");
                }

                $attr->decrement('stock', $detail->quantity);
            }
        });
    }
}
