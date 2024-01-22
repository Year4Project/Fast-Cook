<?php

namespace App\Listeners;

use App\Events\NewOrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Redis;

class NotifyRestaurant
{

    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewOrderPlaced $event)
    {
        // Notify the restaurant using any desired method
        // For simplicity, we'll use Redis to store the order information

        Redis::publish('new-order', json_encode($event->order));
    }
}
