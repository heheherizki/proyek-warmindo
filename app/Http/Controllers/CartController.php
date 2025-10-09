<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function add(Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image_url" => $product->image_url
            ];
        }

        session()->put('cart', $cart);

        // Kembalikan response JSON, bukan redirect
        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan!',
            'cartCount' => count($cart)
        ]);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        // dd($cart); // <-- Tambahkan ini untuk tes debug
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('cart', [
            'cart' => $cart,
            'total' => $total
        ]);
    }


    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if($request->quantity && $request->quantity > 0 && isset($cart[$product->id])) {
            $cart[$product->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            // Hitung total baru
            $total = 0;
            foreach ($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }

            // Kembalikan response JSON
            return response()->json([
                'success' => true,
                'total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'subtotal' => 'Rp ' . number_format($cart[$product->id]['price'] * $cart[$product->id]['quantity'], 0, ',', '.')
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);

            // Hitung total baru
            $total = 0;
            foreach ($cart as $details) {
                $total += $details['price'] * $details['quantity'];
            }
            
            // Kembalikan response JSON
            return response()->json([
                'success' => true,
                'total' => 'Rp ' . number_format($total, 0, ',', '.'),
                'cartCount' => count($cart)
            ]);
        }

        return response()->json(['success' => false], 404);
    }
}