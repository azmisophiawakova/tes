<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monitoring;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Assuming Monitoring is used for system logs/reports. Or we create a Report model later.
        $reports = Monitoring::with('user')->get();
        if ($request->wantsJson()) return response()->json($reports);
        return view('admin.reports.index', compact('reports'));
    }

    public function resolve(Request $request, $id)
    {
        // Logic to mark a report as resolved
        if ($request->wantsJson()) return response()->json(['message' => 'Laporan diselesaikan']);
        return redirect()->back()->with('success', 'Laporan telah diselesaikan');
    }
}
