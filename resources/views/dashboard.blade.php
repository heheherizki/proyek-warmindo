<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Pesanan Baru Masuk</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($newOrders as $order)
                            <div class="bg-gray-50 border rounded-lg p-4 flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-lg">#{{ $order->id }}</span>
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">{{ $order->status }}</span>
                                </div>
                                <p class="font-medium">{{ $order->customer_name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                
                                <ul class="text-sm list-disc list-inside my-3 flex-grow">
                                    @foreach ($order->items as $item)
                                        <li>{{ $item->product->name }} <span class="font-semibold">x {{ $item->quantity }}</span></li>
                                    @endforeach
                                </ul>
                                
                                <div class="border-t pt-2 mt-2 flex justify-between items-center">
                                    <span class="font-bold">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>

                                    <div class="flex space-x-2">
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600">Batal</button>
                                        </form>
                                        <form action="{{ route('orders.complete', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">Selesai</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">Tidak ada pesanan baru saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>