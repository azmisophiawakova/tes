<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::where('id_user', Auth::id())->with('product.store')->get();
        if ($request->wantsJson()) return response()->json($carts);
        return view('cart.index', compact('carts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Cek jika produk sudah ada di keranjang
        $cart = Cart::where('id_user', Auth::id())->where('id_produk', $request->id_produk)->first();
        if ($cart) {
            $cart->update(['jumlah' => $cart->jumlah + $request->jumlah]);
        } else {
            $cart = Cart::create([
                'id_user' => Auth::id(),
                'id_produk' => $request->id_produk,
                'jumlah' => $request->jumlah
            ]);
        }

        if ($request->wantsJson()) return response()->json(['message' => 'Ditambahkan ke keranjang', 'cart' => $cart]);
        return redirect()->back()->with('success', 'Menu ditambahkan ke keranjang');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('id_user', Auth::id())->findOrFail($id);
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $cart->update(['jumlah' => $request->jumlah]);

        if ($request->wantsJson()) return response()->json(['message' => 'Keranjang diperbarui', 'cart' => $cart]);
        return redirect()->back()->with('success', 'Keranjang diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $cart = Cart::where('id_user', Auth::id())->findOrFail($id);
        $cart->delete();

        if ($request->wantsJson()) return response()->json(['message' => 'Menu dihapus dari keranjang']);
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang');
    }
}
