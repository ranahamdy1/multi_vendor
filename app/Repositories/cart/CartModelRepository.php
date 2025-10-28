<?php

namespace App\Repositories\Cart;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartModelRepository implements CartRepository
{
    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }
        return $this->items;
    }
    public function add(Product $product, $quantity = 1)
    {
        $item =  Cart::where('product_id', '=', $product->id)
            // ->where('cookie_id','=',$this->getCookieId())
            ->first();

        if (!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
                'cookie_id' => Cart::getCookieId(),
            ]);
            $this->get()->push($cart);
            return $cart;
        }
        return $item->increment('quantity', $quantity);
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            // -> where('cookie_id','=',$this->getCookieId())
            ->update([
                'quantity' => $quantity,
            ]);

    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)->delete();
        // where('cookie_id','=',$this->getCookieId())
    }

    public function empty()
    {
        Cart::query()->delete();
        // Cart::where('cookie_id','=',$this->getCookieId())->delete();
    }

    public function total(): float
    {

        /*return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
        ->selectRaw('SUM(products.price * carts.quantity) as total')->value('total');*/

        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
