<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64" style="background-color: #9E203F; color: white; flex-shrink: 0;" class="hidden md:block">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6">Configuracion administrador</h2>
            <nav>
                <ul class="space-y-2">
                    @php
                        $sections = [
                            'users' => ['icon' => 'fas fa-users', 'label' => 'Usuarios'],
                            'products' => ['icon' => 'fas fa-cogs', 'label' => 'Productos'],
                            'addresses' => ['icon' => 'fas fa-cogs', 'label' => 'Bancales'],
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
        </div>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 p-6">
        <div class="mb-8">
            <h2 class="text-xl font-bold mb-4 capitalize">{{ $section }}</h2>

            <button wire:click="create" class="bg-green-500 text-white px-3 py-1 rounded mb-4">Nuevo
                {{ ucfirst($section) }}</button>
            @if ($isEditing)
                <div class="p-4 mb-4 bg-gray-100 rounded shadow">
                    <h3 class="text-lg font-semibold mb-2">{{ $editingId ? 'Editar' : 'Nuevo' }} {{ ucfirst($section) }}
                    </h3>

                    @if ($section === 'users')
                        <input type="text" wire:model="form.name" placeholder="Nombre"
                            class="border p-1 mb-2 block w-full">
                        <input type="email" wire:model="form.email" placeholder="Email"
                            class="border p-1 mb-2 block w-full">
                        <input type="password" wire:model="form.password" placeholder="Contraseña"
                            class="border p-1 mb-2 block w-full">
                        <select wire:model="form.user_type" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona tipo de usuario</option>
                            <option value="admin">Administrador</option>
                            <option value="particular">Particular</option>
                            <option value="empresa">Empresa</option>
                        </select>
                    @elseif ($section === 'products')
                        <input type="text" wire:model="form.name" placeholder="Nombre"
                            class="border p-1 mb-2 block w-full">
                        <input type="number" wire:model="form.price" placeholder="Precio"
                            class="border p-1 mb-2 block w-full">
                        <textarea wire:model="form.description" placeholder="Descripción" class="border p-1 mb-2 block w-full"></textarea>
                        <input type="number" wire:model="form.quantity" placeholder="Cantidad"
                            class="border p-1 mb-2 block w-full">
                        <select wire:model="form.quantity_type" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona tipo de cantidad</option>
                            <option value="kilo">Kilo</option>
                            <option value="litro">Litro</option>
                            <option value="unidad">Unidad</option>
                            <option value="bolsa">Bolsa</option>
                            <option value="caja">Caja</option>
                        </select>
                        <select wire:model="form.category_id" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona categoría</option>
                            <option value="1">Verduras</option>
                            <option value="2">Frutas</option>
                            <option value="3">Lácteos</option>
                            <option value="4">Cereales</option>
                            <option value="5">Carnes</option>
                            <option value="6">Enlatados</option>
                            <option value="7">Congelados</option>
                        </select>
                        <select wire:model="form.user_id" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona usuario</option>
                            @foreach (\App\Models\User::orderBy('id')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model="form.status" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    @elseif ($section === 'addresses')
                        <input type="text" wire:model="form.name" placeholder="Nombre"
                            class="border p-1 mb-2 block w-full">
                        <input type="text" wire:model="form.address" placeholder="Dirección"
                            class="border p-1 mb-2 block w-full">
                        <select wire:model="form.user_id" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona usuario</option>
                            @foreach (\App\Models\User::orderBy('id')->get() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <select wire:model="form.address_type_id" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona tipo de dirección</option>
                            <option value="1">Bancal</option>
                            <option value="2">Huerto urbano compartido</option>
                            <option value="3">Huerto urbano privado</option>
                            <option value="4">Huerto escolar</option>
                        </select>
                        <select wire:model="form.status" class="border p-1 mb-2 block w-full">
                            <option value="">Selecciona estado</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    @endif

                    <div class="flex gap-2">
                        <button type="button" wire:click="save" class="bg-blue-500 text-white px-4 py-1 rounded">Guardar</button>
                        <button type="button" wire:click="resetForm" class="bg-gray-400 text-white px-4 py-1 rounded">Cancelar</button>
                    </div>
                </div>
            @endif


            @if ($section === 'users')
                <ul>
                    @foreach ($data as $user)
                        <li>
                            {{ $user->name }} ({{ $user->email }})
                            <button wire:click="edit({{ $user->id }})" class="text-blue-500 ml-2">Editar</button>
                            <button wire:click="delete({{ $user->id }})"
                                class="text-red-500 ml-1">Eliminar</button>
                        </li>
                    @endforeach
                </ul>
            @elseif ($section === 'products')
                <ul>
                    @foreach ($data as $product)
                        <li>
                            {{ $product->name }} - {{ $product->price }}€
                            <button wire:click="edit({{ $product->id }})" class="text-blue-500 ml-2">Editar</button>
                            <button wire:click="delete({{ $product->id }})"
                                class="text-red-500 ml-1">Eliminar</button>
                        </li>
                    @endforeach
                </ul>
            @elseif ($section === 'addresses')
                <ul>
                    @foreach ($data as $address)
                        <li>
                            {{ $address->name }} - {{ $address->address }}
                            <button wire:click="edit({{ $address->id }})" class="text-blue-500 ml-2">Editar</button>
                            <button wire:click="delete({{ $address->id }})"
                                class="text-red-500 ml-1">Eliminar</button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
