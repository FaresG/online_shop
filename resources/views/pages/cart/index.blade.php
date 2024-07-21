<x-layout>
    @if(isset($cart) and $cart->cartItems->isEmpty())
        <h1 class="text-xl mt-5">You cart is empty, go shop <a href="{{ route('products.index') }}" class="text-blue-500">here</a></h1>
    @else
        <div class="flex justify-between items-center">
            <h1 class="text-3xl my-3">Shopping Cart</h1>
            <a href="{{ route('stripe.pay', ['cart' => $cart]) }}" class="px-4 py-1 bg-amber-500 text-black text-xs">Proceed to checkout ($<span id="total-amount" class="">{{ $cart->total }}</span>)</a>
        </div>
        <div class="flex flex-col border border-solid border-gray-200 px-5">
            @foreach($cart->cartItems as $cartItem)
                <x-product-cart-item :cartItem="$cartItem"/>
            @endforeach
        </div>
    @endif
</x-layout>

<script>
    function updateQuantity(cartItemId, quantity)
    {
        $('.cart-item-response').html('');

        $.post("/cart-item/" + cartItemId, {
            '_token': "{{ csrf_token() }}",
            'quantity': quantity
        }).done(function(data) {
            console.log('cart item quantity updated!')
            $('#update-' + cartItemId).html('<p class="text-xs text-red">'+ data['success'] +'</p>')

            // Update item price
            $('#price-' + cartItemId).html('$' + data['newPrice'])

            // Update Cart price
            $('#total-amount').html(data['newTotal'])


        })
    }
</script>
