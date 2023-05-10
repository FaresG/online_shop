<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{
    public function count(): int
    {
        return $this->getCart()->cartItems->count();
    }

    public function amount(): float
    {
        $amount = 0;
        $cartItems = $this->getCart()->cartItems;
        foreach ($cartItems as $cartItem)
        {
            $amount += ($cartItem->article->price * $cartItem->quantity);
        }
        return $amount;
    }

    public function getStripeItemList(): array
    {
        $itemList = [];
        foreach($this->getCart()->cartItems as $cartItem)
        {
            $itemList[] = [
                'price_data' => [
                    'currency' => 'USD',
                    'product_data' => [
                        'name' => $cartItem->article->title
                    ],
                    'unit_amount' => $cartItem->article->price * 100
                ],
                'quantity' => $cartItem->quantity
            ];
        }
        return ($itemList);
    }

    public function getCart(): Cart
    {
        return Cart::where('user_id', Auth::user()->id)->with(['cartItems', 'cartItems.article'])->firstOrFail();
    }
}
