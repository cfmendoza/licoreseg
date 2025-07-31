@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">Registrar Nuevo Producto</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('inventario::form')

        <div class="mt-3 text-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>
</div>

 @include('inventario::modals_categories.create_modal')
@endsection