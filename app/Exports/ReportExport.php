<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Product::with('category');

        if (!empty($this->filters['category'])) {
            $query->where('category_id', $this->filters['category']);
        }

        return $query->get();
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->type,
            $product->description,
            '$' . number_format($product->price_sale, 0, ',', '.'),
            '$' . number_format($product->price_purchase, 0, ',', '.'),
            $product->stock,
            $product->brand,
            $product->presentation,
            $product->content,
            optional($product->expiration_date)->format('d/m/Y'),
            $product->barcode,
            optional($product->category)->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Tipo',
            'Descripción',
            'Precio Venta',
            'Precio Compra',
            'Stock',
            'Marca',
            'Presentación',
            'Contenido',
            'Vence',
            'Código de barras',
            'Categoría',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
