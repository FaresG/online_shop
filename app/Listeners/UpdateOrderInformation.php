<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Http\Services\StripeService;
use App\Models\Order;
use App\Models\User;
use App\Models\UserPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateOrderInformation implements ShouldQueue
{
    public function handle(PaymentCompleted $event): void
    {
        $order = Order::where('ulid', $event->session->metadata->order_id)->firstOrFail();
        $paymentDetails = $order->paymentDetails;
        $paymentDetails->status = $event->session->payment_status;
        $paymentDetails->save();
    }
}
