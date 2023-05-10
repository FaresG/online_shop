<?php

namespace App\Http\Controllers;

use App\Events\PaymentCompleted;
use App\Http\Services\StripeService;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StripeController extends Controller
{
    public function __construct(
        protected StripeService $service
    )
    {
    }

    public function pay(): RedirectResponse
    {
        $session = $this->service->startPayment();

        return redirect($session->url);
    }

    public function success()
    {
        return view('pages.payment.success', [
            'message' => 'success'
        ]);
    }

    public function webhook(): Response
    {
        $event = $this->service->webhook();

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
            case 'checkout.session.completed':
                PaymentCompleted::dispatch($event);

            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response();
    }
}
