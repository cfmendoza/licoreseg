@extends('layouts.app')

@section('title', 'Editar Usuario | ' . config('app.name'))

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Editar Usuario</h1>
  <form action="{{ route('usuarios.update', $user) }}" method="POST">
    @method('PUT')
    @include('usuarios::form')
  </form>
</div>
@endsection
