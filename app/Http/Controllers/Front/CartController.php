<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart;
    public $items;
    public $total;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
        $this->items = $cart->get();
        $this->total = $cart->total();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('front.cart', [
            'cart' => $this->cart,
            'items' => $this->items,
            'total' => $this->total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required','int','exists:products,id'],
            'quantity' => ['nullable','int','min:1'],
        ]);

        $product = Product::find($request->input('product_id'));
        $this->cart->add($product, $request->post('quantity'));

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required','int','min:1'],
        ]);
        $this->cart->update($id, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cart->delete($id);
        return[
            'message' => 'item successfully removed',
        ];
    }
}
