<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // نعيد ترتيبها بشكل صحيح
        $channels = ['database', 'mail', 'broadcast'];

        // لو المستخدم مفعّل تفضيلات معينة
        if ($notifiable->notification_preferences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if ($notifiable->notification_preferences['order_created']['broadcast'] ?? false) {
            $channels[] = 'broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress()->first();

        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->greeting("Hi {$notifiable->name},")
            ->line("A new order #{$this->order->number} was created by {$addr->name} from {$addr->country_name}.")
            ->action('View Order', url('/dashboard/orders/' . $this->order->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Store notification in the database.
     */
    public function toDatabase(object $notifiable): array
    {
        $addr = $this->order->billingAddress()->first();

        return [
            'body' => "A new order #{$this->order->number} was created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'far fa-bell',
            'url' => url('/dashboard/orders/' . $this->order->id),
            'order_id' => $this->order->id,
        ];
    }

    public function toBroadcast( $notifiable)
    {
        $addr = $this->order->billingAddress()->first();

        return new BroadcastMessage([
            'body' => "A new order #{$this->order->number} was created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'far fa-bell',
            'url' => url('/dashboard/orders/' . $this->order->id),
            'order_id' => $this->order->id,
        ]);
    }
    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
