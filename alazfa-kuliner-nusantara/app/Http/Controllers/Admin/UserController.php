<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        if ($request->wantsJson()) return response()->json($users);
        return view('admin.users.index', compact('users'));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status_akun' => $request->input('status_akun', 'aktif')]);
        if ($request->wantsJson()) return response()->json(['message' => 'Status akun diperbarui', 'user' => $user]);
        return redirect()->back()->with('success', 'Status akun diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Akun dihapus']);
        return redirect()->back()->with('success', 'Akun dihapus');
    }
}
