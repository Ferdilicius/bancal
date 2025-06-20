<div class="w-1/2 mx-auto p-6 space-y-6">

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
    </div>

    {{-- Message Type --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de consulta *</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach ($messageTypes as $type)
                <div
                    class="p-4 border rounded-md flex items-center space-x-2 shadow-sm bg-gradient-to-r from-blue-50 via-blue-100 to-blue-200 bg-opacity-80">
                    <label class="flex items-center cursor-pointer w-full">
                        <input type="radio" wire:model="message_type_id" value="{{ $type['id'] }}"
                            class="mr-2 accent-red-500">
                        <span class="text-sm font-medium text-gray-900">{{ $type['name'] }}</span>
                    </label>
                </div>
            @endforeach
        </div>
        @error('message_type_id')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>


    {{-- Message --}}
    <div x-data="{ count: @js(strlen($wire->message ?? '')) }" x-init="$watch('$wire.message', val => count = val ? val.length : 0)">
        <label class="block text-sm font-medium text-gray-700 mb-2">Describe tu situación en detalle *</label>
        <textarea wire:model="message" rows="8" required
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 resize-vertical"
            placeholder="Describe tu consulta o problema..." x-on:input="count = $event.target.value.length"></textarea>

        <div class="mt-2 flex justify-between items-center">
            <p class="text-sm text-gray-500">Mínimo 20 caracteres</p>
            <span class="text-xs text-gray-400" x-text="count + ' caracteres'"></span>
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
