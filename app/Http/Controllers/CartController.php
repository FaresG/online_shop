<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        protected CartRepository $repository
    )
    {
    }

    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => $request->user()->id,
            'status' => 'new'
        ])->with(['cartItems', 'cartItems.article'])->first();

        return view('pages.cart.index', [
            'cart' => $cart,
            'cartAmount' => $this->repository->amount()
        ]);
    }

    public function add(Request $request, Article $article)
    {
        $cart = Cart::where('user_id', $request->user()->id)->firstOrFail();

        $cartItemQueryBuilder = CartItem::where('cart_id', $cart->id)->where('article_id', $article->id);
        if ($cartItemQueryBuilder->exists())
        {
            $cartItem = $cartItemQueryBuilder->firstOrFail();
            $cartItem->quantity++;
        }
        else {
            $cartItem = new CartItem;
            $cartItem->cart_id = $cart->id;
            $cartItem->article_id = $article->id;
            $cartItem->quantity = 1;
        }
        $cartItem->save();

        return back()->with('success', 'Item added to your cart');
    }
}
