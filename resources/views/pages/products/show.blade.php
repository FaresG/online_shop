<x-layout>
    <div class="flex mt-5 gap-4">
        <div class="basis-4/5 flex gap-4">
            <div class="basis-1/2 px-1">
                <img src="{{ $product->thumbnail }}" alt="">
            </div>
            <div class="flex flex-col">
                <h1 class="text-3xl mb-5">{{ $product->title }}</h1>
                <p class="text-xs">{{ $product->description }}</p>
            </div>
        </div>
        <div class="basis-1/5 flex flex-col gap-3">
            <form class="text-white bg-amber-400 px-3 py-1" action="{{ route('cart.add', ['product' => $product]) }}" method="POST">
                @csrf
                <button class="">Add to Cart</button>
            </form>
            <a class="text-white bg-amber-400 px-3 py-1">Buy now!</a>
        </div>
    </div>
</x-layout>
