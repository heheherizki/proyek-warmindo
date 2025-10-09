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
        // Tentukan tanggal awal dan akhir, dengan menambahkan startOfDay() dan endOfDay()
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Buat query dasar untuk pesanan yang selesai
        $query = Order::where('status', 'selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate]);

        // Hitung total pendapatan berdasarkan query yang sudah difilter
        $totalSales = $query->sum('total_amount');
        
        // Ambil daftar pesanan berdasarkan query yang sudah difilter, lalu paginasi
        // Kita perlu membuat klon dari query agar tidak terpengaruh oleh sum()
        $completedOrders = $query->clone()->latest()->paginate(15);

        return view('reports', [
            'totalSales' => $totalSales,
            'completedOrders' => $completedOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
