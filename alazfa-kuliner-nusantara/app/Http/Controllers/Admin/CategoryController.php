<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        if ($request->wantsJson()) return response()->json($categories);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string', 'deskripsi' => 'nullable|string']);
        $category = Category::create($request->all());
        if ($request->wantsJson()) return response()->json(['message' => 'Kategori dibuat', 'category' => $category]);
        return redirect()->back()->with('success', 'Kategori ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate(['nama_kategori' => 'required|string', 'deskripsi' => 'nullable|string']);
        $category->update($request->all());
        if ($request->wantsJson()) return response()->json(['message' => 'Kategori diperbarui', 'category' => $category]);
        return redirect()->back()->with('success', 'Kategori diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        Category::findOrFail($id)->delete();
        if ($request->wantsJson()) return response()->json(['message' => 'Kategori dihapus']);
        return redirect()->back()->with('success', 'Kategori dihapus');
    }
}
