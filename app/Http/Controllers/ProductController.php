<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil nilai filter dari URL, defaultnya adalah 'all'
        $statusFilter = $request->input('status', 'all');

        $query = Product::query();

        // 2. Terapkan kondisi berdasarkan filter
        if ($statusFilter == 'active') {
            // 'active' adalah default, jadi tidak perlu query khusus
        } elseif ($statusFilter == 'deleted') {
            $query->onlyTrashed(); // Hanya ambil yang di-soft delete
        } else {
            $query->withTrashed(); // Ambil semua (aktif dan terhapus)
        }

        // 3. Ambil data setelah difilter, urutkan, dan paginasi
        $products = $query->latest()->paginate(10);

        // 4. Kirim data dan status filter ke view
        return view('products.index', [
            'products' => $products,
            'statusFilter' => $statusFilter,
        ]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean', // Validasi untuk checkbox
        ]);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validatedData['image_url'] = $path;
        }
        
        // Menangani input checkbox
        $validatedData['is_featured'] = $request->has('is_featured');

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'nullable|boolean', // Validasi untuk checkbox
        ]);

        if ($request->hasFile('image_url')) {
            // Hapus gambar lama jika ada
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            // Simpan gambar baru
            $path = $request->file('image_url')->store('products', 'public');
            $validatedData['image_url'] = $path;
        }

        // Menangani input checkbox
        $validatedData['is_featured'] = $request->has('is_featured');

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleAvailability(Product $product)
    {
        // Ubah nilai boolean (jika true -> false, jika false -> true)
        $product->is_available = !$product->is_available;
        $product->save();

        $status = $product->is_available ? 'Tersedia' : 'Habis';
        return redirect()->route('products.index')->with('success', "Status '{$product->name}' diubah menjadi {$status}!");
    }
}