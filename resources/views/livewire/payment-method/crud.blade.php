@section('title', $paymentMethodId ? 'Editar Método de Pago' : 'Crear Método de Pago')

<div class="max-w-6xl mx-auto py-6 px-6 sm:px-12 text-lg">
    <a href="{{ route('private.profile') }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>
    <div x-data="{
        submit() { $wire.save() }
    }" class="mx-auto p-12 bg-white shadow-lg rounded-lg border border-gray-200"
        role="form" aria-labelledby="payment-method-form-title">

        <h1 id="payment-method-form-title" class="text-2xl font-bold text-indigo-700 mb-10 text-center">
            {{ $paymentMethodId ? 'Editar Método de Pago' : 'Crear Método de Pago' }}
        </h1>
        <div class="space-y-10" enctype="multipart/form-data" @keydown.enter.prevent="submit">

            {{-- Nombre --}}
            <div>
                <label for="name" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Nombre
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el nombre">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Escribe el nombre identificativo para este método de pago. Ejemplo: "Visa Personal", "PayPal
                            Empresa", etc.
                        </div>
                    </span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                @error('name')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('name', 'nombre', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Tipo --}}
            <div>
                <label for="type" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>
                    Tipo
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el tipo">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Selecciona el tipo de método de pago. Por ejemplo: Tarjeta, PayPal, Bizum u otro.
                        </div>
                    </span>
                </label>
                <select id="type" wire:model="type"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 bg-white focus:ring-indigo-400 focus:border-indigo-400 text-base"
                    aria-required="true">
                    <option value="" selected>Selecciona un tipo</option>
                    <option value="card">Tarjeta</option>
                    <option value="paypal">PayPal</option>
                    <option value="bizum">Bizum</option>
                    <option value="other">Otro</option>
                </select>
                @error('type')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('type', 'tipo', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Detalles --}}
            <div>
                <label for="details" class="text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span>Detalles
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre los detalles">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Puedes añadir información adicional relevante para este método de pago, como el número de
                            cuenta, correo de PayPal, etc. Este campo es opcional.
                        </div>
                    </span>
                </label>
                <input type="text" id="details" wire:model="details"
                    class="mt-2 block w-full border border-gray-300 rounded px-5 py-3 focus:ring-indigo-400 focus:border-indigo-400 text-base">
                @error('details')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('details', 'detalles', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Estado --}}
            <div>
                <label class="block text-base font-semibold text-gray-800 mb-2 flex items-center gap-3">
                    <span class="text-red-600">*</span> Estado
                    <span class="relative group text-indigo-500 cursor-pointer" tabindex="0"
                        aria-label="Información sobre el estado">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        <div class="absolute left-7 top-1/2 -translate-y-1/2 z-20 hidden group-hover:block group-focus:block bg-white border border-gray-300 rounded shadow px-5 py-3 text-base text-gray-700 w-80"
                            role="tooltip">
                            Indica si este método de pago está activo y disponible para usar, o inactivo y no
                            disponible.
                        </div>
                    </span>
                </label>
                <div class="flex items-center gap-12">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="active"
                            class="form-radio w-5 h-5 text-green-600 focus:ring-green-500">
                        <span class="text-base font-bold">Activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" wire:model="status" value="inactive"
                            class="form-radio w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="text-base font-bold">Inactivo</span>
                    </label>
                </div>
                @error('status')
                    <span class="text-sm text-red-500 mt-2 block" role="alert">
                        {{ str_replace('status', 'estado', $message) }}
                    </span>
                @enderror
            </div>

            {{-- Botones --}}
            <div class="flex flex-col sm:flex-row gap-4 mt-12">
                <button type="button" @click="submit"
                    class="flex-1 bg-indigo-600 text-white py-3 px-6 rounded shadow hover:bg-indigo-700 font-bold text-lg transition"
                    aria-label="{{ $paymentMethodId ? 'Actualizar Método de Pago' : 'Crear Método de Pago' }}">
                    {{ $paymentMethodId ? 'Actualizar Método de Pago' : 'Crear Método de Pago' }}
                </button>
                @if ($paymentMethodId)
                    <div x-data="{ open: false }" class="flex-1">
                        <button type="button" @click="open = true"
                            class="w-full bg-red-600 text-white py-3 px-6 rounded shadow hover:bg-red-700 text-lg font-bold"
                            aria-label="Borrar Método de Pago">
                            Borrar Método de Pago
                        </button>
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40"
                            role="dialog" aria-modal="true">
                            <div class="bg-white rounded shadow p-8 max-w-xs w-full text-center"
                                @click.away="open = false" @keydown.escape.window="open = false">
                                <h2 class="text-lg font-bold mb-4 text-gray-900">¿Seguro que quieres borrar este método
                                    de pago?</h2>
                                <p class="mb-6 text-gray-600 text-base">Esta acción es irreversible.</p>
                                <div class="flex gap-4 justify-center">
                                    <button type="button" wire:click="delete"
                                        class="bg-red-700 text-white px-6 py-3 rounded hover:bg-red-800 font-semibold text-base">
                                        Sí, borrar
                                    </button>
                                    <button type="button" @click="open = false"
                                        class="bg-gray-200 text-gray-800 px-6 py-3 rounded hover:bg-gray-300 font-semibold text-base">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <a href="{{ route('private.profile') }}"
                    class="flex-1 flex items-center justify-center gap-3 bg-gray-100 text-gray-700 py-3 px-6 rounded shadow hover:bg-gray-200 font-bold text-lg transition border border-gray-300"
                    aria-label="Cancelar y volver al perfil privado">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </div>
</div>
