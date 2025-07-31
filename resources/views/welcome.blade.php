<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LEG</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif

</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">
  <!-- Header -->
  <header class="w-full bg-white shadow-md">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">
      <div class="text-2xl font-bold text-gray-800">SIN‑LEG</div>
      <div class="flex space-x-4">
        <a href="{{ route('login') }}"
           class="px-5 py-2 bg-black text-white rounded hover:bg-gray-800 focus:ring-2 focus:ring-blue-500 transition">
          Ingresar
        </a>
        <a href="{{ route('register') }}"
           class="px-5 py-2 border border-gray-600 text-gray-600 font-medium rounded-md shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-400 transition">
          Registrarse
        </a>
      </div>
      <button class="md:hidden p-2 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded-md">
        <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </header>

  <!-- Hero section -->
  <section class="flex-grow flex flex-col items-center justify-center px-4 bg-gray-50">
    <div class="max-w-2xl text-center lg:text-left">
      <h2 class="text-4xl font-extrabold text-gray-800 mb-4">Sistema de Inventario LEG</h2>
      <p class="text-gray-600 mb-6">Gestiona tus productos con eficiencia y seguridad desde un entorno profesional y confiable.</p>
      <div class="inline-flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
        <a href="https://www.linkedin.com/in/carlos-fabian-mendoza-pachon-796a121a8/"
           target="_blank" rel="noopener noreferrer"
           class="px-6 py-3 bg-black text-white font-medium rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600 transition">
          Más información
        </a>
      </div>
    </div>
  </section>

  <!-- Perfil central -->
  <main class="container mx-auto px-4  flex flex-col items-center">
    <img src="{{ asset('images/leg.jpg') }}" alt="Perfil profesional"
         class="w-56 h-56 rounded-full border-2 border-gray-300 object-cover shadow-md mb-6" />
    <h1 class="text-3xl font-semibold mb-4">Bienvenido</h1>
    <p class="text-gray-700 text-center max-w-xl">
      Accede al panel de control para gestionar inventarios, realizar seguimientos y optimizar tus operaciones sin complicaciones.
    </p>
  </main>
</body>


</html>