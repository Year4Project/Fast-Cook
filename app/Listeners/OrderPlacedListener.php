<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPlacedListener
{
    public function handle(OrderPlacedEvent $event)
    {
        // You can add additional logic here if needed
    }
}
