<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - WarmindoKu</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style> body { font-family: 'Quicksand', sans-serif; } </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-cream-100 text-slate-800" x-data="menuPage()">

    @include('layouts.public-navigation')

    <main class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold text-center mb-10 text-slate-800">Menu Lengkap Kami</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
            @forelse ($products as $product)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group flex flex-col">
                    <div class="relative">
                        <img src="{{ asset('storage/' . ($product->image_url ?? 'https/via.placeholder.com/300x200.png?text=Gambar+Menu')) }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-40 transition-all duration-300"></div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex-grow">
                            <h3 class="font-bold text-xl mb-2 text-slate-900">{{ $product->name }}</h3>
                            <p class="text-slate-600 text-sm mb-4 h-10">{{ Str::limit($product->description, 50) }}</p>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <span class="font-extrabold text-xl text-orange-500">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            <button type="button" @click="addToCart({{ $product->id }})" class="bg-slate-800 text-white font-semibold py-2 px-4 rounded-lg hover:bg-orange-500 transition-colors duration-300 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" /></svg>
                                <span>Pesan</span>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-500">Maaf, belum ada menu yang tersedia saat ini.</p>
                </div>
            @endforelse

        </div>
    </main>
    
    <div 
        x-show="showToast"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-full"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-full"
        class="fixed top-24 right-5 bg-green-500 text-white py-3 px-5 rounded-lg shadow-lg flex items-center z-50"
        style="display: none;"
    >
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span x-text="toastMessage"></span>
    </div>

    @include('layouts.footer')
    
    <script>
        function menuPage() {
            return {
                showToast: false,
                toastMessage: '',
                addToCart(productId) {
                    fetch(`/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mengirim event 'cart-updated' dengan data baru
                            this.$dispatch('cart-updated', { count: data.cartCount });

                            // Menampilkan notifikasi toast
                            this.toastMessage = data.message;
                            this.showToast = true;
                            setTimeout(() => this.showToast = false, 4000);
                        }
                    });
                }
            }
        }
    </script>
</body>
</html>