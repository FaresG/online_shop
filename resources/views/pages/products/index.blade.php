<x-layout>
    <div class="flex flex-wrap basis-2/6">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>

    <div class="text-center">
        {{ $products->links() }}
    </div>
</x-layout>
