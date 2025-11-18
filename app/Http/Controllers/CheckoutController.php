<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Events\NewOrderReceived; // <-- 1. Pastikan Event di-import

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->to('/menu');
        }
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        return view('checkout', ['cart' => $cart, 'total' => $total]);
    }

    /**
     * Memproses dan menyimpan pesanan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->to('/menu');
        }

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
            'customer_name'  => $request->customer_name,
            'total_amount'   => $total,
            'payment_method' => $request->payment_method,
            'status'         => 'menunggu_pembayaran',
            'payment_status' => 'pending',
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id'       => $order->id,
                'product_id'     => $id,
                'quantity'       => $details['quantity'],
                'price_per_item' => $details['price'],
            ]);
        }

        if ($request->payment_method === 'cash') {
            $order->update(['status' => 'baru', 'payment_status' => 'paid']);
            session()->forget('cart');

            // 2. KIRIM EVENT UNTUK PESANAN CASH
            $order->load('items.product'); // Muat relasi sebelum dikirim
            NewOrderReceived::dispatch($order);

            return redirect()->route('checkout.success', $order->id);
        
        } elseif ($request->payment_method === 'qris') {
            try {
                $slug = config('services.pakasir.slug');
                $apiKey = config('services.pakasir.api_key');
                $orderId = 'WARM-' . $order->id . '-' . Str::random(4);
                $amount = (int)$order->total_amount;

                $response = Http::post('https://app.pakasir.com/api/transactioncreate/qris', [
                    'project' => $slug,
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'api_key' => $apiKey,
                ]);

                if ($response->failed()) {
                    return redirect()->back()->with('error', 'Gagal terhubung ke gateway pembayaran.');
                }

                $paymentData = $response->json()['payment'];
                $qrString = $paymentData['payment_number'];
                $order->qr_code_url = $qrString;
                $order->save();

                session()->forget('cart');
                return redirect()->route('checkout.waiting', $order->id);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
    }

    /**
     * Halaman untuk menampilkan QR Code.
     */
    public function waiting(Order $order)
    {
        if (empty($order->qr_code_url)) {
            return redirect('/cart')->with('error', 'Pesanan tidak valid untuk pembayaran QRIS.');
        }
        return view('checkout-waiting', ['order' => $order]);
    }

    /**
     * Halaman konfirmasi sukses.
     */
    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout-success', ['order' => $order]);
    }

    /**
     * Menerima Webhook dari Pakasir (Otomatis Ubah Status).
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        
        if (empty($data['order_id'])) {
            return response()->json(['status' => 'error', 'message' => 'Order ID tidak ada'], 400);
        }

        $orderId = explode('-', $data['order_id'])[1] ?? $data['order_id'];
        $order = Order::find($orderId);

        if ($order && $data['status'] == 'completed' && $order->payment_status == 'pending') {
            
            if ((int)$order->total_amount == (int)$data['amount']) {
                
                $order->update([
                    'status' => 'baru',
                    'payment_status' => 'paid',
                ]);

                // 3. KIRIM EVENT UNTUK PESANAN QRIS
                $order->load('items.product'); // Muat relasi sebelum dikirim
                NewOrderReceived::dispatch($order);

                return response()->json(['status' => 'success'], 200);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
    }
    
    /**
     * Dipanggil oleh JavaScript (polling) untuk mengecek status pembayaran.
     */
    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->payment_status
        ]);
    }
}