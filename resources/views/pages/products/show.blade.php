<x-layout>
    <div class="flex mt-5 gap-4">
        <div class="basis-4/5 flex gap-4">
            <div class="basis-1/2 px-1">
                <img src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8c25lYWtlcnxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60" alt="">
            </div>
            <div class="flex flex-col">
                <h1 class="text-3xl mb-5">{{ $product->title }}</h1>
                <p class="text-xs">{{ $product->description }}</p>
                <p class="text-normal self-end">${{ $product->price }}</p>
            </div>
        </div>
        <div class="basis-1/5 flex flex-col gap-3">
            <form action="{{ route('cart.add', ['product' => $product]) }}" method="POST">
                @csrf
                <x-input type="text" label="Quantity" name="quantity" value="1" />
                <button class="text-white bg-amber-400 px-3 py-1 w-full" >Add to Cart</button>
            </form>
            <a class="text-white bg-amber-400 px-3 py-1">Buy now!</a>
        </div>
    </div>
</x-layout>
