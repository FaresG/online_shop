<?php

namespace App\View\Composers;

use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        if (auth()->check()) {
            $currentUser = auth()->user();
            $cart = Cart::firstOrCreate(
                ['user_id' => $currentUser->id],
                ['user_id' => $currentUser->id, 'total' => 0]);
            $view->with('cartCount', $cart->cartItems->count());
        }

    }
}
