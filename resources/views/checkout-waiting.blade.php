@extends('layouts.main-layout', ['title' => 'Tunggu Pembayaran'])

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-12" 
     x-data="{
        status: 'pending',
        init() {
            let interval = setInterval(() => {
                
                // --- PERBAIKAN DI SINI ---
                // Tambahkan parameter acak untuk cache-busting
                let cacheBuster = new Date().getTime();
                let url = '{{ route('checkout.status', $order) }}' + '?t=' + cacheBuster;

                fetch(url)
                // --- AKHIR PERBAIKAN ---
                    .then(response => response.json())
                    .then(data => {
                        this.status = data.status;

                        if (data.status === 'paid') {
                            clearInterval(interval);
                            this.status = 'paid';
                            setTimeout(() => {
                                window.location.href = '{{ route('checkout.success', $order) }}';
                            }, 2000);
                        }
                    });
            }, 3000); 
        }
     }"
     x-init="init()"
>
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-2xl font-bold text-slate-800 mt-4">Selesaikan Pembayaran Anda</h1>
        <p class="text-gray-600 mt-2">Pindai kode QR di bawah ini menggunakan e-wallet Anda (GoPay, OVO, ShopeePay, dll) untuk membayar.</p>
        
        <div class="my-6 p-4 border rounded-lg inline-block">
            {!! QrCode::size(250)->generate($order->qr_code_url) !!}
        </div>

        <div class="text-left bg-gray-50 p-4 rounded-lg border">
            <div class="flex justify-between">
                <span>Nama Pemesan:</span>
                <span class="font-semibold">{{ $order->customer_name }}</span>
            </div>
            <div class="flex justify-between font-bold text-lg mt-2">
                <span>Total Pembayaran:</span>
                <span class="text-orange-500">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-6">
            <template x-if="status === 'pending'">
                <p class="text-sm text-gray-500 flex items-center justify-center">
                    <svg class="w-5 h-5 inline-block animate-spin mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Menunggu konfirmasi pembayaran...
                </p>
            </template>
            <template x-if="status === 'paid'">
                <p class="text-sm text-green-600 font-semibold flex items-center justify-center">
                    <svg class="w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Pembayaran Berhasil! Mengalihkan...
                </p>
            </template>
        </div>
        <p class="text-xs text-gray-400 mt-2">Status akan ter-update otomatis setelah Anda bayar.</p>
    </div>
</div>
@endsection