@props([
    'cartItem'
])

<div class="basis-1 flex py-7 px-3 border-b border-solid border-b-gray-200 gap-3">
    <div class="basis-1/5">
        <img src="#" alt="">
    </div>
    <div class="basis-3/5">
        <div class="flex flex-col gap-3">
            <a href="{{ route('products.show', ['slug' => $cartItem->product->getSlug(), 'product' => $cartItem->product]) }}"><h1 class="text-xl hover:underline">{{ $cartItem->product->name }}</h1></a>
            <p class="text-xs">{{ $cartItem->product->description }}</p>
            <div class="flex items-center gap-2">
                <p class="text-xs font-bold">Quantity:</p>
                <select id="countries" onchange="updateQuantity({{ $cartItem->id }}, this.value)" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @for($i = 1; $i <= 10; $i++)
                        <option @if($i === $cartItem->quantity) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
                <div id="update-{{ $cartItem->id }}" class="cart-item-response text-red-500 text-xs"></div>
            </div>
        </div>
    </div>
    <div class="basis-1/5 flex flex-col text-right justify-between">
        <div>
            <p class="text-base font-light">Price</p>
            <p id="price-{{ $cartItem->id }}" class="text-xl font-medium" data-value="{{ $cartItem->product->price }}">${{ number_format($cartItem->product->price * $cartItem->quantity, 2) }}</p>
        </div>
        <div>
            <form action="{{ route('cart-item.delete', ['cartItem' => $cartItem]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-white text-xs px-3 py-1 bg-red-500 hover:cursor-pointer hover:bg-red-900">Delete</button>
            </form>
        </div>
    </div>
</div>
