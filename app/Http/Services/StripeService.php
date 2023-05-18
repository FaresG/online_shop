<?php

namespace App\Http\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentDetails;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Event;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));
    }

    public function startPayment(Request $request, Cart $cart): Session
    {
        // Get Stripe customer or create it
        if ($userPayment = $request->user()->payments()->where('provider', 'stripe')->first()) {
            $customer = $this->getCustomer($userPayment->account_number);
        }
        else {
            $customer = $this->createCustomer([
                'email' => $request->user()->email
            ]);
            UserPayment::create([
                'user_id' => $request->user()->id,
                'payment_type' => 'credit-card',
                'provider' => 'stripe',
                'account_number' => $customer->id,
            ]);
        }

        // Create Order
        $order = Order::create([
            'total' => $cart->total,
            'user_id' => $cart->user_id,
        ]);

        // Create Stripe Customer
        $session =  $this->createSession([
            'customer' => $customer->id,
            'line_items' =>
                $cart->cartItems->load('product')->map(function (CartItem $cartItem) {
                    return [
                        'price' => $this->getProduct($cartItem->product->stripe_id)->default_price,
                        'quantity' => $cartItem->quantity
                    ];
                })->all(),
            'mode' => 'payment',
            'metadata' => [
                'order_id' => $order->ulid
            ],
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cart.index', ['session_id' => '{CHECKOUT_SESSION_ID}'])
        ]);

        // Create Order Items
        foreach ($cart->cartItems as $cartItem) {
            OrderItems::create([
                'quantity' => $cartItem->quantity,
                'product_id' => $cartItem->product_id,
                'order_id' => $order->id
            ]);
        }

        // Create Payment Details
        PaymentDetails::create([
            'amount' => $order->total,
            'provider' => 'stripe', // TODO: make it dynamic
            'status' => 'pending',
            'payload' => json_encode([
                'stripe_session_id' => $session->id
            ]),
            'order_id' => $order->id
        ]);

        // Delete related Cart Items
        $cart->cartItems()->delete();

        // Reset Cart Total
        $cart->total = 0;
        $cart->save();

        return $session;
    }

    public function webhook(): Event
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $endpoint_secret = env('STRIPE_WEBHOOK_SIGNING_SECRET');
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            echo 'invalid payload';
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            echo 'invalid signature';
            exit();
        }
        return $event;
    }

    public function createSession($array): Session
    {
        return Session::create($array);
    }

    public function getSession($id): Session
    {
        return Session::retrieve($id);
    }

    public function getCustomer($id): Customer
    {
        return Customer::retrieve($id);
    }

    public function createCustomer($array): Customer
    {
        return Customer::create($array);
    }

    public function createProduct($array): Product
    {
        return Product::create($array);
    }

    public function getProduct($id): Product
    {
        return Product::retrieve($id);
    }

    public function createPrice($array): Price
    {
        return Price::create($array);
    }

    public function getPrice($id): Price
    {
        return Price::retrieve($id);
    }

}
