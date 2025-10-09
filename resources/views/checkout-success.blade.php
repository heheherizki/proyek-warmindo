@extends('layouts.main-layout', ['title' => 'Pesanan Berhasil'])

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-12 min-h-screen">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-lg text-center">
        
        <div class="mx-auto mt-6 flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-slate-800 mt-6">Pesanan Berhasil Dibuat!</h1>
        <p class="text-gray-600 mt-2">Terima kasih, <span class="font-semibold">{{ $order->customer_name }}</span>. Pesanan Anda akan segera kami siapkan.</p>
        
        <div class="text-left bg-gray-50 p-6 rounded-lg mt-8 border divide-y divide-gray-200">
            <div class="flex justify-between items-center pb-3">
                <span class="text-gray-500">Nomor Pesanan</span>
                <span class="font-semibold">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <span class="text-gray-500">Metode Pembayaran</span>
                <span class="font-semibold">{{ ucfirst($order->payment_method) }}</span>
            </div>
            
            <div class="pt-4">
                <h4 class="font-semibold mb-2">Rincian Item:</h4>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
                                <p class="text-gray-500">x {{ $item->quantity }}</p>
                            </div>
                            <p class="text-gray-700">Rp {{ number_format($item->price_per_item * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center font-bold text-lg pt-4">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <a href="{{ url('/menu') }}" class="mt-8 inline-block w-full bg-orange-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-600 transition duration-300">
            Pesan Lagi
        </a>
    </div>
</div>
@endsection