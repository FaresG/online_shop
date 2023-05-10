<?php

namespace App\Repositories;

use App\Interfaces\CartItemRepositoryInterface;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemRepository implements CartItemRepositoryInterface
{
    public function updateQuantity(Request $request, CartItem $cartItem): CartItem
    {
        $cartItem->quantity = $request->get('quantity');
        $cartItem->save();

        return $cartItem;
    }
}
