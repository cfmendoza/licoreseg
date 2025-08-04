<?php

namespace Modules\Reportes\Http\Controllers;

use App\Exports\ProductReportExport;
use App\Exports\ReportExport;
use App\Exports\SalesReportExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'products');
        $categories = Category::all();

        if ($type === 'sales') {
            $sales = $this->filteredSales($request);
            return view('reportes::index', compact('sales', 'categories'));
        } else {
            $products = $this->filteredProducts($request);
            return view('reportes::index', compact('products', 'categories'));
        }
    }

    public function export(Request $request)
    {
        if ($request->get('type') === 'sales') {
            return Excel::download(new SalesReportExport($request->all()), 'reporte-ventas.xlsx');
        }

        return Excel::download(new ProductReportExport($request->all()), 'reporte-inventario.xlsx');
    }


    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'products');

        if ($type === 'sales') {
            $sales = $this->filteredSales($request);
            $pdf = Pdf::loadView('reportes::pdf.sales', compact('sales'));
            return $pdf->download('reporte-ventas.pdf');
        } else {
            $products = $this->filteredProducts($request);
            $pdf = Pdf::loadView('reportes::pdf.products', compact('products'));
            return $pdf->download('reporte-inventario.pdf');
        }
    }

    private function filteredProducts(Request $request)
    {
        return Product::with('category')
            ->when($request->filled('category'), fn($q) => $q->where('category_id', $request->category))
            ->when($request->filled('from'), fn($q) => $q->whereDate('updated_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('updated_at', '<=', $request->to))
            ->when($request->filled('low_stock'), fn($q) => $q->where('stock', '<=', 5)) // stock bajo fijo
            ->get();
    }

    private function filteredSales(Request $request)
    {
        return Sale::with(['customer', 'user'])
            ->when($request->filled('from'), fn($q) => $q->whereDate('date', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('date', '<=', $request->to))
            ->latest()
            ->get();
    }
}
