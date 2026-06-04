<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private function getStore() {
        return Auth::user()->stores()->first();
    }

    public function index(Request $request)
    {
        $orders = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product'])->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('penjual.orders.index', compact('orders'));
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product', 'payment'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($order);
        return view('penjual.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->findOrFail($id);
        $request->validate(['status_pesanan' => 'required|in:menunggu,diproses,dikirim,selesai,dibatalkan']);
        $order->update(['status_pesanan' => $request->status_pesanan]);

        if ($request->wantsJson()) return response()->json(['message' => 'Status pesanan diperbarui', 'order' => $order]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui');
    }

    public function printReceipt(Request $request, $id)
    {
        $order = Order::where('id_toko', $this->getStore()->id_toko)->with(['user', 'orderDetails.product', 'payment'])->findOrFail($id);
        // Usually returns a view styled for printing or PDF
        return view('penjual.orders.receipt', compact('order'));
    }
}
