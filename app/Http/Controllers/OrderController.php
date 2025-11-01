<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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

// --- LOGIKA BARU UNTUK GRAFIK PENJUALAN 7 HARI TERAKHIR ---
        $salesData = Order::where('status', 'selesai')
            ->where('updated_at', '>=', Carbon::now()->subDays(6)->startOfDay()) // Mulai dari 6 hari lalu
            ->where('updated_at', '<=', Carbon::now()->endOfDay()) // Sampai hari ini
            ->select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format data untuk Chart.js
        // Buat array 7 hari terakhir sebagai label
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            // Cari data penjualan untuk tanggal ini, jika tidak ada, isi 0
            $sale = $salesData->firstWhere('date', $date->format('Y-m-d'));
            $chartData[] = $sale ? $sale->total : 0;
        }        

        return view('reports', [
            'totalSales' => $totalSales,
            'historicalOrders' => $historicalOrders,
            'completedOrderCount' => $completedOrderCount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'statusFilter' => $statusFilter, // Kirim status filter ke view
            'chartLabels' => $chartLabels, // <-- Kirim data baru
            'chartData' => $chartData,     // <-- Kirim data baru
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

    public function invoice(Order $order)
    {
        // Memuat data item dan produk yang terkait dengan pesanan ini
        $order->load('items.product');
        
        return view('invoice', ['order' => $order]);
    }

    public function downloadPDF(Request $request)
    {
        // 1. Ambil data (logika filter SAMA PERSIS seperti method reports)
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();
        $statusFilter = $request->input('status', 'semua');

        $salesQuery = Order::where('status', 'selesai')->whereBetween('updated_at', [$startDate, $endDate]);
        $totalSales = $salesQuery->sum('total_amount');
        $completedOrderCount = $salesQuery->count();

        $historyQuery = Order::whereBetween('updated_at', [$startDate, $endDate]);
        if ($statusFilter && $statusFilter !== 'semua') {
            $historyQuery->where('status', $statusFilter);
        } else {
            $historyQuery->whereIn('status', ['selesai', 'dibatalkan']);
        }

        // PENTING: Gunakan get() bukan paginate() untuk PDF
        $historicalOrders = $historyQuery->latest('updated_at')->get();

        // 2. Siapkan data untuk dikirim ke view PDF
        $data = [
            'totalSales' => $totalSales,
            'historicalOrders' => $historicalOrders,
            'completedOrderCount' => $completedOrderCount,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'statusFilter' => $statusFilter,
        ];

        // 3. Buat PDF
        $pdf = Pdf::loadView('report-pdf', $data);

        // 4. Download file PDF
        $fileName = 'Laporan_WarmindoKu_' . $startDate->format('d-m-Y') . '_sd_' . $endDate->format('d-m-Y') . '.pdf';
        return $pdf->download($fileName);
    }
}
