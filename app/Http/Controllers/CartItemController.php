<?php

namespace App\Http\Controllers;

use App\Events\CartUpdated;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $cartItem->quantity = $request->get('quantity');
        $cartItem->save();

        CartUpdated::dispatch($cartItem->cart);

        return response()->json([
            'success' => 'updated!',
            'newPrice' => $cartItem->quantity * $cartItem->product->price,
            'newTotal' => $cartItem->cart->total
        ]);
    }

    public function delete(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cart = Cart::ofCurrentUser($request->user())->first();

        $cartItem->delete();

        CartUpdated::dispatch($cart);

        return back()->with([
            'success' => 'Item is deleted!'
        ]);
    }
}
