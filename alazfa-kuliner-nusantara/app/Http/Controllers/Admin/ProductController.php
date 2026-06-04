<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['store', 'category'])->get();
        if ($request->wantsJson()) return response()->json($products);
        return view('admin.products.index', compact('products'));
    }

    public function destroy(Request $request, $id)
    {
        Product::findOrFail($id)->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Produk dihapus']);
        return redirect()->back()->with('success', 'Menu berhasil dihapus oleh sistem');
    }
}
