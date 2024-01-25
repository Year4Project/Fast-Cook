<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Alert;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderPlacedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;

        // Load the 'user' relationship if not already loaded
        if (!$this->order->relationLoaded('user')) {
            $this->order->load('user');
        }

        // Save the alert to the database
        Alert::create([
            'message' => "New order placed by {$this->order->user->first_name} {$this->order->user->last_name}",
        ]);
    }
}
