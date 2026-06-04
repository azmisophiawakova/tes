<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Store, Product, Order};

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
        ];
        if ($request->wantsJson()) return response()->json($data);
        return view('admin.dashboard', compact('data'));
    }
}
