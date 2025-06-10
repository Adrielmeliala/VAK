<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan halaman manajemen produk.
     */
    public function index()
    {
        $products = Product::latest()->get(); // Mengambil semua produk, diurutkan dari yang terbaru
        return view('admin.products', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|url',
        ]);

        // Membuat produk baru
        Product::create($request->all());

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
