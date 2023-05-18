<?php

namespace App\Http\Controllers;

use App\Events\CartUpdated;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{

    public function index(Request $request): View
    {
        $cart = Cart::ofCurrentUser($request->user())->with('cartItems', 'cartItems.product')->first();

        return view('pages.cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => $request->user()->id],
            ['user_id' => $request->user()->id, 'total' => 0]);

        // Create a cart item
        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            ['quantity' => $request->get('quantity') ?? 1]
        );

        $cart->cartItems()->save($cartItem);

        CartUpdated::dispatch($cart);

        return back()->with([
            'success' => $product->name .' has been added to the cart'
        ]);
    }
}
