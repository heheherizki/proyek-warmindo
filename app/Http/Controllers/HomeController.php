<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
        {
            $featuredProducts = Product::find([1, 2, 3, 4]);
            
            return view('home', ['featuredProducts' => $featuredProducts]);
        }
}
