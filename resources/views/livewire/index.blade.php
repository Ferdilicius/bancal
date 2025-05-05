@section('title', 'Bancal - Página Principal')

<div class="container mx-auto mt-10 px-6 sm:px-8 lg:px-12">
    <h1 class="text-center text-3xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
        Bienvenido a Bancal
    </h1>
    <p class="text-center text-lg sm:text-xl text-gray-700 mt-4">
        Esta es la página principal de nuestra aplicación.

        <i class="fa-solid fa-cloud text-blue-500"></i>
    </p>

    @livewire('MostrarTodos')
</div>
