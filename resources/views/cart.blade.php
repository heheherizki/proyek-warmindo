<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Keranjang Belanja - WarmindoKu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style> body { font-family: 'Quicksand', sans-serif; } </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function cartData() {
            return {
                cartItems: @json($cart),
                total: '{{ 'Rp ' . number_format($total, 0, ',', '.') }}',
                updateQuantity(id, quantity) {
                    if (quantity < 1) { quantity = 1; this.cartItems[id].quantity = 1; }
                    fetch(`/cart/update/${id}`, {
                        method: 'PATCH',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')},
                        body: JSON.stringify({ quantity: quantity })
                    }).then(response => response.json()).then(data => {
                        if (data.success) { this.total = data.total; }
                    });
                },
                removeItem(id) {
                    fetch(`/cart/remove/${id}`, {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')}
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            const newCartItems = { ...this.cartItems };
                            delete newCartItems[id];
                            this.cartItems = newCartItems;
                            this.total = data.total;
                            const cartCountEl = document.querySelector('#cart-count');
                            if (cartCountEl) {
                                cartCountEl.innerText = data.cartCount;
                                if (data.cartCount === 0) { cartCountEl.classList.add('hidden'); }
                                else { cartCountEl.classList.remove('hidden'); }
                            }
                        }
                    });
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-slate-800">

    @include('layouts.public-navigation')

    <main class="container mx-auto px-4 sm:px-6 py-12 min-h-screen" x-data="cartData()">
        <h1 class="text-3xl font-bold text-center mb-8 text-slate-800">Keranjang Belanja Anda</h1>

        <template x-if="Object.keys(cartItems).length > 0">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3">
                    
                    <div class="hidden md:block bg-white shadow-lg rounded-lg">
                        <table class="w-full">
                            <thead class="border-b">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase">Kuantitas</th>
                                    <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <template x-for="(item, id) in cartItems" :key="id">
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-4">
                                                <img :src="`/storage/${item.image_url}`" :alt="item.name" class="w-20 h-20 object-cover rounded-md">
                                                <p class="font-semibold text-gray-900" x-text="item.name"></p>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 text-sm text-gray-700" x-text="`Rp ${Number(item.price).toLocaleString('id-ID')}`"></td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center">
                                                <div class="flex items-center border rounded-md">
                                                    <button type="button" @click="item.quantity > 1 ? updateQuantity(id, --item.quantity) : null" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                    <input type="number" x-model.number="item.quantity" @change="updateQuantity(id, item.quantity)" class="w-12 text-center border-x focus:ring-0 focus:border-gray-300 p-1" min="1">
                                                    <button type="button" @click="updateQuantity(id, ++item.quantity)" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-1 py-1 text-right font-semibold text-gray-900" x-text="`Rp ${(item.price * item.quantity).toLocaleString('id-ID')}`"></td>
                                        <td class="px-6 py-4 text-center">
                                            <button @click="removeItem(id)" title="Hapus item" class="p-2 rounded-full bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden bg-white shadow-lg rounded-lg divide-y divide-gray-200">
                        <template x-for="(item, id) in cartItems" :key="id">
                            <div class="p-4 flex space-x-4">
                                <div>
                                    <img :src="`/storage/${item.image_url}`" :alt="item.name" class="w-20 h-20 object-cover rounded-md">
                                </div>
                                <div class="flex-grow flex flex-col">
                                    <div class="flex justify-between items-start">
                                        <p class="font-semibold text-gray-900 pr-2" x-text="item.name"></p>
                                        <button @click="removeItem(id)" title="Hapus item" class="text-gray-400 hover:text-red-500 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        </button>
                                    </div>
                                    <div class="flex-grow"></div>
                                    <div class="flex justify-between items-center mt-2">
                                        <div class="flex items-center border rounded-md w-fit">
                                            <button type="button" @click="item.quantity > 1 ? updateQuantity(id, --item.quantity) : null" class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                            <input type="number" x-model.number="item.quantity" @change="updateQuantity(id, item.quantity)" class="w-12 text-center border-x focus:ring-0 focus:border-gray-300 p-1" min="1">
                                            <button type="button" @click="updateQuantity(id, ++item.quantity)" class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                        </div>
                                        <span class="font-semibold text-gray-900" x-text="`Rp ${(item.price * item.quantity).toLocaleString('id-ID')}`"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white shadow-lg rounded-lg p-6 lg:sticky lg:top-24">
                        <h3 class="text-lg font-bold mb-4 border-b pb-4">Ringkasan Pesanan</h3>
                        <div class="space-y-2 mt-4">
                           <div class="flex justify-between">
                               <span>Subtotal</span>
                               <span x-text="total"></span>
                           </div>
                           <div class="flex justify-between text-gray-500 text-sm">
                               <span>Pajak & Layanan</span>
                               <span>Rp 0</span>
                           </div>
                        </div>
                        <div class="border-t mt-4 pt-4">
                            <div class="flex justify-between items-center font-bold text-xl">
                                <span>Total</span>
                                <span x-text="total"></span>
                            </div>
                        </div>
                        <a href="{{ url('/checkout') }}" class="mt-6 w-full text-center block bg-orange-500 text-white font-semibold py-3 px-6 rounded-lg hover:bg-orange-600 transition duration-300">
                            Lanjut ke Checkout
                        </a>
                        <div class="text-center mt-4">
                            <a href="{{ url('/menu') }}" class="text-orange-500 hover:text-orange-700 font-semibold text-sm">&larr; Kembali Belanja</a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        
        <template x-if="Object.keys(cartItems).length === 0">
            <div class="text-center bg-white shadow-lg rounded-lg p-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang Anda masih kosong</h3>
                <p class="mt-1 text-sm text-gray-500">Ayo, lihat menu dan tambahkan item favoritmu!</p>
                <div class="mt-6">
                    <a href="{{ url('/menu') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600">Mulai Belanja</a>
                </div>
            </div>
        </template>
    </main>
    
    @include('layouts.footer')
</body>
</html>