<x-layout>
    <div class="flex justify-between items-center">
        <h1 class="text-3xl my-3">Shopping Cart</h1>
        <a href="{{ route('stripe.pay') }}" class="px-4 py-1 bg-amber-500 text-black text-xs">Proceed to checkout ($<span id="total-amount" class="">{{ $cartAmount }}</span>)</a>
    </div>
    <div class="flex flex-col border border-solid border-gray-200 px-5">
        @if($cart->cartItems->isNotEmpty())
            @foreach($cart->cartItems as $cartItem)
                <x-article-cart-item :cartItem="$cartItem"/>
            @endforeach
        @endif
    </div>
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

            // Update price
            $price = $('#price-' + cartItemId);
            $price.html('$' + data['newPrice'])
        })
    }
</script>
