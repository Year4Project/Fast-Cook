<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Order;

class OrderPlacedEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $order;
    public $restaurantId;

    public function __construct(Order $order, $restaurantId)
    {
        $this->order = $order;
        $this->restaurantId = $restaurantId;

        // Load the 'user' relationship if not already loaded
        if (!$this->order->relationLoaded('user')) {
            $this->order->load('user');
        }
    }

    public function broadcastOn()
    {
        return new Channel('restaurant-channel');
    }

    public function broadcastWith()
    {
        // Check if the order belongs to the specified restaurant
        if ($this->order->restaurant_id == $this->restaurantId) {
            // Get the user information
            $user = $this->order->user;
            
            // Broadcasting data
            return [
                'order' => $this->order,
                'user' => $user,
            ];
        } else {
            // If the order doesn't belong to the specified restaurant, return an empty array to prevent broadcasting
            return [];
        }
    }
}
