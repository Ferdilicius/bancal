<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Logo" class="w-24 h-24">
            </a>
        </x-slot>

        @section('title', 'Registrarse - Bancal')

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('custom.register.store') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
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

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('Acepto los :terms_of_service y la :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Términos del Servicio') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Política de Privacidad') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-button>
            </div>
        </form> 
    </x-authentication-card>
</x-guest-layout>
