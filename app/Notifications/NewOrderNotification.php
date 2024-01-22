<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Order; // Import the Order model

class NewOrderNotification extends Notification
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'order_id' => $this->order->id,
            // Add any other data you want to broadcast
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            // Add any other data you want to include in the array
        ];
    }

    // The `via` method specifying the channels
    public function via($notifiable)
    {
        return ['broadcast']; // Broadcasting is just an example, add other channels as needed
    }
}
