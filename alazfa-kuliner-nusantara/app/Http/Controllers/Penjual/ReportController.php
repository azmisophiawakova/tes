<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->stores()->first();
        if (!$store) return response()->json(['message' => 'Toko tidak ditemukan'], 404);

        // Get total sales completed
        $total_sales = Order::where('id_toko', $store->id_toko)
                            ->where('status_pesanan', 'selesai')
                            ->sum('total_harga');

        $data = [
            'total_sales' => $total_sales,
            'orders_completed' => Order::where('id_toko', $store->id_toko)->where('status_pesanan', 'selesai')->count(),
        ];

        if ($request->wantsJson()) return response()->json($data);
        return view('penjual.reports.index', compact('data'));
    }
}
