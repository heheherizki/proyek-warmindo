<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        // Jika keranjang kosong, kembalikan ke halaman menu
        if (empty($cart)) {
            return redirect()->to('/menu');
        }

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('checkout', [
            'cart' => $cart,
            'total' => $total
        ]);
    }


    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        // 2. Ambil data keranjang dari session
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 3. Simpan data ke tabel 'orders'
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'baru', // Status default saat pesanan dibuat
        ]);

        // 4. Simpan setiap item di keranjang ke tabel 'order_items'
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price_per_item' => $details['price'],
            ]);
        }

        // 5. Kosongkan keranjang belanja
        session()->forget('cart');

        // 6. Arahkan ke halaman sukses dengan membawa ID pesanan
        return redirect()->route('checkout.success', $order->id);
    }


    public function success(Order $order)
    {
        // Memuat relasi 'items' dan di dalam setiap 'item', muat juga relasi 'product'
        $order->load('items.product');

        return view('checkout-success', ['order' => $order]);
    }
}
