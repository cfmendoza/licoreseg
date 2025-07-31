@extends('layouts.app')

@section('title', 'Crear Usuario | ' . config('app.name'))

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Nuevo Usuario</h1>
  <form action="{{ route('usuarios.store') }}" method="POST">
    @include('usuarios::form')
  </form>
</div>
@endsection
