<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'store', 'kurir'])->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = Order::with(['orderDetails.product', 'user', 'store', 'kurir', 'payment', 'verification'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($order);
        return view('admin.orders.show', compact('order'));
    }
}
