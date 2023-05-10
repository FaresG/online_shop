<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaypalController extends Controller
{
    public function createOrder(Request $request)
    {
        $token = $this->getAccessToken();
        $response = Http::withToken($token)
            ->contentType('application/json')
            ->post(env('PAYPAL_API_BASE_URL') . '/v2/checkout/orders?intent=CAPTURE', $request->input('order'));

        return $response->json();
    }

    public function captureOrder($orderID)
    {
        $token = $this->getAccessToken();
        $response = Http::withToken($token)
            ->contentType('application/json')
            ->post(env('PAYPAL_API_BASE_URL') . '/v2/checkout/orders/' . $orderID . '/capture');

    }

    private function getAccessToken() : string
    {
        $response = Http::contentType('application/x-www-form-urlencoded')
            ->withBasicAuth(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'))
            ->withBody('grant_type=client_credentials')
            ->post(env('PAYPAL_API_BASE_URL') . '/v1/oauth2/token');

        return $response->object()->access_token;
    }
}
