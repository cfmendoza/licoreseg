@php
    $hideNav = true;
@endphp
@extends('layouts.app')


@section('background-style', "background: url('" . asset('images/local.jpg') . "') no-repeat center center fixed; background-size: cover;")

@section('content')
<div class="min-h-screen flex justify-center items-center">
  <div class="w-full max-w-md p-8 rounded-2xl shadow-2xl bg-white/80 backdrop-blur-md">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h2>

    <form method="POST" action="{{ url('iniciar-sesion') }}" class="space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
        @error('email')
          <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
        <input type="password" name="password" id="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
        @error('password')
          <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm">
          <input type="checkbox" name="remember" class="mr-2 text-blue-500 focus:ring-blue-500">
          Recuérdame
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
      </div>

      <div>
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
          Ingresar
        </button>
      </div>
    </form>
    
  </div>
  <img src="{{ asset('images/fondo.png') }}"
       alt="Fondo decorativo"
       class="absolute bottom-0 right-0 w-48 h-auto opacity-80 pointer-events-none">

  <!-- Texto de copyright debajo -->
  <div class="absolute bottom-0 right-0 mr-4 mb-2 text-xs text-white">
    © Todos los derechos reservados. Licoreseg 2025.
  </div>
</div>
@endsection
