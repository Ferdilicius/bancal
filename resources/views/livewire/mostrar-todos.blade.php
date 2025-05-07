<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Lista de Users -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Lista de Users</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="border border-gray-200 px-4 py-2 text-left">ID</th>
                            <th class="border border-gray-200 px-4 py-2 text-left">Nombre</th>
                            <th class="border border-gray-200 px-4 py-2 text-left">Tipo de Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-2">{{ $user->id }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $user->userType->name }}</td>
                            </tr>
                        @endforeach
                </table>
            </div>
            </table>
        </div>

        <!-- Tipos de Usuario -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tipos de Usuario</h2>
            <table class="table-auto w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="border border-gray-200 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-200 px-4 py-2 text-left">Tipo</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach ($user_types as $user_type)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2">{{ $user_type->id }}</td>
                            <td class="border border-gray-200 px-4 py-2">{{ $user_type->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Lista de Productos -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Lista de Productos</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="border border-gray-200 px-4 py-2 text-left">ID</th>
                            <th class="border border-gray-200 px-4 py-2 text-left">Nombre</th>
                            <th class="border border-gray-200 px-4 py-2 text-left">Precio</th>
                            <th class="border border-gray-200 px-4 py-2 text-left">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach ($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-200 px-4 py-2">{{ $product->id }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $product->name }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $product->price }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ $product->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
