@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la sección de buscadores -->
@endsection

@section('contenido')
    <h1 class="text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white ml-4 p-4">Reservar Mesa</h1>
    <div class="flex p-6">
        <div class="w-1/4 bg-gray-100 p-4 rounded-box" style="max-height: 80vh; overflow-y: auto;">
            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white"><b>Filtrar por Restaurante</b></h3>
            <ul class="text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" id="lista-restaurantes">
                @foreach($restaurantes as $restaurante)
                    <li class="border-b border-gray-200 restaurante-item">
                        <label for="restaurante{{ $restaurante->id_restaurante }}" class="flex items-center p-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                            <input id="restaurante{{ $restaurante->id_restaurante }}" type="radio" name="restaurante" value="{{ $restaurante->id_restaurante }}" class="restaurante-radio hidden">
                            <span class="font-semibold">{{ $restaurante->nom_restaurante }}</span>
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-3/4 relative">
            <!-- Contenedor del mapa -->
            <!-- Leyenda -->
            <div id="informacion" class="flex items-center">
                <h3 class="font-semibold text-gray-900 dark:text-white ml-2"><b>* Todas las reservas de las mesas corresponden al horario de 20:30 a 22:30</b></h3>
                <select id="select-dia" class="select select-warning w-full max-w-xs ml-6">
                    <option value="viernes" selected>Viernes</option>
                    <option value="sabado">Sábado</option>
                </select>
            </div>
            <div id="mapa-mesas" class="relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
                <div id="mapa-mesas" class="relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
                    @foreach($mesas as $mesa)
                        <form method="POST" action="{{ route('modificar_estado_mesa', ['id_mesa' => $mesa->id_mesa]) }}" class="mb-2" id="formModificarMesa{{ $mesa->id_mesa }}">
                            @csrf
                            @method('PUT')
                            <!-- Campo oculto para enviar el día seleccionado -->
                            <input type="hidden" name="dia" class="dia" value="">
                            <div class="mesa absolute"
                                 data-id="{{ $mesa->id_mesa }}"
                                 data-estado-viernes="{{ $mesa->estado_viernes }}"
                                 data-estado-sabado="{{ $mesa->estado_sabado }}"
                                 data-restaurante="{{ $mesa->RESTAURANTE_id_restaurante }}"
                                 onclick="solicitarReserva('{{ $mesa->id_mesa }}', '{{ $mesa->estado_viernes }}', '{{ $mesa->estado_sabado }}', 'viernes')"
                                 style="cursor: pointer;">
                                <span class="text-white text-sm font-semibold px-2 py-1 rounded">Mesa {{ $mesa->id_mesa }}</span>
                            </div>
                            @if(session('success'))
                                <script>
                                    Swal.fire({
                                        title: '{{ session('success') }}',
                                        icon: 'success'
                                    });
                                </script>
                            @endif
                        </form>
                    @endforeach


                </div>
            </div>
            <div class="absolute top-0 right-0 p-4 bg-white border border-gray-300 rounded-lg shadow-md mt-20 ml-1">
                <div class="flex items-center mb-2">
                    <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-gray-700">Mesa libre</span>
                </div>
                <div class="flex items-center mb-2">
                    <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                    <span class="text-gray-700">Mesa ocupada</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-300 rounded-full mr-2"></div>
                    <span class="text-gray-700">Mesa pendiente</span>
                </div>
            </div>
        </div>
    </div>
@endsection

