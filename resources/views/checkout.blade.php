@extends('layouts.main-layout', ['title' => 'Checkout'])

    @section('content')

    <div class="container mx-auto px-4 sm:px-6 py-12 min-h-screen">
        <h1 class="text-3xl font-bold text-center mb-8 text-slate-800">Checkout Pesanan</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="w-full lg:w-1/2">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-4">Detail Pemesan</h3>
                        
                        <div class="mt-4">
                            <label for="customer_name" class="block font-medium text-sm text-gray-700">Nama Anda</label>
                            <input id="customer_name" name="customer_name" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required autofocus>
                        </div>

                        <div class="mt-6">
                            <label class="block font-medium text-sm text-gray-700">Metode Pembayaran</label>
                            <div class="mt-2 space-y-2">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500" checked>
                                    <span class="ml-3 text-sm font-medium text-gray-900">Bayar di Kasir (Cash)</span>
                                </label>
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer">
                                    <input type="radio" name="payment_method" value="qris" class="h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <span class="ml-3 text-sm font-medium text-gray-900">QRIS (Akan Datang)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2">
                    <div class="bg-white shadow-lg rounded-lg p-6 lg:sticky lg:top-24">
                        <h3 class="text-lg font-bold mb-4 border-b pb-4">Ringkasan Pesanan</h3>
                        <div class="space-y-3">
                            @foreach($cart as $id => $details)
                                <div class="flex justify-between text-sm">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $details['name'] }}</p>
                                        <p class="text-gray-500">x {{ $details['quantity'] }}</p>
                                    </div>
                                    <p class="text-gray-700">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between items-center font-bold text-xl">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <button type="submit" class="mt-6 w-full text-center block bg-orange-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-600 transition duration-300">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endsection