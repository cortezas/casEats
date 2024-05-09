@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la sección de buscadores -->
@endsection

@section('contenido')
    <h1 class="text-4xl font-extrabold leading-none tracking-tight  md:text-5xl lg:text-6xl dark:text-white ml-4 p-4 ">Reservar Mesa</h1>
    <div class="flex p-6">
        <div class="w-1/4 bg-gray-100 p-4 rounded-box border-2" style="max-height: 80vh; overflow-y: auto;">
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
            <div id="mapa-mesas" class="mapa-con-desenfoque relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
                <div id="mapa-mesas" class=" relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
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
    <script>
        // Lógica del apartado Mesas
        function solicitarReserva(idMesa, estadoViernes, estadoSabado, diaSeleccionado) {
            var formId = 'formModificarMesa' + idMesa;
            var form = document.getElementById(formId);

            var selectedDay = document.getElementById('select-dia').value;

            // Verificar si el día seleccionado es viernes
            if (selectedDay === 'viernes') {
                // Verificar si la mesa está disponible el viernes (en verde)
                if (estadoViernes === 'libre') {
                    Swal.fire({
                        title: "¿Quieres solicitar la reserva de la mesa?",
                        text: "Esta acción solicitará la reserva de la mesa seleccionada para el " + diaSeleccionado + ".",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, reservar",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Actualizar el valor del campo oculto "dia" en el formulario
                            form.querySelector('.dia').value = diaSeleccionado;
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else {
                    // Si la mesa no está disponible, mostrar un mensaje de error para el viernes
                    Swal.fire("¡La mesa no está disponible para reservar el viernes en este momento!", "", "error");
                }
            }
            // Verificar si el día seleccionado es sábado
            else if (selectedDay === 'sabado') {
                // Verificar si la mesa está disponible el sábado (en verde)
                if (estadoSabado === 'libre') {
                    Swal.fire({
                        title: "¿Quieres solicitar la reserva de la mesa?",
                        text: "Esta acción solicitará la reserva de la mesa seleccionada para el " + diaSeleccionado + ".",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, reservar",
                        cancelButtonText: "Cancelar",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Actualizar el valor del campo oculto "dia" en el formulario
                            form.querySelector('.dia').value = "sabado";
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else {
                    // Si la mesa no está disponible, mostrar un mensaje de error para el sábado
                    Swal.fire("¡La mesa no está disponible para reservar el sábado en este momento!", "", "error");
                }
            }
        }





        document.getElementById('select-dia').addEventListener('change', function() {
            var selectedDay = this.value;
            var mesas = document.querySelectorAll('.mesa');

            mesas.forEach(function(mesa) {
                var estado;
                if (selectedDay === 'viernes') {
                    estado = mesa.dataset.estadoViernes;
                } else if (selectedDay === 'sabado') {
                    estado = mesa.dataset.estadoSabado;
                }

                if (estado === 'libre') {
                    mesa.classList.remove('bg-red-500', 'bg-yellow-300');
                    mesa.classList.add('bg-green-500');
                } else if (estado === 'ocupada') {
                    mesa.classList.remove('bg-green-500', 'bg-yellow-300');
                    mesa.classList.add('bg-red-500');
                } else if (estado === 'pendiente') {
                    mesa.classList.remove('bg-green-500', 'bg-red-500');
                    mesa.classList.add('bg-yellow-300');
                }
            });
        });

        // Simular un evento de cambio al cargar la página para mostrar el estado de las mesas del viernes
        document.getElementById('select-dia').value = 'viernes';
        var event = new Event('change');
        document.getElementById('select-dia').dispatchEvent(event);


        // Filtrar las mesas al cargar la página
        window.onload = function() {
            // Seleccionar un restaurante aleatorio
            var listaRestaurantes = document.querySelectorAll('.restaurante-radio');
            var restauranteAleatorio = listaRestaurantes[Math.floor(Math.random() * listaRestaurantes.length)];
            restauranteAleatorio.checked = true;
            filtrarMesas();
            // Agregar la clase de animación de transición al contenedor del mapa
            document.getElementById('mapa-mesas').classList.add('animacion-transicion');
        };

        // Función para filtrar mesas
        function filtrarMesas() {
            var restauranteSeleccionado = document.querySelector('input[name="restaurante"]:checked').value;
            var mesas = document.querySelectorAll('.mesa');
            var rows = 2; // Número de filas
            var cols = 5; // Número de columnas
            var cellWidth = 1100 / cols; // Ancho de cada celda
            var cellHeight = 500 / rows; // Alto de cada celda
            var occupiedCells = new Set(); // Conjunto de celdas ocupadas

            mesas.forEach(function(mesa) {
                var idRestauranteMesa = mesa.getAttribute('data-restaurante');

                if (restauranteSeleccionado === "" || restauranteSeleccionado === idRestauranteMesa) {
                    var x, y;
                    do {
                        // Asignar aleatoriamente una celda
                        var cellX = Math.floor(Math.random() * cols);
                        var cellY = Math.floor(Math.random() * rows);
                        // Calcular las coordenadas de la mesa dentro de la celda
                        x = cellX * cellWidth + Math.floor(Math.random() * (cellWidth - 100)) + 5; // Ajustar el rango para evitar superposiciones con otras mesas
                        y = cellY * cellHeight + Math.floor(Math.random() * (cellHeight - 100)) + 5; // Ajustar el rango para evitar superposiciones con otras mesas
                    } while (occupiedCells.has(cellX + "-" + cellY)); // Verificar si la celda está ocupada

                    // Agregar la celda ocupada al conjunto
                    occupiedCells.add(cellX + "-" + cellY);

                    mesa.style.display = "block";
                    mesa.style.left = x + "px";
                    mesa.style.top = y + "px";
                } else {
                    mesa.style.display = "none";
                }
            });

            // Remover la clase 'seleccionado' de todos los elementos
            document.querySelectorAll('.restaurante-item').forEach(function(item) {
                item.classList.remove('seleccionado');
            });

            // Agregar la clase 'seleccionado' al restaurante seleccionado
            document.querySelector('input[name="restaurante"]:checked').closest('.restaurante-item').classList.add('seleccionado');
        }

        // Evento clic para los elementos de la lista de restaurantes
        var listaRestaurantes = document.getElementById("lista-restaurantes");
        listaRestaurantes.addEventListener("click", function(event) {
            if (event.target.tagName === 'INPUT') {
                filtrarMesas();
            }
        });
    </script>
@endsection

