<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Order, OrderDetail, Cart, Payment};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('id_user', Auth::id())->with(['store', 'orderDetails.product'])->orderBy('created_at', 'desc')->get();
        if ($request->wantsJson()) return response()->json($orders);
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        // Ambil keranjang user
        $carts = Cart::where('id_user', Auth::id())->with('product')->get();
        if ($carts->isEmpty()) {
            if ($request->wantsJson()) return response()->json(['message' => 'Keranjang kosong'], 400);
            return redirect()->back()->with('error', 'Keranjang Anda kosong');
        }

        // Kita kelompokkan pesanan berdasarkan toko (1 pesanan = 1 toko)
        $cartsByStore = $carts->groupBy('product.id_toko');
        $createdOrders = [];

        DB::beginTransaction();
        try {
            foreach ($cartsByStore as $id_toko => $items) {
                $total_harga = $items->sum(function ($item) {
                    return $item->product->harga * $item->jumlah;
                });

                $order = Order::create([
                    'id_user' => Auth::id(),
                    'id_toko' => $id_toko,
                    'total_harga' => $total_harga + 10000, // Misal tambah ongkir statis 10rb
                    'status_pesanan' => 'menunggu',
                    'alamat_pengiriman' => Auth::user()->alamat ?? 'Alamat Belum Diatur'
                ]);

                Payment::create([
                    'id_pesanan' => $order->id_pesanan,
                    'metode_pembayaran' => $request->input('metode_pembayaran', 'COD'),
                    'jumlah_pembayaran' => $order->total_harga,
                    'status_pembayaran' => 'pending'
                ]);

                foreach ($items as $item) {
                    OrderDetail::create([
                        'id_pesanan' => $order->id_pesanan,
                        'id_produk' => $item->id_produk,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->product->harga,
                        'subtotal' => $item->product->harga * $item->jumlah
                    ]);
                }
                $createdOrders[] = $order;
            }
            
            // Kosongkan keranjang setelah checkout
            Cart::where('id_user', Auth::id())->delete();
            DB::commit();

            if ($request->wantsJson()) return response()->json(['message' => 'Checkout berhasil', 'orders' => $createdOrders], 201);
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->wantsJson()) return response()->json(['message' => 'Terjadi kesalahan sistem', 'error' => $e->getMessage()], 500);
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('id_user', Auth::id())->with(['store', 'orderDetails.product', 'kurir'])->findOrFail($id);
        if ($request->wantsJson()) return response()->json($order);
        return view('orders.show', compact('order'));
    }
}

