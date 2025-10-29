<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Repositories\Cart\CartRepository;

class EmptyCart
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    public function handle(OrderCreated $event)
    {
        $this->cart->empty();
    }
}
