<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckOutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            // يمكنك إضافة التحقق من البيانات هنا حسب الحاجة
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction();

        try {
            foreach ($items as $store_id => $cart_items) {
                // إنشاء الطلب (Order)
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                // إنشاء تفاصيل الطلب (Order Items)
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                }

                // إضافة العنوان
                if ($request->has('addr')) {
                    foreach ($request->post('addr') as $type => $address) {
                        $address['type'] = $type;
                        $order->addresses()->create($address);
                    }
                }

                // ✅ إرسال الحدث بعد إنشاء كل Order
                event(new OrderCreated($order));
            }

            // تفريغ السلة
            $cart->empty();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('home')->with('success', 'تم إنشاء الطلب بنجاح');
    }
}
