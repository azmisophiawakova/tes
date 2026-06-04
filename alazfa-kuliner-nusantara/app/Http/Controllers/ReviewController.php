<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:products,id_produk',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string'
        ]);

        $review = Review::create([
            'id_user' => Auth::id(),
            'id_produk' => $request->id_produk,
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);

        if ($request->wantsJson()) return response()->json(['message' => 'Ulasan berhasil dikirim', 'review' => $review]);
        return redirect()->back()->with('success', 'Ulasan berhasil dikirim');
    }
}
