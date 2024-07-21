<header class="flex justify-between h-10 border-solid border-b border-gray-300 p-1 ">
    <div class="left-side flex">
        <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer @if (Route::is('home')) bg-slate-300 @endif">
            <a class="px-3" href="{{ route('home') }}">Home</a>
        </div>
        <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer @if (Route::is('products.index')) bg-slate-300 @endif">
            <a class="px-3"  href="{{ route('products.index') }}">Products</a>
        </div>
        <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer @if (Route::is('orders.index')) bg-slate-300 @endif">
            <a class="px-3"  href="{{ route('orders.index') }}">My Orders</a>
        </div>
    </div>
    <div class="right-side flex">
        @auth
            <div class="py-1 mr-1 flex items-center">
                <p class="text-xs">Hi {{ auth()->user()->name }}!</p>
            </div>
            <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer">
                <a class="px-3"  href="{{ route('logout') }}">Logout</a>
            </div>
            <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer @if (Route::is('cart.index')) bg-slate-300 @endif">
                <a class="px-3"  href="{{ route('cart.index') }}">My Cart ({{ $cartCount }})</a>
            </div>
        @endauth

        @guest
            <div class="py-1 mr-1 hover:bg-slate-300 hover:cursor-pointer">
                <a class="px-3"  href="{{ route('login') }}">Login</a>
            </div>
        @endguest
    </div>
</header>
