@extends('layouts.app')

@section('title', 'Productos | ' . config('app.name'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-primary">Gestión de Productos</h1>

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

    {{-- Botón de creación --}}
    <div class="mb-3 text-end">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>

    {{-- Tabla de productos --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Listado de Productos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle m-0" id="table-products">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoria</th>
                            <th>Presentación</th>
                            <th>Imagen</th>
                            <th>ML</th>
                            <th>Precio Compra</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->presentation }}</td>
                            <td>
                                @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Imagen" width="50" height="50" class="rounded shadow-sm">
                                @else
                                <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $product->content }}</td>
                            <td>$ {{ number_format($product->price_purchase, 0) }}</td>
                            <td>$ {{ number_format($product->price_sale, 0) }}</td>
                            <td>
                                @if($product->isLowStock())
                                <span class="badge bg-danger">{{ $product->stock }}</span>
                                @else
                                {{ $product->stock }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button
                                    class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $product->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No hay productos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script src="{{ asset('js/inventories.js') }}"></script>
@endpush