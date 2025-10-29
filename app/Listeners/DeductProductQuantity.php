<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event)
    {
        $order = $event->order;

        foreach ($order->products as $product) {
            $qtyToDeduct = $product->order_item->quantity;

            // 👇 تأكد إن المخزون الحالي أكبر من أو يساوي الكمية المطلوبة
            if ($product->quantity >= $qtyToDeduct) {
                $product->decrement('quantity', $qtyToDeduct);
//                Product::where('id','=',$item->product_id)->update([
//                'quantity' => DB::raw("quantity - {$item->quantity}")
//            ]);
            } else {
                // ممكن تسجل Log أو تتصرف لو الكمية غير كافية
                \Log::warning("Product {$product->id} stock too low to deduct {$qtyToDeduct}");
            }
        }
    }
}
