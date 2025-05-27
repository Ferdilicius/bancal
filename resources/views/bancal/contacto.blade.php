@section('title', 'Contacto')

<x-app-layout>
    <div class="p-6 bg-white rounded-xl shadow-lg max-w-lg mx-auto mt-10 mb-16">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Contacto</h1>
        <p class="text-gray-700 mb-8">Hola, por favor contáctanos para más información.</p>

        <form action="/enviar-queja" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" required
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900 placeholder-gray-400"
                    placeholder="Tu nombre">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900 placeholder-gray-400"
                    placeholder="Tu correo electrónico">
            </div>

            <div>
                <label for="telefono" class="block text-sm font-semibold text-gray-700 mb-1">Teléfono</label>
                <input type="tel" id="telefono" name="telefono"
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900 placeholder-gray-400"
                    placeholder="Tu número de teléfono">
            </div>

            <div>
                <label for="asunto" class="block text-sm font-semibold text-gray-700 mb-1">Asunto</label>
                <input type="text" id="asunto" name="asunto"
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900 placeholder-gray-400"
                    placeholder="Asunto del mensaje">
            </div>

            <div>
                <label for="mensaje" class="block text-sm font-semibold text-gray-700 mb-1">Queja</label>
                <textarea id="mensaje" name="mensaje" rows="4" required
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900 placeholder-gray-400"
                    placeholder="Escribe tu queja aquí"></textarea>
            </div>

            <div>
                <label for="archivo" class="block text-sm font-semibold text-gray-700 mb-1">Adjuntar Archivo</label>
                <input type="file" id="archivo" name="archivo"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label for="preferencia-contacto" class="block text-sm font-semibold text-gray-700 mb-1">Preferencia de
                    Contacto</label>
                <select id="preferencia-contacto" name="preferencia_contacto"
                    class="block w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 py-2 px-3 text-gray-900">
                    <option value="email">Correo Electrónico</option>
                    <option value="telefono">Teléfono</option>
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
