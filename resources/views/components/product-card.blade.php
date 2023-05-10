@props([
    'product',
])

<div class="flex flex-col border border-solid p-2 m-2">
    <img src="https://via.placeholder.com/640x480.png/00ee11?text=rerum" alt="" class="h-20">
    <p class="text-base">{{ $product->name }}</p>
{{--    <div class="rating">--}}
{{--        <div class="flex">--}}
{{--            <i class="fa fa-solid fa-star text-amber-400" style="font-size: 7px;"></i>--}}
{{--            <i class="fa fa-solid fa-star text-amber-400" style="font-size: 7px;"></i>--}}
{{--            <i class="fa fa-solid fa-star text-amber-400" style="font-size: 7px;"></i>--}}
{{--            <i class="fa fa-solid fa-star text-amber-400" style="font-size: 7px;"></i>--}}
{{--            <i class="fa fa-solid fa-star text-amber-400" style="font-size: 7px;"></i>--}}
{{--        </div>--}}
{{--        <p class="text-xs">{{ $product->views }}</p>--}}
{{--    </div>--}}
    <a href="{{ route('products.show', ['slug' => $product->getSlug(), 'product' => $product]) }}" class="text-xs border border-solid p-2 text-center bg-amber-800 text-white">View</a>
{{--    <a class="text-xs border border-solid p-2 text-center bg-amber-800 text-white" onclick="addToCart('{{ route('cart-item.store', ['product' => $product]) }}')">Add to Cart</a>--}}
</div>

<script>
    function addToCart(url) {
        event.preventDefault()
        $.post({
            url: url,
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function (data) {
                toastr.info(data.message, 'Item added to cart!')
            },
        })
    }
</script>
