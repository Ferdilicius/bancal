<div class="p-6 space-y-6">

    {{-- Contact Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre completo *</label>
            <input type="text" wire:model.defer="nombre"
                class="w-full px-3 py-2 border rounded-md @error('nombre') border-red-500 @enderror"
                placeholder="Tu nombre completo" required>
            @error('nombre')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
            <input type="email" wire:model.defer="email"
                class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror"
                placeholder="tu@email.com" required>
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Message Type --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de consulta *</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach ($messageTypes as $type)
                <label class="relative">
                    <input type="radio" wire:model="tipo" value="{{ $type['value'] }}" class="sr-only">
                    <div
                        class="p-3 border-2 rounded-lg cursor-pointer transition-all
                        {{ $tipo === $type['value'] ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <div class="flex items-center space-x-3">
                            <span class="text-lg">{{ $type['icon'] }}</span>
                            <span class="text-sm font-medium text-gray-900">{{ $type['label'] }}</span>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
        @error('tipo')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

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
            @foreach ($levels as $level)
                <label class="flex items-center">
                    <input type="radio" wire:model="prioridad" value="{{ $level['value'] }}">
                    <span class="ml-2 text-sm text-gray-700">{{ $level['label'] }}</span>
                    <div class="ml-2 w-2 h-2 rounded-full bg-{{ $level['color'] }}-400"></div>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Message --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Describe tu situación en detalle *</label>
        <textarea wire:model.defer="mensaje" rows="8" required
            class="w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-red-500 resize-vertical"
            placeholder="Describe tu consulta o problema..."></textarea>
        <div class="mt-2 flex justify-between items-center">
            <p class="text-sm text-gray-500">Mínimo 20 caracteres</p>
            <p class="text-sm text-gray-500">{{ strlen($mensaje ?? '') }} caracteres</p>
        </div>
        @error('mensaje')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Botones --}}
    <div class="flex justify-end space-x-4 pt-4 border-t">
        <a href="{{ url()->previous() }}"
            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
            Cancelar
        </a>
        <button type="button" wire:click="enviarConsulta"
            class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
            Enviar consulta
        </button>
    </div>
</div>
