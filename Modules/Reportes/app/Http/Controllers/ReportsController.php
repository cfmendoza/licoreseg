<?php

namespace Modules\Reportes\Http\Controllers;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('from')) {
            $query->whereDate('updated_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('updated_at', '<=', $request->to);
        }

        $products = $query->get();
        $categories = Category::all();

        return view('reportes::index', compact('products', 'categories'));
    }

    public function export(Request $request)
    {
        return Excel::download(new ReportExport($request->all()), 'reporte-inventario.xlsx');
    }
}
