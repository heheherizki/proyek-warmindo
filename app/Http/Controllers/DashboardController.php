<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Hanya mengambil pesanan baru
        $newOrders = Order::where('status', 'baru')->latest()->get();

        return view('dashboard', [
            'newOrders' => $newOrders,
        ]);
    }
}
