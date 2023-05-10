<?php

namespace App\Interfaces;

use App\Models\CartItem;
use Illuminate\Http\Request;

interface CartItemRepositoryInterface
{
    public function updateQuantity(Request $request, CartItem $cartItem): CartItem;
}
