<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::ofLoggedInUser()->orderBy('created_at', 'desc')->with(['paymentDetails', 'orderItems', 'orderItems.product'])->paginate(5);
        return view('pages.orders.index', [
            'orders' => $orders
        ]);
    }
}
