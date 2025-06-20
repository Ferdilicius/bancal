<<<<<<< HEAD:resources/views/livewire/contact.blade.php
<div class="w-1/2 mx-auto p-6 space-y-6">
=======
<form method="POST" action="{{ route('soporte.enviar') }}" class="p-6 space-y-6">
    @csrf
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php

    {{-- Mensaje de bienvenida si está logueado --}}
    @auth
        <div class="mb-4 px-4 py-2 bg-blue-100 text-blue-800 border border-blue-300 text-sm text-center">
            <span class="font-semibold mr-2 inline-block text-center w-full text-lg">¡Hola,
                {{ auth()->user()->name }}!</span>
            Completa el formulario y nos pondremos en contacto contigo lo antes posible.
        </div>

    @endauth
    {{-- Contact Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<<<<<<< HEAD:resources/views/livewire/contact.blade.php
        @unless (auth()->check())
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" wire:model="email"
                    class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror"
                    placeholder="tu@email.com" required>
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endunless
=======
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre completo *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                class="w-full px-3 py-2 border rounded-md @error('nombre') border-red-500 @enderror"
                placeholder="Tu nombre completo" required>
            @error('nombre')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror"
                placeholder="tu@email.com" required>
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php
    </div>

    {{-- Message Type --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de consulta *</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
<<<<<<< HEAD:resources/views/livewire/contact.blade.php
            @foreach ($messageTypes as $type)
                <div
                    class="p-4 border rounded-md flex items-center space-x-2 shadow-sm bg-gradient-to-r from-blue-50 via-blue-100 to-blue-200 bg-opacity-80">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="radio" wire:model="message_type_id" value="{{ $type['id'] }}"
                            class="mr-2 accent-red-500">
                        <span class="text-sm font-medium text-gray-900">{{ $type['name'] }}</span>
                    </label>
                </div>
=======
            @php
                $messageTypes = [
                    ['value' => 'technical_issue', 'label' => 'Problema técnico', 'icon' => '⚙️'],
                    ['value' => 'account_help', 'label' => 'Ayuda con mi cuenta', 'icon' => '👤'],
                    ['value' => 'order_inquiry', 'label' => 'Consulta sobre pedido', 'icon' => '📦'],
                    ['value' => 'payment_issue', 'label' => 'Problema de pago', 'icon' => '💳'],
                    ['value' => 'product_question', 'label' => 'Pregunta sobre producto', 'icon' => '🥬'],
                    ['value' => 'seller_support', 'label' => 'Soporte para vendedores', 'icon' => '🏪'],
                    ['value' => 'general_inquiry', 'label' => 'Consulta general', 'icon' => '💬'],
                    ['value' => 'feedback', 'label' => 'Sugerencias y comentarios', 'icon' => '⭐'],
                    ['value' => 'other', 'label' => 'Otro', 'icon' => '❓'],
                ];
            @endphp
            @foreach($messageTypes as $type)
                <label class="relative">
                    <input type="radio" name="tipo" value="{{ $type['value'] }}" class="sr-only"
                        {{ old('tipo') === $type['value'] ? 'checked' : '' }}>
                    <div class="p-3 border-2 rounded-lg cursor-pointer transition-all
                        {{ old('tipo') === $type['value'] ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-lg">{{ $type['icon'] }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $type['label'] }}</span>
                        </div>
                    </div>
                </label>
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php
            @endforeach
        </div>
        @error('message_type_id')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

<<<<<<< HEAD:resources/views/livewire/contact.blade.php
=======
    {{-- Priority --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Nivel de urgencia</label>
        <div class="flex space-x-4">
            @php
                $levels = [
                    ['value' => 'low', 'label' => 'Baja', 'color' => 'green'],
                    ['value' => 'medium', 'label' => 'Media', 'color' => 'yellow'],
                    ['value' => 'high', 'label' => 'Alta', 'color' => 'red'],
                ];
            @endphp
            @foreach($levels as $level)
                <label class="flex items-center">
                    <input type="radio" name="prioridad" value="{{ $level['value'] }}"
                        {{ old('prioridad', 'medium') === $level['value'] ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">{{ $level['label'] }}</span>
                    <div class="ml-2 w-2 h-2 rounded-full bg-{{ $level['color'] }}-400"></div>
                </label>
            @endforeach
        </div>
    </div>
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php

    {{-- Message --}}
    <div x-data="{ count: @js(strlen($wire->message ?? '')) }" x-init="$watch('$wire.message', val => count = val ? val.length : 0)">
        <label class="block text-sm font-medium text-gray-700 mb-2">Describe tu situación en detalle *</label>
<<<<<<< HEAD:resources/views/livewire/contact.blade.php
        <textarea wire:model="message" rows="8" required
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 resize-vertical"
            placeholder="Describe tu consulta o problema..." x-on:input="count = $event.target.value.length"></textarea>

        <div class="mt-2 flex justify-between items-center">
            <p class="text-sm text-gray-500">Mínimo 20 caracteres</p>
            <span class="text-xs text-gray-400" x-text="count + ' caracteres'"></span>
=======
        <textarea name="mensaje" rows="8" required
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 resize-vertical"
            placeholder="Describe tu consulta o problema...">{{ old('mensaje') }}</textarea>
        <div class="mt-2 flex justify-between items-center">
            <p class="text-sm text-gray-500">Mínimo 20 caracteres</p>
            <p class="text-sm text-gray-500">{{ strlen(old('mensaje')) }} caracteres</p>
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php
        </div>
        @error('message')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    @if (session()->has('success'))
        <div
            class="mb-4 px-4 py-2 rounded-full bg-green-100 text-green-800 border border-green-300 text-sm text-center w-[90%] md:w-1/2 mx-auto">
            {{ session('success') }}
        </div>
    @endif
    {{-- Botones --}}
    <div class="flex flex-col md:flex-row justify-end gap-4 pt-4 border-t">
        <a href="{{ url()->previous() }}"
            class="w-full md:w-auto px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 text-center transition">
            Cancelar
        </a>
<<<<<<< HEAD:resources/views/livewire/contact.blade.php
        <button type="button" wire:click="enviarConsulta"
            class="w-full md:w-auto px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
            Enviar consulta
        </button>
    </div>

    {{-- Conversación tipo Telegram
    @if (auth()->check())
        <div class="mt-10 w-full mx-auto">
            <h2 class="text-lg font-semibold mb-4 text-blue-700">Tus consultas recientes</h2>
            <div class="space-y-4">
                @forelse($messages as $msg)
                    <div class="flex justify-end">
                        <div class="max-w-full px-4 py-2 rounded-lg shadow bg-blue-100 text-blue-900">
                            <div class="text-xs text-gray-500 mb-1">
                                {{ $userMsg->created_at->format('d/m/Y H:i') }}
                                @if ($userMsg->messageType)
                                    <span
                                        class="ml-2 px-2 py-0.5 rounded bg-blue-200 text-blue-800 text-[10px]">{{ $userMsg->messageType->name }}</span>
                                @endif
                            </div>
                            <div class="whitespace-pre-line">{{ $userMsg->message }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-center">Aún no has enviado ninguna consulta.</p>
                @endforelse
            </div>
        </div>
    @endif --}}

</div>
</div>
=======
        <button type="submit"
            class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Enviar consulta
        </button>
    </div>
</form>
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488:resources/views/livewire/contact/contact.blade.php
