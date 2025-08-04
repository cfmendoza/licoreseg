<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesReportExport implements FromView
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $sales = Sale::with(['customer', 'user', 'details.product'])
            ->when(!empty($this->filters['from']), fn($q) => $q->whereDate('date', '>=', $this->filters['from']))
            ->when(!empty($this->filters['to']), fn($q) => $q->whereDate('date', '<=', $this->filters['to']))
            ->orderByDesc('date')
            ->get();

        return view('reportes::exports.sales', compact('sales'));
    }
}
