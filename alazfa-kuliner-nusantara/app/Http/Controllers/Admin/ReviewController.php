<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['user', 'product'])->get();
        if ($request->wantsJson()) return response()->json($reviews);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Request $request, $id)
    {
        Review::findOrFail($id)->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Ulasan dihapus']);
        return redirect()->back()->with('success', 'Ulasan dihapus');
    }
}
