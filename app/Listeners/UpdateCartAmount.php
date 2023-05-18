<?php

namespace App\Listeners;

use App\Events\CartUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateCartAmount
{
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
    public function handle(CartUpdated $event): void
    {
        $cart = $event->cart->load('cartItems', 'cartItems.product');
        $total = 0;
        if ($cart->cartItems->isNotEmpty())
        foreach ($cart->cartItems as $cartItem)
        {
            $total += $cartItem->product->price * $cartItem->quantity;
        }
        $cart->total = $total;
        $cart->save();
    }
}
