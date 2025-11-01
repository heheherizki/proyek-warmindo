<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 100%; margin: 0 auto; padding: 20px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-3xl { font-size: 1.875rem; }
        .text-xl { font-size: 1.25rem; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .text-gray-800 { color: #2d3748; }
        .text-gray-600 { color: #718096; }
        .text-gray-500 { color: #a0aec0; }
        .text-green-600 { color: #38a169; }
        .text-red-800 { color: #9b2c2c; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-green-100 { background-color: #f0fdf4; }
        .bg-red-100 { background-color: #fef2f2; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mt-4 { margin-top: 1rem; }
        .grid { display: grid; }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .gap-4 { gap: 1rem; }
        .w-full { width: 100%; }
        .min-w-full { min-width: 100%; }
        .border-collapse { border-collapse: collapse; }
        .border-b { border-bottom-width: 1px; }
        .border { border-width: 1px; border-color: #e2e8f0; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-6">
            {{-- Ganti dengan path logo Anda --}}
            {{-- <img src="{{ public_path('images/logo-warmindo.png') }}" alt="Logo" style="width: 80px; margin: 0 auto 1rem auto;"> --}}
            <h1 class="text-3xl font-bold text-gray-800">Laporan Penjualan WarmindoKu</h1>
            <p class="text-gray-600">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        </div>

        <div class="mt-8">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="border p-4 rounded-lg">
                    <p class="text-gray-600">Total Pesanan Selesai</p>
                    <p class="text-xl font-bold">{{ $completedOrderCount }}</p>
                </div>
                <div class="border p-4 rounded-lg">
                    <p class="text-gray-600">Total Pendapatan</p>
                    <p class="text-xl font-bold text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                </div>
            </div>
            
            <table class="min-w-full w-full border-collapse border text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-2 px-4 border-b">No. Pesanan</th>
                        <th class="py-2 px-4 border-b">Nama Pelanggan</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Pembayaran</th>
                        <th class="py-2 px-4 border-b text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historicalOrders as $order)
                        <tr>
                            <td class="py-2 px-4 border-b">#{{ $order->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->customer_name }}</td>
                            <td class="py-2 px-4 border-b">{{ $order->updated_at->format('d M Y, H:i') }}</td>
                            <td class="py-2 px-4 border-b">
                                @if ($order->status == 'selesai')
                                    <span style="color: green;">Selesai</span>
                                @elseif ($order->status == 'dibatalkan')
                                    <span style="color: red;">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">{{ ucfirst($order->payment_method) }}</td>
                            <td class="py-2 px-4 border-b text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-2 px-4 border-b text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center text-sm">
            <p class="text-gray-500">Laporan ini dibuat otomatis oleh Sistem WarmindoKu.</p>
        </div>
    </div>
</body>
</html>