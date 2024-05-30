@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')
    <div class="p-4">
        <div class="flex justify-between items-center ">
            <h1 class="text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white ml-4">Mis Pedidos: {{$clienteName}}</h1>
            <!-- Formulario de búsqueda por ID de pedido -->
            <div class="p-2 mb-4">
                <form action="{{ route('mis_pedidos_cli', ['id_pedido' => $id_pedido ?? null]) }}" method="GET">
                    <label for="id_pedido" class="block mb-2">Filtrar por ID de Pedido:</label>
                    <input type="text" name="id_pedido" id="id_pedido" class="border border-gray-300 rounded-md p-2" placeholder="Ingrese el ID de Pedido">
                    <button type="submit" class="bg-yellow-700 text-white px-4 py-2 rounded-md ml-2">Buscar</button>
                </form>
                @if(request()->has('id_pedido'))
                    <a href="{{ route('cliente.mis_pedidos_cli') }}" class="text-blue-500 mt-2 block">Mostrar Todos</a>
                @endif
            </div>
        </div>

        <div class="p-4 grid grid-cols-2 gap-4">
            @foreach($pedidosComidaCliente->groupBy('PEDIDO_id_pedido') as $pedido_id => $comidasPedido)
                <div class="rounded-lg shadow-md overflow-hidden bg-white mb-4 border-2 border-gray-300">
                    <div class="p-4 bg-amber-300 border-b border-gray-300">
                        <h2 class="text-xl font-extrabold">Pedido ID: {{ $pedido_id }}</h2>
                    </div>
                    <div class="border-b border-gray-200 p-4 bg-gray-50">
                        <!-- Detalles de las comidas del pedido -->
                        @php
                            $precioTotalPedido = 0; // Variable para almacenar el precio total del pedido
                        @endphp
                        @foreach($comidasPedido as $comida)
                            <div class="flex items-center mb-4">
                                @if(isset($comida->comida))
                                    <img class="w-20 h-20 object-cover object-center rounded-lg mr-4" src="{{ asset($comida->comida->imagen) }}" alt="{{ $comida->comida->nom_comida }}">
                                    <div>
                                        <p class="text-lg">{{ $comida->comida->nom_comida }}</p>
                                        <p class="text-gray-600 mt-2">Restaurante: {{ $comida->comida->restaurante->nom_restaurante }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <div class="rating" data-pedido-id="{{ $pedido_id }}">
                                            <input type="radio" name="rating-{{ $pedido_id }}" class="mask mask-star-2 bg-orange-400" />
                                            <input type="radio" name="rating-{{ $pedido_id }}" class="mask mask-star-2 bg-orange-400" />
                                            <input type="radio" name="rating-{{ $pedido_id }}" class="mask mask-star-2 bg-orange-400" />
                                            <input type="radio" name="rating-{{ $pedido_id }}" class="mask mask-star-2 bg-orange-400" />
                                            <input type="radio" name="rating-{{ $pedido_id }}" class="mask mask-star-2 bg-orange-400" />
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php
                                $precioTotalPedido += $comida->comida->precio; // Sumar el precio de la comida al precio total del pedido
                            @endphp
                        @endforeach
                    </div>
                    <div class="p-4 bg-amber-300 border-t border-gray-300">
                        <h2 class="text-xl font-extrabold">Precio total: {{ $precioTotalPedido }} €</h2>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="join ml-4 mt-4">
            @for ($i = 1; $i <= ceil(count($pedidosComidaCliente) / 12); $i++)
                <button class="join-item btn btn-square{{ $i == 1 ? 'active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
            @endfor
        </div>
        
    </div>
@endsection

@section('footer')
        <!-- Ocultar la seccion de buscadores -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingContainers = document.querySelectorAll('.rating');

        ratingContainers.forEach((container, index) => {
            const pedidoId = container.getAttribute('data-pedido-id');
            const savedRating = localStorage.getItem(`rating-${pedidoId}`);

            if (savedRating) {
                const ratingInputs = container.querySelectorAll('input[type="radio"]');
                ratingInputs[savedRating - 1].checked = true;
            } else {
                const ratingInputs = container.querySelectorAll('input[type="radio"]');
                const randomIndex = Math.floor(Math.random() * ratingInputs.length);
                ratingInputs[randomIndex].checked = true;
                localStorage.setItem(`rating-${pedidoId}`, randomIndex + 1);
            }
        });
    });
</script>
