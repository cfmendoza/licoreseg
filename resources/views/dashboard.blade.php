@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <!-- Menú superior -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <span class="text-xl font-semibold text-gray-800">Panel Administrativo</span>

            <!-- Opciones del menú -->
            <a href="#" class="text-gray-700 hover:text-blue-600">Opción 1</a>
            <a href="#" class="text-gray-700 hover:text-blue-600">Opción 2</a>
            <a href="#" class="text-gray-700 hover:text-blue-600">Opción 3</a>
        </div>

        <!-- Perfil y logout -->
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="p-6">
        <h2 class="text-2xl font-semibold mb-4">Bienvenido, {{ Auth::user()->name }}</h2>
        <!-- Aquí puedes agregar componentes, tarjetas, tablas, etc -->
    </div>
</div>
@endsection
