@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')
<!--
    <div class="container">
        <h1>Comidas del restaurante</h1>
        <ul>
            @foreach($comidasRestaurante as $comida)
                <li>{{ $comida->cantidad}}</li>
                <li>{{ $comida->comida->nom_comida}}</li>
                <li>{{ $comida->PEDIDO_id_pedido}}</li>
                <li>{{ $comida->validado}}</li>
            @endforeach
        </ul>
    </div>
-->
    <div class="p-4">
        <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white ml-4 ">Pedidos de venta</h1>
        <!-- Tarjetas de productos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 ml-4">
            @foreach($comidasRestaurante as $comida)
                @if($comida->validado == 0)
                <div id="comida-{{ $comida->comida->id_comida }}" class="rounded-lg shadow-md overflow-hidden bg-white">
                    <img class="w-full h-48 object-cover object-center" src="{{ asset($comida->comida->imagen) }}" alt="{{ $comida->comida->nom_comida }}">
                    <div class="p-4 flex flex-col">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $comida->comida->nom_comida }}</h2>
                            <form action="{{ route('pedido_de_venta.update', ['pedido_id_comida' => $comida->PEDIDO_id_pedido . '_' . $comida->COMIDA_id_comida]) }}" method="POST" class="mb-2" id="formCencelarPedido">
                                @csrf
                                @method('DELETE')
                                <div class="flex items-center">
                                    <button type="submit" class="flex items-center btn btn-ghost cursor-pointer duration-150 hover:text-red-500 btnCancelarPedido">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="h-8 w-8 cursor-pointer duration-150 hover:text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Cancelar Pedido</span>
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
                        <p class="text-gray-700 mb-2"><b>ID Pedido:</b> {{ $comida->PEDIDO_id_pedido }}</p>
                        <p class="text-gray-700 mb-2"><b>Cantidad:</b> {{ $comida->cantidad }}</p>
                        <!-- Formulario para modificar el precio -->
                        <form action="{{ route('pedido_de_venta.update', ['pedido_id_comida' => $comida->PEDIDO_id_pedido . '_' . $comida->COMIDA_id_comida]) }}" method="POST" class="mb-2" id="formValidarProducto">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center">
                                <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 mt-3 rounded-full btnValidarProducto">Crear Pedido de Venta</button>
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
                @endif
            @endforeach
        </div>
    </div>
@endsection

