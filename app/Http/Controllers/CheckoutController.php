<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; // <-- PERBAIKAN DI SINI

class CheckoutController extends Controller
{
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

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Kita perlu kolom baru untuk menyimpan QR string
        // Mari kita gunakan ulang qr_code_url (karena tipenya TEXT)
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
            return redirect()->route('checkout.success', $order->id);
        
        } elseif ($request->payment_method === 'qris') {
            
            // --- LOGIKA BARU API PAKASIR ---
            try {
                $slug = config('services.pakasir.slug');
                $apiKey = config('services.pakasir.api_key');
                $orderId = 'WARM-' . $order->id . '-' . Str::random(4);
                $amount = (int)$order->total_amount;

                // 1. Kirim permintaan API ke Pakasir
                $response = Http::post('https://app.pakasir.com/api/transactioncreate/qris', [
                    'project' => $slug,
                    'order_id' => $orderId,
                    'amount' => $amount,
                    'api_key' => $apiKey,
                ]);

                if ($response->failed()) {
                    // Jika API-key salah atau server Pakasir down
                    return redirect()->back()->with('error', 'Gagal terhubung ke gateway pembayaran.');
                }

                $paymentData = $response->json()['payment'];
                
                // 2. Ambil QR String dari respons
                $qrString = $paymentData['payment_number'];

                // 3. Simpan QR String ke database untuk ditampilkan nanti
                $order->qr_code_url = $qrString;
                $order->save();

                session()->forget('cart');
                
                // 4. Arahkan ke halaman "Tunggu Pembayaran" yang BARU
                return redirect()->route('checkout.waiting', $order->id);

            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Metode pembayaran tidak valid.');
    }

    /**
     * Halaman baru untuk menampilkan QR Code
     */
    public function waiting(Order $order)
    {
        // Periksa apakah order memiliki QR string
        if (empty($order->qr_code_url)) {
            return redirect('/cart')->with('error', 'Pesanan tidak valid untuk pembayaran QRIS.');
        }
        return view('checkout-waiting', ['order' => $order]);
    }

    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout-success', ['order' => $order]);
    }

    /**
     * Menerima Webhook dari Pakasir (Otomatis Ubah Status)
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        
        // Cek apakah data order_id ada
        if (empty($data['order_id'])) {
            return response()->json(['status' => 'error', 'message' => 'Order ID tidak ada'], 400);
        }

        // Ambil ID pesanan kita
        $orderId = explode('-', $data['order_id'])[1] ?? null;
        if (!$orderId) {
            // Jika formatnya bukan WARM-XX-XXXX
            $orderId = $data['order_id'];
        }

        $order = Order::find($orderId);

        // Jika pesanan ditemukan dan statusnya "completed"
        if ($order && $data['status'] == 'completed') {
            
            // Verifikasi jumlah
            if ($order->total_amount == $data['amount']) {
                
                // UPDATE STATUS PESANAN
                $order->update([
                    'status' => 'baru', // Sekarang pesanan akan muncul di dashboard
                    'payment_status' => 'paid',
                ]);

                return response()->json(['status' => 'success'], 200);
            }
        }
        return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
    }

    public function checkStatus(Order $order)
    {
        // Cukup periksa status pembayaran dan kirim kembali sebagai JSON
        return response()->json([
            'status' => $order->payment_status // Akan mengirim 'pending' atau 'paid'
        ]);
    }
}