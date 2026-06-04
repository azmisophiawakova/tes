<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PelangganRegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register-pelanggan');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string'],
            'umur' => ['required', 'integer', 'min:12'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => 'pelanggan',
            'status_akun' => 'aktif',
        ]);

        event(new Registered($user));
        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
