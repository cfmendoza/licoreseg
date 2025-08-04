<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700 shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      <!-- Logo + enlaces -->
      <div class="flex items-center space-x-6">
        <img src="{{ asset('images/fondo.png') }}" alt="Logo" class="w-13 h-14">

        @php
            use Illuminate\Support\Facades\Auth;
        @endphp
        @auth
          @can('ventas')
            <a href="{{ route('ventas.index') }}"
              @class([
                'px-3 py-2 rounded-md text-sm font-medium transition',
                request()->routeIs('ventas.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
              ])>
              Ventas
            </a>
          @endcan

          @can('inventarios')
            <a href="{{ route('inventario.index') }}"
              @class([
                'px-3 py-2 rounded-md text-sm font-medium transition',
                request()->routeIs('inventario.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
              ])>
              Inventario
            </a>
          @endcan

          @can('reportes')
            <a href="{{ route('reportes.index') }}"
              @class([
                'px-3 py-2 rounded-md text-sm font-medium transition',
                request()->routeIs('reportes.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
              ])>
              Reportes
            </a>
          @endcan

          @can('usuarios')
            <a href="{{ route('usuarios.index') }}"
              @class([
                'px-3 py-2 rounded-md text-sm font-medium transition',
                request()->routeIs('usuarios.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
              ])>
              Usuarios
            </a>
          @endcan
        @endauth
      </div>

      <!-- Usuario y logout -->
      @auth
      <div class="flex items-center space-x-4">
        <span class="text-gray-300 font-medium">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
            class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 transition">
            Cerrar sesión
          </button>
        </form>
      </div>
      @endauth

      <!-- Botón móvil -->
      <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Menú móvil -->
  <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-gray-800">
    @auth
    <div class="px-4 pt-4 pb-2 space-y-1">

      @can('ventas')
        <a href="{{ route('ventas.index') }}"
          @class([
            'block px-3 py-2 rounded-md text-base font-medium transition',
            request()->routeIs('ventas.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
          ])>
          Ventas
        </a>
      @endcan

      @can('inventarios')
        <a href="{{ route('inventario.index') }}"
          @class([
            'block px-3 py-2 rounded-md text-base font-medium transition',
            request()->routeIs('inventario.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
          ])>
          Inventario
        </a>
      @endcan

      @can('reportes')
        <a href="{{ route('reportes.index') }}"
          @class([
            'block px-3 py-2 rounded-md text-base font-medium transition',
            request()->routeIs('reportes.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
          ])>
          Reportes
        </a>
      @endcan

      @can('usuarios')
        <a href="{{ route('usuarios.index') }}"
          @class([
            'block px-3 py-2 rounded-md text-base font-medium transition',
            request()->routeIs('usuarios.index') ? 'bg-gray-900 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white'
          ])>
          Usuarios
        </a>
      @endcan

      <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit"
          class="w-full text-left block px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 transition">
          Cerrar sesión
        </button>
      </form>
    </div>
    @endauth
  </div>
</nav>
