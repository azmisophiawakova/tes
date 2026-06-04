<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $favorites = Favorite::where('id_user', Auth::id())->with('product.store')->get();
        if ($request->wantsJson()) return response()->json($favorites);
        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate(['id_produk' => 'required|exists:products,id_produk']);
        $favorite = Favorite::firstOrCreate([
            'id_user' => Auth::id(),
            'id_produk' => $request->id_produk
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Ditambahkan ke favorit', 'favorite' => $favorite]);
        return redirect()->back()->with('success', 'Ditambahkan ke favorit');
    }

    public function destroy(Request $request, $id)
    {
        $favorite = Favorite::where('id_user', Auth::id())->findOrFail($id);
        $favorite->delete();

        if ($request->wantsJson()) return response()->json(['message' => 'Dihapus dari favorit']);
        return redirect()->back()->with('success', 'Dihapus dari favorit');
    }
}
