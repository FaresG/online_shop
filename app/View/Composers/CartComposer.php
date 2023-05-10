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
        if (auth()->check())
        $view->with('cartCount', Cart::where('user_id', auth()->user()->id)->firstOrFail()->cartItems->count());
    }
}
