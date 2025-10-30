<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * The channel to broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('orders'),
        ];
    }

    /**
     * Optional: event name in JS
     */
    public function broadcastAs()
    {
        return 'order.created';
    }
}
