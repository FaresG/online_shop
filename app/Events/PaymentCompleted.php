<?php

namespace App\Events;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Stripe\Checkout\Session;

class PaymentCompleted
{
    use Dispatchable;

    public function __construct(
        public Session $session
    )
    {}
}
