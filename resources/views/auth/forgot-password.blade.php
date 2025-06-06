<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-24 h-24">
            </a>
        </x-slot>

        @section('title', 'Restablecer Contraseña - Bancal')

        <div class="mb-4 text-sm text-gray-600">
            {{ __('¿Olvidaste tu contraseña? Ingresa tu correo y te enviaremos un enlace para restablecerla.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Enviar Enlace') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
