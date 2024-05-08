@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')
    <div class="p-4">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white ml-4 ">Gestión de Productos: {{$nombreRestaurante}}</h1>
        <!-- Tarjetas de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 ml-4">
            @foreach($comidas as $comida)
                <div id="comida-{{ $comida->id_comida }}" class="rounded-lg shadow-md overflow-hidden bg-white">
                    <img class="w-full h-48 object-cover object-center" src="{{ asset($comida->imagen) }}" alt="{{ $comida->nom_comida }}">
                    <div class="p-4 flex flex-col">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $comida->nom_comida }}</h2>
                            <form action="{{ route('eliminar_comida', ['id_comida' => $comida->id_comida]) }}" method="POST" id="formEliminarProducto">
                                @csrf
                                @method('DELETE')
                                <div class="flex items-center">
                                    <button type="submit" class="flex items-center btn btn-ghost cursor-pointer duration-150 hover:text-red-500 btnEliminarProducto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-8 w-8 cursor-pointer duration-150 hover:text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Eliminar</span>
                                    </button>
                                </div>
                                <script>
                                    @if(session('success'))
                                    Swal.fire({
                                        title: '{{ session('success') }}',
                                        icon: 'success'
                                    });
                                    @endif
                                </script>
                            </form>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $comida->descripcion }}</p>
                        <p class="text-gray-700 mb-2"><b>Precio:</b> {{ $comida->precio }} €</p>
                        <p class="text-gray-700 mb-2"><b>Restaurante:</b> {{ $comida->restaurante->nom_restaurante }}</p>
                        <!-- Formulario para modificar el precio -->
                        <form action="{{ route('actualizar_precio', ['id_comida' => $comida->id_comida]) }}" method="POST" class="mb-2" id="formActualizarPrecio">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center">
                                <input type="number" name="precio" id="number-input" value="{{ $comida->precio }}" step="0.01" aria-describedby="helper-text-explanation" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                                <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full ml-2 btnActualizarPrecio">Actualizar</button>
                            </div>
                            <script>
                                @if(session('success'))
                                Swal.fire({
                                    title: '{{ session('success') }}',
                                    icon: 'success'
                                });
                                @endif
                            </script>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
        <!-- Navegación de páginas -->
        <div class="flex justify-center mt-6">
            @for ($i = 1; $i <= ceil(count($comidas) / 12); $i++)
                <button class="btn btn-square{{ $i == 1 ? ' active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
            @endfor
        </div>
    </div>
@endsection
