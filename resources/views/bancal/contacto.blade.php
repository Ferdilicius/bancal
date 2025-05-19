@section('title', 'Contacto')

<x-app-layout>
    <div class="p-6 bg-gray-100 rounded-lg shadow-md max-w-lg mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Contacto</h1>
        <p class="text-gray-600 mb-6">Hola, por favor contáctanos para más información.</p>

        <form action="/enviar-queja" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Tu nombre">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Tu correo electrónico">
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="tel" id="telefono" name="telefono"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Tu número de teléfono">
            </div>

            <div>
                <label for="asunto" class="block text-sm font-medium text-gray-700">Asunto</label>
                <input type="text" id="asunto" name="asunto"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Asunto del mensaje">
            </div>

            <div>
                <label for="mensaje" class="block text-sm font-medium text-gray-700">Queja</label>
                <textarea id="mensaje" name="mensaje" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Escribe tu queja aquí"></textarea>
            </div>

            <div>
                <label for="archivo" class="block text-sm font-medium text-gray-700">Adjuntar Archivo</label>
                <input type="file" id="archivo" name="archivo"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label for="preferencia-contacto" class="block text-sm font-medium text-gray-700">Preferencia de
                    Contacto</label>
                <select id="preferencia-contacto" name="preferencia_contacto"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="email">Correo Electrónico</option>
                    <option value="telefono">Teléfono</option>
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
