<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PenjualRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register-penjual');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Data Pribadi
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string'],
            'umur' => ['required', 'integer', 'min:18'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            
            // Data Toko
            'nama_toko' => ['required', 'string', 'max:100'],
            'alamat_toko' => ['required', 'string'],
            'deskripsi_toko' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'umur' => $request->umur,
                'jenis_kelamin' => $request->jenis_kelamin,
                'role' => 'penjual',
                'status_akun' => 'aktif',
            ]);

            Store::create([
                'id_user' => $user->id,
                'nama_toko' => $request->nama_toko,
                'alamat_toko' => $request->alamat_toko,
                'deskripsi_toko' => $request->deskripsi_toko,
                'status_verifikasi' => 'menunggu konfirmasi',
            ]);

            DB::commit();
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }
}
