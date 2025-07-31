@extends('layouts.app')

@section('title', 'Ventas | ' . config('app.name'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-primary">Gestión de Ventas</h1>

    {{-- Mensajes --}}
    @if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Formulario de venta --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Registrar Venta</h5>
            <button type="button" id="add-product" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Agregar Producto
            </button>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="sale-form">
                @csrf

                {{-- Cliente --}}
                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <div class="d-flex">
                        <select id="cliente_id" name="cliente_id" class="form-select me-2" required>
                            <option value="" disabled selected>Seleccione un cliente</option>
                            {{-- Opciones dinámicas --}}
                        </select>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#customerModal">
                            <i class="bi bi-plus-circle"></i>
                        </button>
                    </div>
                </div>

                {{-- Productos --}}
                <div id="product-section"></div>

                {{-- Total --}}
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <div>
                        <label for="total" class="form-label fw-bold">Total:</label>
                        <input type="text" id="total" name="total" class="form-control text-end fw-bold" readonly value="0">
                    </div>
                </div>

                {{-- Botón submit --}}
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Registrar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de ventas --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Ventas Registradas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle m-0" id="table-register-details">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer->name ?? '—' }}</td>
                            <td>
                                @foreach ($sale->details as $detail)
                                    {{ $detail->product->name }} ({{ $detail->quantity }})<br>
                                @endforeach
                            </td>
                            <td>${{ number_format($sale->total, 2) }}</td>
                            <td>{{ $sale->date }}</td>
                            <td>
                                <a href="{{ route('ventas.show', $sale->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@include('ventas::modals_clients.create')

@endsection

@push('scripts')
<script src="{{ asset('js/sales.js') }}"></script>
@endpush