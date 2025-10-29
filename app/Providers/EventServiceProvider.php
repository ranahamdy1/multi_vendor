<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * هنا تسجل الأحداث والمستمعين
     */
    protected $listen = [
//        'order.created' => [
//            DeductProductQuantity::class,
//            EmptyCart::class,
//        ],
        OrderCreated::class =>[
            DeductProductQuantity::class,
            EmptyCart::class,
        ]
    ];

    /**
     * تفعيل اكتشاف الأحداث التلقائي (اختياري)
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }


    public function boot(): void
    {
        //
    }
}
