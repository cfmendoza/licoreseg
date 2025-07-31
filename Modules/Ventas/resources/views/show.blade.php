@extends('layouts.app')

@section('title', 'Factura #'.$sale->id)

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Factura #{{ $sale->id }}</h5>
            <!-- Botón para enviar por correo -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendInvoiceModal">
                <i class="bi bi-envelope-fill"></i> Enviar factura por correo
            </button>

        </div>
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $sale->customer->name ?? '—' }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</p>
            <p><strong>Total:</strong> <span class="fw-bold text-success">${{ number_format($sale->total, 2) }}</span></p>

            <h5 class="mt-4">Productos</h5>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-end">${{ number_format($detail->unit_price, 2) }}</td>
                        <td class="text-end">${{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-4">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="sendInvoiceModal" tabindex="-1" aria-labelledby="sendInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('ventas.send_invoice', $sale->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendInvoiceModalLabel">Enviar Factura</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo del destinatario</label>
                        <input type="email" name="email" class="form-control" required placeholder="cliente@correo.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection