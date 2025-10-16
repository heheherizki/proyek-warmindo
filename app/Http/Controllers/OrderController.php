<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
        public function complete(Order $order)
    {
        // Ubah status pesanan menjadi 'selesai'
        $order->status = 'selesai';
        $order->save();

        // Kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Pesanan #' . $order->id . ' ditandai selesai!');
    }

    public function reports(Request $request)
    {
        // Ambil input dari filter, atau gunakan nilai default
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        $statusFilter = $request->input('status', 'semua'); // Defaultnya 'semua'

        // Query untuk MENGHITUNG PENDAPATAN (selalu hanya yang statusnya 'selesai')
        $salesQuery = Order::where('status', 'selesai')
                        ->whereBetween('updated_at', [$startDate, $endDate]);

        $totalSales = $salesQuery->sum('total_amount');
        $completedOrderCount = $salesQuery->count();
        
        // Query untuk MENAMPILKAN RIWAYAT (bisa difilter)
        $historyQuery = Order::whereBetween('updated_at', [$startDate, $endDate]);

        if ($statusFilter && $statusFilter !== 'semua') {
            // Jika status spesifik dipilih, filter berdasarkan status itu
            $historyQuery->where('status', $statusFilter);
        } else {
            // Jika 'semua' atau tidak ada filter, tampilkan yang selesai dan dibatalkan
            $historyQuery->whereIn('status', ['selesai', 'dibatalkan']);
        }

        $historicalOrders = $historyQuery->latest('updated_at')->paginate(15);

        return view('reports', [
            'totalSales' => $totalSales,
            'historicalOrders' => $historicalOrders,
            'completedOrderCount' => $completedOrderCount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'statusFilter' => $statusFilter, // Kirim status filter ke view
        ]);
    }    

    public function cancel(Order $order)
    {
        // Hanya izinkan pembatalan jika statusnya 'baru'
        if ($order->status == 'baru') {
            $order->status = 'dibatalkan';
            $order->save();
            return redirect()->route('dashboard')->with('success', 'Pesanan #' . $order->id . ' berhasil dibatalkan.');
        }
        return redirect()->route('dashboard')->with('error', 'Pesanan ini tidak bisa dibatalkan.');
    }
}
