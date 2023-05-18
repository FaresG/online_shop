<?php

namespace App\Http\Controllers;

use App\Events\PaymentCompleted;
use App\Http\Services\StripeService;
use App\Jobs\ClearCartAfterPurchase;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentDetails;
use App\Models\User;
use App\Notifications\OrderCompleted;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function __construct(
        protected StripeService $service
    )
    {
    }

    public function pay(Request $request, Cart $cart): RedirectResponse
    {
        $session = $this->service->startPayment($request, $cart);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        // Get Stripe session
        $session = $this->service->getSession($request->get('session_id'));
        $order = PaymentDetails::where('payload->stripe_session_id', $session->id)->firstOrFail()->order;


        return view('pages.payment.success', [
            'order' => $order
        ]);
    }

    public function webhook()
    {
        $event = $this->service->webhook();

        // Handle the event
        if ($event->type == 'checkout.session.completed') {
            try {
                $checkoutSession = $event->data->object;
                PaymentCompleted::dispatch($checkoutSession);
Log::info('yoyo');
                if ($checkoutSession instanceof Session) {
                    User::whereRelation('payments', 'account_number', $checkoutSession->customer)->firstOrFail()
                        ->notify(new OrderCompleted(Order::findOrFail($checkoutSession->metadata->order_id)));
                    Log::info('WE RE IN');
                }
            } catch (Exception $e) {
            Log::error($e->getMessage());
            }
        }
        return response('ok', 200);
    }
}
