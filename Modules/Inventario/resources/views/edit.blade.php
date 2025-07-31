@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">Editar Producto</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('inventario::form')

        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save2"></i> Actualizar
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>

 @include('inventario::modals_categories.create_modal')
@endsection