<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->stores()->first();
        if ($request->wantsJson()) return response()->json($store);
        return view('penjual.store.index', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->stores()->first();
        $request->validate([
            'nama_toko' => 'required|string',
            'alamat_toko' => 'required|string',
            'jam_buka' => 'nullable|string',
            'jam_tutup' => 'nullable|string',
            'deskripsi_toko' => 'nullable|string'
        ]);

        if ($store) {
            $store->update($request->all());
        } else {
            $data = $request->all();
            $data['id_user'] = Auth::id();
            $data['status_verifikasi'] = 'menunggu konfirmasi';
            $store = Store::create($data);
        }

        if ($request->wantsJson()) return response()->json(['message' => 'Profil toko diperbarui', 'store' => $store]);
        return redirect()->route('penjual.store.index')->with('success', 'Profil diperbarui');
    }
}
