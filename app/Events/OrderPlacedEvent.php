<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPlacedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;

        // Load the 'user' relationship if not already loaded
        if (!$this->order->relationLoaded('user')) {
            $this->order->load('user');
        }
    }

    public function broadcastOn()
    {
        return new Channel('restaurant-dashboard');
    }

    public function broadcastWith()
    {
        // Get the user information
        $user = $this->order->user;

        // Broadcasting data
        return [
            'order' => $this->order,
            'user' => $user,

        ];
    }
}
