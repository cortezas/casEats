@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')
    <div class="p-4">
        <div class="flex justify-between items-center ">
            <h1 class="text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white ml-4">Seguimiento de pedidos</h1>
            <!-- Formulario de búsqueda por ID de pedido -->
            <div class="p-2 mb-4">
                <form action="{{ route('seguimiento_de_pedido', ['id_pedido' => $id_pedido ?? null]) }}" method="GET">

                    <label for="id_pedido" class="block mb-2">Filtrar por ID de Pedido:</label>
                    <input type="text" name="id_pedido" id="id_pedido" class="border border-gray-300 rounded-md p-2" placeholder="Ingrese el ID de Pedido">
                    <button type="submit" class="bg-yellow-700 text-white px-4 py-2 rounded-md ml-2">Buscar</button>
                </form>
                @if(request()->has('id_pedido'))
                    <a href="{{ route('repartidor.seguimiento_de_pedido') }}" class="text-blue-500 mt-2 block">Mostrar Todos</a>
                @endif
            </div>
        </div>
        <!-- Agrupar las comidas por ID de pedido -->
        <div class="p-4 grid grid-cols-2 gap-4">
            <!-- Agrupar las comidas por ID de pedido -->
            @foreach($pedidosComidaRepartidor->groupBy('PEDIDO_id_pedido') as $pedido_id => $comidasPedido)
                <div class="rounded-lg shadow-md overflow-hidden bg-white mb-4">
                    <div class="p-4 bg-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Pedido ID: {{ $pedido_id }}</h2>
                    </div>
                    <div class="border-b border-gray-200 p-4">
                        <!-- Detalles de las comidas del pedido -->
                        @foreach($comidasPedido as $comida) <!-- Utiliza $comidasPedido en lugar de $pedidosComidaRepartidor -->
                        <div class="flex items-center mb-4">

                            @if(isset($comida->comida))
                                <img class="w-20 h-20 object-cover object-center rounded-lg mr-4" src="{{ asset($comida->comida->imagen) }}" alt="{{ $comida->comida->nom_comida }}">
                                <div>
                                    <p class="text-lg">{{ $comida->comida->nom_comida }}</p>
                                    <p class="text-gray-600 mt-2">Restaurante: {{ $comida->comida->restaurante->nom_restaurante }}</p>
                                    <form method="POST" action="{{ route('modificar_estado_repar', ['pedido_id_comida' => $comida->PEDIDO_id_pedido . '_' . $comida->COMIDA_id_comida]) }}" class="mb-2" id="formModificarEstado">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" id="estado_input">
                                        <button type="button" class="bg-yellow-700  text-white font-bold py-2 px-4 mt-3 rounded-full btnModificarEstado">Modificar estado</button>
                                        <!-- Este input hidden es necesario para enviar el ID de la comida junto con el nuevo estado -->
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
                                <!-- Contenedor para la lista de pasos -->
                                <div class="ml-auto">
                                    <div class="steps-container">
                                        <ul class="steps steps-horizontal lg:steps-vertical">
                                            <li class="step @if(in_array($comida->estado, ['sin preparar', 'en cocina', 'enviando', 'entregado', 'pagado'])) step-warning @endif bg">Sin preparar</li>
                                            <li class="step @if(in_array($comida->estado, ['en cocina', 'enviando', 'entregado', 'pagado'])) step-warning @endif">En cocina</li>
                                            <li class="step @if(in_array($comida->estado, ['enviando', 'entregado', 'pagado'])) step-warning @endif">Enviando</li>
                                            <li class="step @if(in_array($comida->estado, ['entregado', 'pagado'])) step-warning @endif">Entregado</li>
                                            <li class="step @if($comida->estado == 'pagado') step-primary @endif">Pagado</li>
                                        </ul>
                                    </div>
                                </div>

                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div class="p-4 bg-gray-100">
                        <h2 class="text-xl font-semibold text-gray-900">Dirección de entrega: {{ $comidasPedido->first()->pedido->cliente->dir_cliente }}</h2>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="join ml-4 mt-4">
            @for ($i = 1; $i <= ceil(count($pedidosComidaRepartidor) / 12); $i++)
                <button class="join-item btn btn-square{{ $i == 1 ? 'active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
            @endfor
        </div>
    </div>
@endsection
