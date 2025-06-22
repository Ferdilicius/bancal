<div class="max-w-6xl mx-auto py-10 px-6 sm:px-12 text-lg bg-white rounded-xl shadow-lg mt-8">

    <a href="{{ route('home') }}" class="flex items-center text-gray-600 hover:text-gray-900 mb-8 text-lg">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Volver atrás
    </a>

    @auth
        <div
            class="mb-6 px-6 py-3 bg-gradient-to-r from-blue-100 via-blue-50 to-blue-100 text-blue-900 border border-blue-200 rounded-lg shadow text-center">
            <span class="font-semibold text-lg">¡Hola, {{ auth()->user()->name }}!</span>
            <div class="mt-1 text-base">Completa el formulario y nos pondremos en contacto contigo lo antes posible.</div>
        </div>
    @endauth

    <form wire:submit.prevent="enviarConsulta" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @unless (auth()->check())
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" wire:model="email"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 @error('email') border-red-500 @enderror"
                        placeholder="tu@email.com" required>
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endunless
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Tipo de consulta <span
                    class="text-red-500">*</span></label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ($messageTypes as $type)
                    <label
                        class="flex items-center p-4 border rounded-lg shadow-sm bg-gradient-to-r from-blue-50 via-blue-100 to-blue-200 cursor-pointer transition hover:shadow-md">
                        <input type="radio" wire:model="message_type_id" value="{{ $type['id'] }}"
                            class="mr-3 accent-blue-500 focus:ring-2 focus:ring-blue-400">
                        <span class="text-base font-medium text-gray-900">{{ $type['name'] }}</span>
                    </label>
                @endforeach
            </div>
            @error('message_type_id')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{ count: @js(strlen($wire->message ?? '')) }" x-init="$watch('$wire.message', val => count = val ? val.length : 0)">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Describe tu situación en detalle <span
                    class="text-red-500">*</span></label>
            <textarea wire:model="message" rows="7" required
                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 resize-vertical"
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
                class="mb-4 px-4 py-2 rounded-lg bg-green-100 text-green-800 border border-green-300 text-base text-center shadow w-full md:w-2/3 mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-end gap-4 pt-4 border-t border-gray-200">
            <button type="submit"
                class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                Enviar consulta
            </button>
        </div>
    </form>

    @if (auth()->check())
        <div class="mt-12 w-full mx-auto md:flex md:justify-end">
            <div class="md:w-2/3 flex flex-col items-end">
                <h2 class="text-xl font-bold mb-6 text-blue-700 flex items-center gap-2 w-full justify-end">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3m-8 4h16" />
                    </svg>
                    Tus consultas recientes
                </h2>
                <div class="space-y-4 w-full flex flex-col items-end">
                    @forelse($messages as $userMsg)
                        <div class="flex justify-end w-full">
                            <div
                                class="max-w-full px-5 py-3 rounded-lg shadow bg-gradient-to-r from-blue-50 via-blue-100 to-blue-200 text-blue-900 border border-blue-200">
                                <div class="text-xs text-gray-500 mb-1 flex items-center gap-2">
                                    <span>{{ $userMsg->created_at->format('d/m/Y H:i') }}</span>
                                    @if ($userMsg->messageType)
                                        <span
                                            class="px-2 py-0.5 rounded bg-blue-200 text-blue-800 text-[10px] font-semibold">{{ $userMsg->messageType->name }}</span>
                                    @endif
                                </div>
                                <div class="whitespace-pre-line text-base">{{ $userMsg->message }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-right w-full">Aún no has enviado ninguna consulta.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
