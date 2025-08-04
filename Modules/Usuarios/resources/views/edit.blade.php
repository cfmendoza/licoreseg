@extends('layouts.app')

@section('title', 'Editar Usuario | ' . config('app.name'))

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Editar Usuario</h1>
 <form class="edit-user-form" data-id="{{ $user->id }}">
  @csrf
  @method('PUT')
  @include('usuarios::form')
</form>

</div>
@endsection

@push('scripts')
<script src="{{ asset('js/users.js') }}"></script>
@endpush