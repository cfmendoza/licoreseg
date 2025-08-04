@extends('layouts.app')

@section('title','Reportes | '.config('app.name'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-primary">Reportes de Inventario y Ventas</h1>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('reportes.index') }}" class="row mb-4 gx-2 gy-3 align-items-end">
                <div class="col-md-3">
                    <label>Desde</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Hasta</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Tipo de reporte</label>
                    <select name="type" class="form-select">
                        <option value="products" {{ request('type') == 'products' ? 'selected' : '' }}>Productos</option>
                        <option value="sales" {{ request('type') == 'sales' ? 'selected' : '' }}>Ventas</option>
                    </select>
                </div>

                @if(request('type', 'products') === 'products')
                    <div class="col-md-3">
                        <label>Categoría</label>
                        <select name="category" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected':'' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check mt-4">
                            <input type="checkbox" name="low_stock" id="low_stock" class="form-check-input"
                                   {{ request('low_stock') ? 'checked' : '' }}>
                            <label class="form-check-label" for="low_stock">Solo bajo inventario</label>
                        </div>
                    </div>
                @endif

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.export', request()->all()) }}" class="btn btn-success me-2">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Exportar Excel
                    </a>
                    <a href="{{ route('reportes.export_pdf', request()->all()) }}" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                    </a>
                </div>
            </form>

            {{-- Tabla de productos --}}
            @if(request('type', 'products') === 'products')
                <h5 class="text-secondary">Productos / Inventario</h5>
                <table class="table table-striped table-hover align-middle mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio Venta</th>
                            <th>Actualizado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $p)
                            <tr class="{{ $p->stock <= 10 ? 'table-danger' : '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->category->name }}</td>
                                <td class="{{ $p->stock <= 10 ? 'fw-bold text-danger' : '' }}">{{ $p->stock }}</td>
                                <td>${{ number_format($p->price_sale, 0) }}</td>
                                <td>{{ $p->updated_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay productos para estos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

            {{-- Tabla de ventas --}}
            @if(request('type') === 'sales')
                <h5 class="text-secondary">Ventas</h5>
                <table class="table table-striped table-hover align-middle mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales ?? [] as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->date)->format('d/m/Y') }}</td>
                                <td>{{ $s->customer->name ?? '—' }}</td>
                                <td>{{ $s->user->name ?? '—' }}</td>
                                <td>${{ number_format($s->total, 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay ventas para estos filtros.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
