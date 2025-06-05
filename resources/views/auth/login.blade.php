<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{ route('home') }}">
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

            <div class="mt-6 grid grid-cols-2 gap-4">
                <a href="{{ url('/auth/google/redirect') }}"
                    class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 rounded-full shadow transition w-full h-12"
                    title="Iniciar sesión con Google">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                        alt="Google" class="w-5 h-5 mr-2">
                    <span class="sr-only">Google</span>
                </a>
                <a href="{{ url('/auth/facebook/redirect') }}"
                    class="flex items-center justify-center bg-white border border-gray-300 hover:bg-gray-100 text-[#1877f2] rounded-full shadow transition w-full h-12"
                    title="Iniciar sesión con Facebook">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/1200px-Facebook_Logo_%282019%29.png"
                        alt="Facebook" class="w-6 h-6 mr-2">
                    <span class="sr-only">Facebook</span>
                </a>
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

