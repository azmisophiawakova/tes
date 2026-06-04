<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Store};

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Tampilkan produk terbaru atau unggulan
        $featured_products = Product::with(['store', 'category'])->latest()->take(6)->get();
        if ($request->wantsJson()) return response()->json($featured_products);
        return view('home', compact('featured_products'));
    }

    public function sellers(Request $request)
    {
        // Tampilkan daftar UMKM yang sudah diverifikasi
        $sellers = Store::where('status_verifikasi', 'disetujui')->with('user')->get();
        if ($request->wantsJson()) return response()->json($sellers);
        return view('sellers.index', compact('sellers'));
    }

    public function pelangganDashboard(Request $request)
    {
        $featured_products = Product::with(['store', 'category'])->latest()->take(6)->get();
        if ($request->wantsJson()) return response()->json($featured_products);
        return view('pelanggan.dashboard', compact('featured_products'));
    }
}
