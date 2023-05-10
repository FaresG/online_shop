<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Repositories\CartItemRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{

    public function __construct(
        protected CartItemRepository $repository
    )
    {
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $cartItem = $this->repository->updateQuantity($request, $cartItem);

        return response()->json([
            'success' => 'updated!',
            'newPrice' => number_format($cartItem->article->price * $cartItem->quantity, 2)
        ]);
    }

    public function delete(CartItem $cartItem): RedirectResponse
    {
        $cartItem->delete();

        return back()->with([
            'success' => 'Item removed from cart!'
        ]);
    }
}
