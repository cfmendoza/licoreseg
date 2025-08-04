<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de Inventario</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px;
        }

        h1, h4 {
            color: #222;
            margin-bottom: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th, .table td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .low-stock {
            background-color: #ffeaea;
            color: #a94442;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 40px;
            color: #888;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Inventario</h1>
        <p>Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Stock Mínimo</th>
                <th>Precio Venta</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $p)
                <tr class="{{ $p->stock <= $p->min_stock ? 'low-stock' : '' }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>{{ $p->min_stock }}</td>
                    <td>${{ number_format($p->price_sale, 0) }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->updated_at)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999;">No hay productos para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        {{ env('BUSINESS_NAME', 'Licores El Gato') }} — Sistema de Inventario y Facturación
    </div>

</body>
</html>
