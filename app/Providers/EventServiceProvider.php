<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use App\Listeners\SendOrderCreatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
//        'order.created' => [
//            DeductProductQuantity::class,
//            EmptyCart::class,
//        ],
        OrderCreated::class =>[
            DeductProductQuantity::class,
            //EmptyCart::class,
            SendOrderCreatedNotification::class
        ]
    ];
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }


    public function boot(): void
    {
        //
    }
}
