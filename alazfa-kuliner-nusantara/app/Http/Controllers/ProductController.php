<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category']);

        if ($request->has('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        $products = $query->paginate(12);
        if ($request->wantsJson()) return response()->json($products);
        return view('products.index', compact('products'));
    }

    public function show(Request $request, $id)
    {
        $product = Product::with(['store', 'category', 'reviews.user'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($product);
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $products = Product::with(['store', 'category'])
            ->where('nama_produk', 'LIKE', "%{$keyword}%")
            ->orWhereHas('store', function($q) use ($keyword) {
                $q->where('nama_toko', 'LIKE', "%{$keyword}%");
            })
            ->paginate(12);

        if ($request->wantsJson()) return response()->json($products);
        return view('products.index', compact('products'));
    }
}
