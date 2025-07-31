<x-guest-layout>
  <x-authentication-card class="bg-white shadow-lg rounded-lg">
    <x-slot name="logo">
      <x-authentication-card-logo />
    </x-slot>

    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Inventario LEG</h2>

    <x-validation-errors class="mb-4" />

    @session('status')
      <div class="mb-4 text-sm text-green-600">
        {{ session('status') }}
      </div>
    @endsession

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      <div>
        <x-label for="email" value="Email" />
        <x-input id="email" class="mt-1 block w-full border-gray-300 focus:ring-black focus:border-black" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
      </div>

      <div>
        <x-label for="password" value="Contraseña" />
        <x-input id="password" class="mt-1 block w-full border-gray-300 focus:ring-black focus:border-black" type="password" name="password" required autocomplete="current-password" />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <x-checkbox name="remember" />
          <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
        </label>

        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-black rounded">
            ¿Olvidaste tu contraseña?
          </a>
        @endif
      </div>

      <div>
        <x-button class="w-full bg-black text-white font-semibold hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:ring-gray-600 transition">
          Iniciar sesión
        </x-button>
      </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      ¿No tienes cuenta?
      <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Regístrate</a>
    </div>
  </x-authentication-card>
</x-guest-layout>
