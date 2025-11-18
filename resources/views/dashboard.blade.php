<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pesanan') }}
        </h2>
    </x-slot>

    <div 
        class="py-12" 
        x-data="{ 
            newOrders: @js($newOrders),
            audioUnlocked: false, 
            
            listenForOrders() {
                if (window.Echo) {
                    window.Echo.private('orders.new')
                        .listen('.order.created', (e) => {
                            console.log('Event diterima:', e.order);
                            this.newOrders.unshift(e.order);
                            this.attemptToPlaySound();
                        });
                } else {
                    console.error('Laravel Echo tidak dimuat. Pastikan `npm run dev` berjalan.');
                }
            },

            attemptToPlaySound() {
                if (!this.audioUnlocked) {
                    console.warn('Audio terkunci. Menunggu interaksi pengguna.');
                    return; 
                }
                try {
                    this.$refs.audio.currentTime = 0; 
                    this.$refs.audio.play();
                } catch(err) {
                    console.error('Gagal memutar audio:', err);
                }
            },

            unlockAudio() {
                if (this.audioUnlocked) return; // Hanya jalankan sekali
                this.audioUnlocked = true;
                this.$refs.audio.play().catch(e => {}); 
                console.log('Notifikasi suara telah diaktifkan oleh pengguna.');
            }
        }"
        x-init="listenForOrders()"
        @click.window.once="unlockAudio()"
    >
        <audio x-ref="audio" src="{{ asset('sounds/notification.mp3') }}" preload="auto"></audio>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div x-show="!audioUnlocked" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg mb-6" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="w-6 h-6 text-yellow-600 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.017 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0M6.128 15a3 3 0 1 0-5.714 0" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <p class="font-bold">Aktifkan Suara Notifikasi</p>
                        <p class="text-sm">Browser memblokir suara otomatis. Klik di mana saja untuk mengizinkan notifikasi suara.</p>
                    </div>
                    <button @click="unlockAudio()" class="ml-auto bg-green-500 text-white font-semibold py-1 px-3 rounded-lg hover:bg-green-600 flex-shrink-0">
                        Aktifkan
                    </button>
                </div>
            </div>

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
                        <template x-for="order in newOrders" :key="order.id">
                            <div class="bg-gray-50 border rounded-lg p-4 flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-lg" x-text="`#${order.id}`"></span>
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full" x-text="order.status"></span>
                                </div>
                                <p class="font-medium" x-text="order.customer_name"></p>
                                <p class="text-sm text-gray-500" x-text="new Date(order.created_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })"></p>
                                
                                <ul class="text-sm list-disc list-inside my-3 flex-grow">
                                    <template x-for="item in order.items" :key="item.id">
                                        <li x-text="`${item.product.name} x ${item.quantity}`"></li>
                                    </template>
                                </ul>
                                
                                <div class="border-t pt-2 mt-2 flex justify-between items-center">
                                    <span class="font-bold" x-text="`Total: Rp ${Number(order.total_amount).toLocaleString('id-ID')}`"></span>
                                    <div class="flex space-x-2">
                                        <a :href="`/orders/${order.id}/invoice`" target="_blank" class="text-sm bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">Cetak</a>
                                        
                                        <form :action="`/orders/${order.id}/cancel`" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm bg-gray-500 text-white px-3 py-1 rounded-md hover:bg-gray-600">Batal</button>
                                        </form>
                                        <form :action="`/orders/${order.id}/complete`" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm bg-green-500 text-white px-3 py-1 rounded-md hover:bg-green-600">Selesai</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="newOrders.length === 0" class="col-span-full">
                            <p class="text-gray-500">Tidak ada pesanan baru saat ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>