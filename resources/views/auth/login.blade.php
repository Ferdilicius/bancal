<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{ route('index') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-24 h-24">
            </a>
        </x-slot>

        @section('title', 'Iniciar sesión - Bancal')

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Correo electrónico') }}" />
                <x-input id="email"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Recuérdame') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                {{ __('¿No tienes una cuenta?') }}
                <a href="{{ route('register') }}"
                    class="font-medium text-indigo-500 hover:text-indigo-700 focus:outline-none focus:underline">
                    {{ __('Regístrate') }}
                </a>
            </p>
        </div>
    </x-authentication-card>
</x-guest-layout>
