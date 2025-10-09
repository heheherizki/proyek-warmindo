<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data input, termasuk file gambar
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        // 2. Proses upload gambar
        if ($request->hasFile('image_url')) {
            // Simpan gambar ke storage/app/public/products dan dapatkan path-nya
            $path = $request->file('image_url')->store('products', 'public');
            $validatedData['image_url'] = $path;
        }

        // 3. Simpan data ke database
        Product::create($validatedData);

        // 4. Kembali ke halaman dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // Laravel akan otomatis mencari produk berdasarkan ID di URL
        return view('products.edit', ['product' => $product]);
    }

    // Method untuk memproses update data
    public function update(Request $request, Product $product)
    {
        // 1. Validasi data input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar bersifat opsional
        ]);

        // 2. Cek apakah ada file gambar baru yang di-upload
        if ($request->hasFile('image_url')) {
            // Hapus gambar lama jika ada (opsional tapi praktik yang baik)
            // Storage::disk('public')->delete($product->image_url);

            // Simpan gambar baru dan update path-nya
            $path = $request->file('image_url')->store('products', 'public');
            $validatedData['image_url'] = $path;
        }

        // 3. Update data produk di database
        $product->update($validatedData);

        // 4. Kembali ke halaman dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // 1. Hapus file gambar dari storage untuk menghemat ruang
        if ($product->image_url) {
            Storage::disk('public')->delete($product->image_url);
        }

        // 2. Hapus data produk dari database
        $product->delete();

        // 3. Kembali ke halaman dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Menu berhasil dihapus!');
    }

    public function index()
    {
        $products = Product::latest()->paginate(10); // Menggunakan paginasi
        return view('products.index', ['products' => $products]);
    }
}
