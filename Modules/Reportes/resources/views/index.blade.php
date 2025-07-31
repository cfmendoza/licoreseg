@extends('layouts.app')

@section('title','Reportes | '.config('app.name'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold text-primary">Reportes de Inventario y Ventas</h1>
    <!-- Aquí los filtros y controles export -->
    {{-- el formulario antes indicado --}}
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
                <div class="col-md-3 text-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('reportes.export', request()->all()) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Exportar Excel
                    </a>
                </div>
            </form>

            <table class="table table-striped table-hover align-middle">
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
                    @forelse($products as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category->name }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>{{ number_format($p->price_sale,0) }}</td>
                        <td>{{ $p->updated_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay datos para estos filtros.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection