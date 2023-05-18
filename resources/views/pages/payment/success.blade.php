@props([
    '$order'
])

<x-layout>
    <p>Thanks for placing your order.<br> Order ID: <a href="{{route('orders.index')}}">{{ $order->ulid }}</a></p>
</x-layout>
