<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .danger { background-color: #ffe5e5; }
    </style>
</head>
<body>
    <h2>Reporte de Inventario</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Actualizado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $i => $p)
                <tr class="{{ $p->stock <= 5 ? 'danger' : '' }}">
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? '—' }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>${{ number_format($p->price_sale, 0) }}</td>
                    <td>{{ $p->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
