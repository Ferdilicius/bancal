<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
<<<<<<< HEAD
    <aside class="w-64 bg-[#9E203F] text-white flex-shrink-0 hidden md:block shadow-lg flex flex-col">
        <div class="p-6 flex-1 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-8">Configuración Administración</h2>
                <nav>
                    <ul class="space-y-2">
                        @php
                            $sections = [
                                'users' => ['icon' => 'fas fa-users', 'label' => 'Usuarios'],
                                'products' => ['icon' => 'fas fa-cogs', 'label' => 'Productos'],
                                'product_categories' => ['icon' => 'fas fa-list', 'label' => 'Categorías de Producto'],
                                'addresses' => ['icon' => 'fas fa-map-marker-alt', 'label' => 'Direcciones'],
                                'address_types' => ['icon' => 'fas fa-tags', 'label' => 'Tipos de Dirección'],
                                'payments' => ['icon' => 'fas fa-credit-card', 'label' => 'Pagos'],
                                'payment_types' => ['icon' => 'fas fa-money-check-alt', 'label' => 'Tipos de Pago'],
                                'orders' => ['icon' => 'fas fa-shopping-cart', 'label' => 'Órdenes'],
                            ];
                        @endphp
                        @foreach ($sections as $key => $item)
                            <li>
                                <a href="{{ route('admin.index', ['section' => $key]) }}"
                                    class="flex items-center w-full text-left px-4 py-2 rounded-lg transition
                                    {{ $section === $key ? 'bg-[#C23A5C] font-semibold shadow' : 'hover:bg-[#C23A5C]' }}">
                                    <i class="{{ $item['icon'] }} mr-3"></i> {{ $item['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="mt-auto pt-8 flex justify-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('static/img/iconFresa.svg') }}" alt="Bancal"
                        class="h-16 w-16 md:h-20 md:w-auto">
                </a>
            </div>
=======
    <aside class="w-64" style="background-color: #9E203F; color: white; flex-shrink: 0;" class="hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6">Configuracion administrador</h2>
            <nav>
                <ul class="space-y-2">
                    @php
                        $sections = [
                            'users' => ['icon' => 'fas fa-users', 'label' => 'Usuarios'],
                            'products' => ['icon' => 'fas fa-bag-shopping', 'label' => 'Productos'],
                            'addresses' => ['icon' => 'fas fa-location-dot', 'label' => 'Bancales'],
                        ];
                    @endphp

                    @foreach ($sections as $key => $item)
                        <li>
                            <a href="{{ route('admin.index', ['section' => $key]) }}"
                                class="flex items-center w-full text-left px-4 py-2 rounded transition
                                            {{ $section === $key ? 'bg-[#C23A5C] font-semibold' : 'hover:bg-[#C23A5C]' }}">
                                <i class="{{ $item['icon'] }} mr-3"></i> {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
>>>>>>> 38225e3c83bac81c3a24c3ad4e6d11ae37ce2c31
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold capitalize text-gray-800">{{ $section }}</h2>
                <button wire:click="create"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                    <i class="fas fa-plus mr-2"></i>Nuevo {{ ucfirst($section) }}
                </button>
            </div>

            @if ($isEditing)
                <div class="p-6 mb-8 bg-white rounded-xl shadow-lg border border-gray-200">
                    <h3 class="text-lg font-semibold mb-4 flex items-center">
                        <i class="fas fa-edit mr-2 text-[#9E203F]"></i>
                        {{ $editingId ? 'Editar' : 'Nuevo' }} {{ ucfirst($section) }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($fillable as $field)
                            @php
                                $type = 'text';

                                if (Str::contains($field, 'email')) {
                                    $type = 'email';
                                } elseif (Str::contains($field, 'password')) {
                                    $type = 'password';
                                } elseif (Str::contains($field, 'price') || Str::contains($field, 'quantity')) {
                                    $type = 'number';
                                }
                            @endphp

                            <div>
                                <label
                                    class="block text-gray-700 font-semibold mb-1">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>

                                @if ($type === 'textarea')
                                    <textarea wire:model.defer="form.{{ $field }}" class="border p-2 rounded-lg focus:ring w-full" rows="3"></textarea>
                                @else
                                    <input type="{{ $type }}" wire:model.defer="form.{{ $field }}"
                                        class="border p-2 rounded-lg focus:ring w-full" />
                                @endif

                                @error('form.' . $field)
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" wire:click="save"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">
                            Guardar
                        </button>
                        <button type="button" wire:click="resetForm"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg transition">
                            Cancelar
                        </button>
                    </div>
                </div>
            @endif

            <!-- Tabla dinámica -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach ($fillable as $field)
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ ucfirst(str_replace('_', ' ', $field)) }}
                                </th>
                            @endforeach
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($data as $item)
                            <tr>
                                @foreach ($fillable as $field)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $item->$field }}
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap flex justify-center gap-2">
                                    <button wire:click="edit({{ $item->id }})"
                                        class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete({{ $item->id }})"
                                        class="text-red-600 hover:text-red-800" title="Eliminar"
                                        onclick="confirm('¿Seguro que quieres eliminar?') || event.stopImmediatePropagation()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($fillable) + 1 }}" class="px-6 py-4 text-center text-gray-500">
                                    No hay registros
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
