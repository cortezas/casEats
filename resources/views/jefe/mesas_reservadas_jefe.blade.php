@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la sección de buscadores -->
@endsection

@section('contenido')
    <h1 class="text-4xl font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl dark:text-white ml-4 p-4">Gestión de Mesas: {{$nombreRestaurante}}</h1>
    <div class="flex p-6">
        <div class="w-1/4 bg-gray-100 p-4 rounded-box" style="max-height: 80vh; overflow-y: auto;">
            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white"><b>Información</b></h3>
            <div class="bg-white rounded-lg shadow-md mb-4">
                <div class="p-4 border-b border-gray-200">
                    <input type="radio" name="restaurante" class="restaurante-radio hidden">
                    <span class="font-semibold">Los clientes al solicitar mesas aparecen de forma amarilla </span>

                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md mb-4">
                <div class="p-4 border-b border-gray-200">
                    <input type="radio" name="restaurante" class="restaurante-radio hidden">
                    <span class="font-semibold">Hay dos opciones para usar este sistema:<br>
                <br>- Si queremos cancelar la solicitud, pulsaremos en la mesa amarilla y pulsaremos en "Cancelar Reserva"<br>
                <br>- Si queremos aprobar la solicitud, pulsaremos en la mesa amarilla y daremos en "Aceptar Reserva"</span>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-4">
                    <input type="radio" name="restaurante" class="restaurante-radio hidden">
                    <span class="font-semibold">El botón de "Limpiar Mesas" nos servirá para establecer todas las mesas de nuestro restaurante a "Libre"</span>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md mt-4">
                <div class="p-4">
                    <input type="radio" name="restaurante" class="restaurante-radio hidden">
                    <span class="font-semibold">Si queremos añadir reservas externas a la web (como por ejemplo una llamada telefónica) escogeremos una mesa libre</span>
                </div>
            </div>
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
                <form method="POST" action="{{ route('limpiar_mesas_jefe') }}" class="mb-2 ml-auto" id="formLimpiarMesasJefe">
                    @csrf
                    @method('PUT')
                    <button class="btn bg-yellow-700 text-white ml-auto">Limpiar Mesas</button>
                    @if(session('success'))
                        <script>
                            Swal.fire({
                                title: '{{ session('success') }}',
                                icon: 'success'
                            });
                        </script>
                    @endif
                </form>
            </div>
            <div id="mapa-mesas" class="relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
                <div id="mapa-mesas" class="relative mt-4 border border-gray-400 rounded-md p-2 bg-gray-100">
                    @foreach($mesas as $mesa)
                        <form method="POST" action="{{ route('modificar_estado_mesa_jefe', ['id_mesa' => $mesa->id_mesa]) }}" class="mb-2" id="formModificarMesaJefe{{ $mesa->id_mesa }}">
                            @csrf
                            @method('PUT')
                            <!-- Campo oculto para enviar el día seleccionado -->
                            <input type="hidden" name="dia" class="dia" value="">
                            <!-- Campo oculto para indicar la acción -->
                            <input type="hidden" name="accion" class="accion" value="">
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
        document.getElementById('formLimpiarMesasJefe').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente
            var formId = 'formLimpiarMesasJefe';
            var form = document.getElementById(formId);

            Swal.fire({
                title: '¿Estás seguro de que deseas limpiar todas las mesas?',
                text: 'Esta acción cambiará el estado de todas las mesas a "libre".',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, limpiar mesas'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        // Lógica del apartado Mesas
        function solicitarReserva(idMesa, estadoViernes, estadoSabado, diaSeleccionado) {
            var formId = 'formModificarMesaJefe' + idMesa;
            var form = document.getElementById(formId);

            var selectedDay = document.getElementById('select-dia').value;

            // Verificar si el día seleccionado es viernes
            if (selectedDay === 'viernes') {
                // Verificar si la mesa está disponible el viernes (en amarillo)
                if (estadoViernes === 'pendiente') {
                    // Mostrar diálogo de confirmación para aceptar o cancelar la reserva
                    Swal.fire({
                        title: "¿Qué acción deseas realizar?",
                        text: "Selecciona una opción para la reserva de la mesa seleccionada para el " + diaSeleccionado + ".",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Aceptar Reserva",
                        cancelButtonText: "Cancelar Reserva",
                        showCloseButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Actualizar el valor del campo oculto "dia" y "accion" en el formulario
                            form.querySelector('.dia').value = diaSeleccionado;
                            form.querySelector('.accion').value = 'aceptar';
                            // Enviar el formulario al servidor
                            form.submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Actualizar el valor del campo oculto "dia" y "accion" en el formulario
                            form.querySelector('.dia').value = diaSeleccionado;
                            form.querySelector('.accion').value = 'cancelar';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else if (estadoViernes === 'libre') {
                    // Mostrar diálogo para marcar la mesa como "reservada"
                    Swal.fire({
                        title: "¿Deseas marcar esta mesa como reservada?",
                        text: "Se cambiará el estado de la mesa a 'reservada'.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, marcar como reservada",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.querySelector('.dia').value = diaSeleccionado;
                            form.querySelector('.accion').value = 'ocupada';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "¿Deseas marcar esta mesa como libre?",
                        text: "Se cambiará el estado de la mesa a 'libre'.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, marcar como libre",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.querySelector('.dia').value = "viernes";
                            form.querySelector('.accion').value = 'desmarcar';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                }
            }
            // Verificar si el día seleccionado es sábado
            else if (selectedDay === 'sabado') {
                // Verificar si la mesa está pendiente de reserva para el sábado (en amarillo)
                if (estadoSabado === 'pendiente') {
                    // Mostrar diálogo de confirmación para aceptar o cancelar la reserva
                    Swal.fire({
                        title: "¿Qué acción deseas realizar?",
                        text: "Selecciona una opción para la reserva de la mesa seleccionada para el " + diaSeleccionado + ".",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Aceptar Reserva",
                        cancelButtonText: "Cancelar Reserva",
                        showCloseButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Actualizar el valor del campo oculto "dia" y "accion" en el formulario
                            form.querySelector('.dia').value = "sabado";
                            form.querySelector('.accion').value = 'aceptar';
                            // Enviar el formulario al servidor
                            form.submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Actualizar el valor del campo oculto "dia" y "accion" en el formulario
                            form.querySelector('.dia').value = "sabado";
                            form.querySelector('.accion').value = 'cancelar';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else if (estadoSabado === 'libre') {
                    // Mostrar diálogo para marcar la mesa como "reservada"
                    Swal.fire({
                        title: "¿Deseas marcar esta mesa como reservada?",
                        text: "Se cambiará el estado de la mesa a 'reservada'.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, marcar como reservada",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.querySelector('.dia').value = "sabado";
                            form.querySelector('.accion').value = 'ocupada';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "¿Deseas marcar esta mesa como libre?",
                        text: "Se cambiará el estado de la mesa a 'libre'.",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, marcar como libre",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.querySelector('.dia').value = "sabado";
                            form.querySelector('.accion').value = 'desmarcar';
                            // Enviar el formulario al servidor
                            form.submit();
                        }
                    });
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
            filtrarMesas();
            // Agregar la clase de animación de transición al contenedor del mapa
            document.getElementById('mapa-mesas').classList.add('animacion-transicion');
        };

        // Función para filtrar mesas
        function filtrarMesas() {
            var mesas = document.querySelectorAll('.mesa');
            var numRows = 2; // Número de filas
            var numCols = 5; // Número de columnas
            var cellWidth = 1100 / numCols; // Ancho de cada celda
            var cellHeight = 500 / numRows; // Alto de cada celda
            var occupiedCells = new Set(); // Conjunto de celdas ocupadas

            mesas.forEach(function(mesa) {
                var x, y;
                do {
                    // Asignar aleatoriamente una celda
                    var cellX = Math.floor(Math.random() * numCols);
                    var cellY = Math.floor(Math.random() * numRows);
                    // Verificar si la celda ya está ocupada
                } while (occupiedCells.has(cellX + "-" + cellY)); // Verificar si la celda está ocupada

                // Agregar la celda ocupada al conjunto
                occupiedCells.add(cellX + "-" + cellY);

                // Calcular las coordenadas de la mesa dentro de la celda
                x = cellX * cellWidth + Math.floor(Math.random() * (cellWidth - 100)) + 5; // Ajustar el rango para evitar superposiciones con otras mesas
                y = cellY * cellHeight + Math.floor(Math.random() * (cellHeight - 100)) + 5; // Ajustar el rango para evitar superposiciones con otras mesas

                mesa.style.display = "block";
                mesa.style.left = x + "px";
                mesa.style.top = y + "px";
            });
        }

    </script>
@endsection

