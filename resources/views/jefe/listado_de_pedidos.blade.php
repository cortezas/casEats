@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')
    <div class="p-4">
        <div class="flex justify-between items-center ">
            <h1 class="text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white ml-4">Listado de pedidos</h1>
            <!-- Formulario de búsqueda por ID de pedido -->
            <div class="p-2 mb-4">
                <form action="{{ route('listado_de_pedidos', ['id_pedido' => $id_pedido ?? null]) }}" method="GET">

                <label for="id_pedido" class="block mb-2">Filtrar por ID de Pedido:</label>
                    <input type="text" name="id_pedido" id="id_pedido" class="border border-gray-300 rounded-md p-2" placeholder="Ingrese el ID de Pedido">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Buscar</button>
                </form>
                @if(request()->has('id_pedido'))
                    <a href="{{ route('listado_de_pedidos') }}" class="text-blue-500 mt-2 block">Mostrar Todos</a>
                @endif
            </div>
        </div>
        <!-- Agrupar las comidas por ID de pedido -->
        <div class="p-4 grid grid-cols-2 gap-4">
            <!-- Agrupar las comidas por ID de pedido -->
            @foreach($comidasRestaurante->groupBy('PEDIDO_id_pedido') as $pedido_id => $comidasPedido)
                <div class="rounded-lg shadow-md overflow-hidden bg-white mb-4">
                    <div class="p-4 bg-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Pedido ID: {{ $pedido_id }}</h2>
                    </div>
                    <div class="border-b border-gray-200 p-4">
                        <!-- Detalles de las comidas del pedido -->
                        @foreach($comidasPedido as $comida)
                            <div class="flex items-center mb-4">
                                @if(isset($comida->comida))
                                    <img class="w-20 h-20 object-cover object-center rounded-lg mr-4" src="{{ asset($comida->comida->imagen) }}" alt="{{ $comida->comida->nom_comida }}">
                                    <div>
                                        <p class="text-lg">{{ $comida->comida->nom_comida }}</p>
                                        <p class="text-gray-600 mt-2">
                                            Cantidad: {{$comida->cantidad}}
                                        </p>
                                        <p class="text-gray-600">Estado:
                                            <span class="rounded-md px-2 py-1 inline-block mt-2
                                                    @if($comida->estado == 'sin preparar')
                                                        bg-orange-200 text-yellow-800
                                                    @elseif($comida->estado == 'en cocina')
                                                        bg-yellow-200 text-orange-800
                                                    @elseif($comida->estado == 'enviando')
                                                        bg-blue-200 text-blue-800
                                                    @elseif($comida->estado == 'entregado')
                                                        bg-green-200 text-green-800
                                                    @elseif($comida->estado == 'pagado')
                                                        bg-purple-200 text-purple-800
                                                    @endif
                                                ">
                                                {{ $comida->estado }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="ml-auto flex items-center">
                                        <div class="p-4 bg-gray-100 flex justify-center items-center">
                                            <h2 class="text-xl font-semibold text-gray-900">Pagado&nbsp;</h2>
                                            <input type="checkbox" class="form-checkbox h-6 w-6 text-green-500">
                                        </div>
                                    </div>
                                @endif
                            </div>

                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>


        <div class="join ml-4 mt-4">
            @for ($i = 1; $i <= ceil(count($comidasRestaurante) / 12); $i++)
                <button class="join-item btn btn-square{{ $i == 1 ? 'active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
            @endfor
        </div>
        <!--
                <div class="p-4">
                    <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white ml-4">Listado de pedidos</h1>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($comidasRestaurante->groupBy('PEDIDO_id_pedido') as $pedido_id => $comidasPedido)
                        <div class="rounded-lg shadow-md overflow-hidden bg-white">
                            <div class="p-4 bg-gray-100">
                                <h2 class="text-xl font-semibold text-gray-900">Pedido ID: {{ $pedido_id }}</h2>
                            </div>
                            <div class="border-b border-gray-200 p-4">
                                @foreach($comidasPedido as $comida)
                            <div class="flex items-center mb-4">
                                <img class="w-20 h-20 object-cover object-center rounded-lg mr-4" src="{{ asset($comida->comida->imagen) }}" alt="{{ $comida->comida->nom_comida }}">
                                        <div>
                                            <p class="text-lg">{{ $comida->comida->nom_comida }}</p>
                                            <p class="text-gray-600 mt-2">
                                                Cantidad: {{$comida->cantidad}}
                            </p>
                            <p class="text-gray-600">Estado:
                                <span class="rounded-md px-2 py-1 inline-block mt-2
            @if($comida->estado == 'sin preparar')
                                bg-orange-200 text-yellow-800
            @elseif($comida->estado == 'en cocina')
                                bg-yellow-200 text-orange-800
            @elseif($comida->estado == 'enviando')
                                bg-blue-200 text-blue-800
            @elseif($comida->estado == 'entregado')
                                bg-green-200 text-green-800
            @elseif($comida->estado == 'pagado')
                                bg-purple-200 text-purple-800
            @endif
                            ">
            {{ $comida->estado }}
                            </span>
                    </p>
                </div>
            </div>
            @endforeach
                        </div>
                    </div>
            @endforeach
                    </div>
                    </div>
            -->
    </div>
@endsection
