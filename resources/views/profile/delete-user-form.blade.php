<x-action-section>
    <x-slot name="title">
        {{ __('Eliminar cuenta') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Elimina permanentemente tu cuenta.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Una vez se elimine tu cuenta, todos tus datos se borrarán permanentemente.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Eliminar cuenta') }}
            </x-danger-button>
        </div>

        <!-- Modal de confirmación -->
        <x-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('¿Estás seguro?') }}
            </x-slot>

            <x-slot name="content">
                {{ __('¿Seguro que quieres eliminar tu cuenta? Todos tus datos se eliminarán permanentemente.') }}

                @if (auth()->user()->password)
                    <div class="mt-4">
                        <x-input type="password" class="mt-1 block w-3/4"
                                 placeholder="{{ __('Contraseña') }}"
                                 wire:model.defer="password"
                                 wire:keydown.enter="deleteUser" />

                        <x-input-error for="password" class="mt-2" />
                    </div>
                @else
                    <div class="mt-4 text-sm text-red-600">
                        {{ __('No tienes contraseña porque iniciaste sesión con Google. No es necesario escribir una.') }}
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Eliminar cuenta') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
