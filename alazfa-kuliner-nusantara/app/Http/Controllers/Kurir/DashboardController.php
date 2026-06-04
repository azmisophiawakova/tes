<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'new_tasks' => Order::where('status_pesanan', 'diproses')->whereNull('id_kurir')->count(),
            'active_deliveries' => Order::where('id_kurir', Auth::id())->whereIn('status_pesanan', ['diambil', 'dikirim'])->count(),
            'completed_deliveries' => Order::where('id_kurir', Auth::id())->where('status_pesanan', 'selesai')->count(),
        ];
        if ($request->wantsJson()) return response()->json($data);
        return view('kurir.dashboard', compact('data'));
    }
}
