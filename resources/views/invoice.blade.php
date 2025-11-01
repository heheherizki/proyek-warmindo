<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            #print-button { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 flex justify-center p-4">
    <div class="w-full max-w-xs bg-white shadow-md p-6 font-mono text-sm">
        <h1 class="text-xl font-bold text-center mb-2">WarmindoKu</h1>
        <p class="text-center text-xs">Jl. Kenangan Indah No. 123</p>
        <hr class="my-3 border-dashed">
        
        <div class="flex justify-between">
            <span>No. Pesanan:</span>
            <span>#{{ $order->id }}</span>
        </div>
        <div class="flex justify-between">
            <span>Tanggal:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex justify-between mb-3">
            <span>Pelanggan:</span>
            <span>{{ $order->customer_name }}</span>
        </div>

        <hr class="my-3 border-dashed">
        
        @foreach($order->items as $item)
        <div class="mb-1">
            <p class="font-semibold">{{ $item->product->name }}</p>
            <div class="flex justify-between">
                <span>{{ $item->quantity }} x Rp {{ number_format($item->price_per_item, 0, ',', '.') }}</span>
                <span>Rp {{ number_format($item->price_per_item * $item->quantity, 0, ',', '.') }}</span>
            </div>
        </div>
        @endforeach
        
        <hr class="my-3 border-dashed">

        <div class="flex justify-between font-bold">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-xs">
            <span>Metode Bayar</span>
            <span>{{ ucfirst($order->payment_method) }}</span>
        </div>

        <p class="text-center text-xs mt-6">Terima kasih atas pesanan Anda!</p>
        
        <button id="print-button" onclick="window.print()" class="w-full mt-4 bg-blue-500 text-white py-2 rounded">
            Cetak Struk
        </button>
    </div>
</body>
</html>