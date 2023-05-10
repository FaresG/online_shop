<x-layout>
    @error('login')
        <x-flash type="error">
            {{ $message }}
        </x-flash>
    @enderror
        <div class="w-full max-w-xs">
            <form action="{{ route('login') }}" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="mb-4">
                    <x-input type="text" label="Email" name="email" value="{{ old('email') ?: '' }}" placeholder="Your Email" />
                </div>
                <div class="mb-6">
                    <x-input type="password" label="Password" name="password" placeholder="**************" />
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Sign In
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
            <p class="text-center text-gray-500 text-xs">
                &copy;2020 Acme Corp. All rights reserved.
            </p>
        </div>
</x-layout>
