<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductReportExport implements FromView
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $products = Product::with('category')
            ->when($this->filters['category'] ?? false, fn($q) => $q->where('category_id', $this->filters['category']))
            ->when($this->filters['from'] ?? false, fn($q) => $q->whereDate('updated_at', '>=', $this->filters['from']))
            ->when($this->filters['to'] ?? false, fn($q) => $q->whereDate('updated_at', '<=', $this->filters['to']))
            ->when($this->filters['low_stock'] ?? false, fn($q) => $q->where('stock', '<=', 5))
            ->get();

        return view('reportes::exports.products', compact('products'));
    }
}
