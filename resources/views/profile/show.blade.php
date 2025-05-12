@section('title', 'Configuración de la Cuenta')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-80">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- <div class="mt-10 sm:mt-0">
        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="dni_cif" class="block text-sm font-medium text-gray-700">DNI/CIF</label>
                <input type="text" name="dni_cif" id="dni_cif" value="{{ old('dni_cif', $user->dni_cif) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-4">
                <label for="dni_cif_url" class="block text-sm font-medium text-gray-700">DNI/CIF URL</label>
                <input type="url" name="dni_cif_url" id="dni_cif_url"
                    value="{{ old('dni_cif_url', $user->dni_cif_url) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-4">
                <label for="user_type_id" class="block text-sm font-medium text-gray-700">User Type</label>
                <select name="user_type_id" id="user_type_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($userTypes as $type)
                        <option value="{{ $type->id }}" {{ $type->id == old('user_type_id', $user->user_type_id) ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach 
                </select>
            </div>

            <div class="mt-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>

    <x-section-border /> --}}

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
