<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Store, Product, Order};
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->stores()->first();
        if (!$store) {
            if ($request->wantsJson()) return response()->json(['message' => 'Anda belum memiliki toko'], 404);
            return redirect()->route('penjual.store.index')->with('warning', 'Silakan lengkapi data toko Anda terlebih dahulu');
        }

        $data = [
            'store' => $store,
            'total_products' => Product::where('id_toko', $store->id_toko)->count(),
            'total_orders' => Order::where('id_toko', $store->id_toko)->count(),
            'pending_orders' => Order::where('id_toko', $store->id_toko)->where('status_pesanan', 'menunggu')->count(),
        ];

        if ($request->wantsJson()) return response()->json($data);
        return view('penjual.dashboard', compact('data'));
    }
}
