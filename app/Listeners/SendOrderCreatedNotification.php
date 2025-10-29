<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    public function __construct()
    {
        //
    }

    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        // جلب كل المستخدمين المرتبطين بالمتجر (لو موجودين)
        $users = User::where('store_id', $order->store_id)->get();

        if ($users->isNotEmpty()) {
            // إرسال إشعار جماعي
            Notification::send($users, new OrderCreatedNotification($order));
        } else {
            // 👇 fallback: إرسال الإشعار للمسؤولين أو المستخدم الذي أنشأ الطلب
            if ($order->user) {
                $order->user->notify(new OrderCreatedNotification($order));
            }
        }
    }
}
