<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::with('user')->get();
        if ($request->wantsJson()) return response()->json($stores);
        return view('admin.stores.index', compact('stores'));
    }

    public function verify(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $store->update(['status_verifikasi' => $request->input('status', 'disetujui')]);
        if ($request->wantsJson()) return response()->json(['message' => 'Toko diverifikasi', 'store' => $store]);
        return redirect()->back()->with('success', 'Status toko diperbarui');
    }
}
