<x-layout>
    <div class="mt-10 not-prose relative bg-slate-50 rounded-xl overflow-hidden dark:bg-slate-800/25 border-gray-200 border">
        <div class="relative rounded-xl overflow-auto">
            <div class="shadow-sm overflow-hidden my-8">
                @if(empty($orders))
                    <h2>You Have no orders.</h2>
                @else
                    <table class="table-auto border-collapse w-full text-sm">
                        <thead>
                        <tr>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Order ID</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Date</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Product Name</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Payment Status</th>
                            <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">Value</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800">
                            @foreach($orders as $order)
                                <tr>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $order->ulid }}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $order->created_at->format('d-m-Y') }}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                                        @foreach($order->orderItems as $orderItem)
                                            <p><a href="{{ route('products.show', ['slug' => $orderItem->product->getSlug(), 'product' => $orderItem->product]) }}" target="_blank">{{ $orderItem->product->name }}</a></p>
                                        @endforeach
                                    </td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $order->paymentDetails->status }}</td>
                                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">${{ $order->total }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="m-3">
            {{ $orders->links() }}
        </div>
    </div>
</x-layout>
