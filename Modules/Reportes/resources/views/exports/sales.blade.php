<table>
    <thead>
        <tr>
            <th>Factura #</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Usuario</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>Total Venta</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            @foreach ($sale->details as $detail)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->customer->name ?? '—' }}</td>
                    <td>{{ $sale->user->name ?? '—' }}</td>
                    <td>{{ $detail->product->name ?? '—' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->unit_price, 0) }}</td>
                    <td>{{ number_format($detail->subtotal, 0) }}</td>
                    <td>{{ number_format($sale->total, 0) }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
