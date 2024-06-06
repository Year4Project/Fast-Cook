<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $orderId;
    public $status;

    public function __construct($orderId, $status)
    {
        $this->orderId = $orderId;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('order.' . $this->orderId);
    }

    public function broadcastWith()
    {
        return [
            'status' => $this->status,
        ];
    }
}
