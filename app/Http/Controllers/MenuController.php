<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
        {
            // Ambil semua data produk dari database
            $products = Product::all();

            // Kirim data tersebut ke sebuah view bernama 'menu'
            return view('menu', ['products' => $products]);
        }
}
