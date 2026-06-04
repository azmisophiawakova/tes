<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function getStore() {
        return Auth::user()->stores()->first();
    }

    public function index(Request $request)
    {
        $store = $this->getStore();
        if (!$store) return response()->json(['message' => 'Toko tidak ditemukan'], 404);

        $products = Product::where('id_toko', $store->id_toko)->with('category')->get();
        if ($request->wantsJson()) return response()->json($products);
        return view('penjual.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $store = $this->getStore();
        if (!$store) return response()->json(['message' => 'Toko tidak ditemukan'], 404);

        $request->validate([
            'id_kategori' => 'required|exists:categories,id_kategori',
            'nama_produk' => 'required|string',
            'deskripsi_produk' => 'nullable|string',
            'resep' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto_produk' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['id_toko'] = $store->id_toko;

        if ($request->hasFile('foto_produk')) {
            $data['foto_produk'] = $request->file('foto_produk')->store('products', 'public');
        }

        $product = Product::create($data);
        if ($request->wantsJson()) return response()->json(['message' => 'Produk ditambahkan', 'product' => $product], 201);
        return redirect()->route('penjual.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('id_toko', $this->getStore()->id_toko)->findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:categories,id_kategori',
            'nama_produk' => 'required|string',
            'deskripsi_produk' => 'nullable|string',
            'resep' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto_produk' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('foto_produk')) {
            if ($product->foto_produk) Storage::disk('public')->delete($product->foto_produk);
            $data['foto_produk'] = $request->file('foto_produk')->store('products', 'public');
        }

        $product->update($data);
        if ($request->wantsJson()) return response()->json(['message' => 'Produk diperbarui', 'product' => $product]);
        return redirect()->route('penjual.products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $product = Product::where('id_toko', $this->getStore()->id_toko)->findOrFail($id);
        if ($product->foto_produk) Storage::disk('public')->delete($product->foto_produk);
        $product->delete();

        if ($request->wantsJson()) return response()->json(['message' => 'Produk dihapus']);
        return redirect()->route('penjual.products.index')->with('success', 'Produk dihapus');
    }
}
