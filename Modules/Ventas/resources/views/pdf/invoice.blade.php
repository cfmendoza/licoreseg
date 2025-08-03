<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura #{{ $sale->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        h1, h2, h4 {
            margin-bottom: 5px;
            color: #222;
        }

        p {
            margin: 2px 0;
        }

        .business-info, .customer-info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    {{-- Información del negocio --}}
    <div class="business-info">
        <h1>{{ env('BUSINESS_NAME') }}</h1>
        <p><strong>NIT:</strong> {{ env('BUSINESS_NIT') }}</p>
        <p><strong>Representante Legal:</strong> {{ env('BUSINESS_OWNER') }}</p>
        <p><strong>Teléfono:</strong> {{ env('BUSINESS_PHONE') }}</p>
        <p><strong>Dirección:</strong> {{ env('BUSINESS_ADDRESS') }}</p>
    </div>

    {{-- Información de la factura --}}
    <h2>Factura #{{ $sale->id }}</h2>
    <div class="customer-info">
        <p><strong>Cliente:</strong> {{ $sale->customer->name ?? '—' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</p>
    </div>

    {{-- Detalle de productos --}}
    <h4>Detalle de productos</h4>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>${{ number_format($detail->unit_price, 2) }}</td>
                    <td>${{ number_format($detail->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Total: ${{ number_format($sale->total, 2) }}</p>
</body>
</html>
