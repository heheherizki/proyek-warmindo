<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('orders.reports') }}" class="flex flex-col md:flex-row items-center gap-4">
                        <div>
                            <label for="start_date" class="text-sm font-medium">Dari Tanggal:</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="end_date" class="text-sm font-medium">Sampai Tanggal:</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm">
                        </div>
                        
                        <div>
                            <label for="status" class="text-sm font-medium">Status:</label>
                            <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm">
                                <option value="semua" {{ $statusFilter == 'semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="selesai" {{ $statusFilter == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $statusFilter == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Filter</button>
                    </form>
                </div>
            </div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold">Total Pesanan Selesai</h3>
                        {{-- Menggunakan variabel baru --}}
                        <p class="text-3xl font-bold mt-2">{{ $completedOrderCount }}</p>
                        <p class="text-sm text-gray-500">Dalam rentang tanggal terpilih</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold">Total Pendapatan</h3>
                        <p class="text-3xl font-bold mt-2 text-green-600">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Hanya dari pesanan selesai</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Pesanan ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th> {{-- Kolom Baru --}}
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($historicalOrders as $order)
                                    {{-- Beri efek pudar jika pesanan dibatalkan --}}
                                    <tr class="{{ $order->status == 'dibatalkan' ? 'bg-gray-50' : '' }}">
                                        <td class="px-6 py-4 font-medium">#{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->customer_name }}</td>
                                        <td class="px-6 py-4">{{ $order->updated_at->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            {{-- Badge Status dengan Warna --}}
                                            @if ($order->status == 'selesai')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Selesai
                                                </span>
                                            @elseif ($order->status == 'dibatalkan')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right font-semibold {{ $order->status == 'dibatalkan' ? 'text-gray-400 line-through' : '' }}">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-10 text-gray-500">Tidak ada riwayat pesanan pada rentang tanggal ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $historicalOrders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>