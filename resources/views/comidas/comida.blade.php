@extends("layouts.layout")

@section("contenido")
    <div id="filtrosycomida" class="flex flex-col">
        <div class="flex p-4">
            <div class="w-1/4 bg-gray-100 p-4 rounded-box" style="max-height: 80vh; overflow-y: auto;">
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white"><b>Filtrar por Restaurante</b></h3>
                <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @foreach($restaurantes as $restaurante)
                        <li class="border-b border-gray-200">
                            <label for="restaurante{{ $restaurante->id_restaurante }}" class="flex items-center p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                                <input id="restaurante{{ $restaurante->id_restaurante }}" type="checkbox" value="{{ $restaurante->id_restaurante }}" class="restaurante-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 mr-3">
                                <span class="font-semibold">{{ $restaurante->nom_restaurante }}</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
                <h3 class="mb-4 font-semibold text-gray-900 dark:text-white mt-6"><b>Filtrar por Precio</b></h3>
                <form action="{{ route('filtrar_por_precio') }}" method="GET">
                    <div class="flex items-center mb-4 dark:text-white">
                        <!--<label for="precio_minimo dark:text-white" class="mr-2">Precio mínimo:</label>-->
                        <span class="text-gray-900 dark:text-white mr-2">Precio Mínimo</span>
                        <input id="precio_minimo" name="precio_minimo" type="number" class="border border-gray-300 rounded-md p-1" min="0" step="0.05" value="{{ request('precio_minimo', '0.90') }}">
                    </div>
                    <!-- Campo de entrada para el precio máximo -->
                    <div class="flex items-center mb-4 dark:text-white">
                        <span class="text-gray-900 dark:text-white mr-2">Precio Máximo</span>
                        <input id="precio_maximo" name="precio_maximo" type="number" class="border border-gray-300 rounded-md p-1" min="0" step="0.05" value="{{ request('precio_maximo', '19.95') }}">
                    </div>
                    <!-- Botón para aplicar el filtro -->
                    <button type="submit" class="btn bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mr-4">Aplicar precio</button>
                </form>
            </div>

            <div class="w-3/4">
                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight  md:text-5xl lg:text-6xl dark:text-white ml-4 ">Listado de productos</h1>
                <!-- Caso 1: Cards horizontales -->
                <div class="ml-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($comidas as $key => $comida)
                        <div id="comida-{{ $comida->id_comida }}" class="card card-side bg-pink-50 shadow-xl mb-4 comida-item border-2" data-restaurante="{{ $comida->RESTAURANTE_id_restaurante }}" style="display: {{ $key < 4 ? 'block' : 'none' }}">
                            <div class="flex flex-col justify-between h-full">
                                <div>
                                    <figure>
                                        <img id="imagenComida{{ $comida->id_comida }}" class="comida-imagen rounded-box w-full" src="{{ asset($comida->imagen) }}" alt="{{ $comida->nom_comida }}" data-imagen="{{ asset($comida->imagen) }}" />
                                    </figure>
                                    <div class="p-4">
                                        <h2 class="text-xl font-semibold text-gray-900 mb-2" id="nombreComida{{ $comida->id_comida }}">{{ $comida->nom_comida }}</h2>
                                        <p class="text-sm text-gray-600 mb-4" id="descripcionComida{{ $comida->id_comida }}">{{ $comida->descripcion }}</p>
                                        <p class="text-gray-700 mb-2" id="precioComida{{ $comida->id_comida }}" data-precio="{{ $comida->precio }}"><b>Precio:</b> {{ $comida->precio }} €</p>
                                        <p class="text-gray-700 mb-2" id="restaurante{{ $comida->id_comida }}" data-idrestaurante="{{ $comida->restaurante->id_restaurante }}">
                                            <b>Restaurante:</b> {{ $comida->restaurante->nom_restaurante }}
                                        </p>

                                    </div>
                                </div>
                                <div class="flex justify-center p-2">
                                    <button class="btn bg-yellow-700  text-white font-bold py-2 px-4 rounded-full mr-4 dark:bg-gray-800" onclick="agregarAlCarrito({{ $comida->id_comida }})">Agregar al carrito</button>
                                    <div class="flex items-center">
                                        <button class="text-blue-500 hover:bg-blue-100 hover:text-white rounded-l px-3" onclick="decrementCantidad({{ $comida->id_comida }})">-</button>
                                        <input class="w-16 py-1 text-center border border-gray-300 rounded" id="cantidad{{ $comida->id_comida }}" value="1" min="1">
                                        <button class="text-blue-500 hover:bg-blue-100 hover:text-white rounded-r px-3" onclick="incrementCantidad({{ $comida->id_comida }})">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="join ml-4 mt-4">
                    @for ($i = 1; $i <= ceil(count($comidas) / 12); $i++)
                        <button class="join-item btn bg-yellow-700 {{ $i == 1 ? 'active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    <script>
        // Verificar si la sesión flash 'success' está presente
        @if(session('success'))
        swal("¡Pedido realizado!", "{{ session('success') }}", "success");
        limpiarCarrito();
        @endif
    </script>
@endsection
