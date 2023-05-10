<?php

namespace App\Http\Services;

use App\Repositories\CartRepository;
use Stripe\Checkout\Session;
use Stripe\Event;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeService
{
    public function __construct(
        protected CartRepository $cartRepository
    )
    {
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY'));
    }

    public function startPayment(): Session
    {
        return Session::create([
            'line_items' => [
                $this->cartRepository->getStripeItemList()
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('cart.index')
        ]);
    }

    public function webhook(): Event
    {

// This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SIGNING_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        return $event;
    }

}
