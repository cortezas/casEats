document.addEventListener('DOMContentLoaded', function() {
    const joinItems = document.querySelectorAll('.join-item');
    const comidaItems = document.querySelectorAll('.comida-item');
    const restaurantesCheckbox = document.querySelectorAll('.restaurante-checkbox');
    const actualizarPrecioButtons = document.querySelectorAll('.btnActualizarPrecio');
    const eliminarProductoForms = document.querySelectorAll('#formEliminarProducto');
    const btnValidarProducto = document.querySelectorAll('.btnValidarProducto');
    const btnCancelarPedido = document.querySelectorAll('.btnCancelarPedido');
    const btnModificarEstado = document.querySelectorAll('.btnModificarEstado');


    btnModificarEstado.forEach(btn => {
        btn.addEventListener('click', function() {
            // Obtener el formulario asociado al botón clickeado
            const form = btn.closest('form');


            // Muestra la ventana de confirmación de SweetAlert2
            Swal.fire({
                title: 'Selecciona un nuevo estado',
                input: 'select',
                inputOptions: {
                    'sin preparar': 'Sin preparar',
                    'en cocina': 'En cocina',
                    'enviando': 'Enviando',
                    'entregado': 'Entregado',
                    'pagado': 'Pagado'
                },
                inputPlaceholder: 'Selecciona un estado',
                showCancelButton: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                // Si el usuario confirma y selecciona un estado, envía la solicitud al servidor
                if (result.isConfirmed) {
                    // Si se confirma la acción, envía el formulario asociado
                    form.querySelector('#estado_input').value = result.value;
                    form.submit();
                }
            });
        });
    });


    btnCancelarPedido.forEach(btn => {
        btn.addEventListener('click', function() {
            // Obtener el formulario asociado al botón clickeado
            const form = btn.closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres eliminar el pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma la acción, envía el formulario asociado
                    form.submit();
                }
            });
        });
    });

    btnValidarProducto.forEach(btn => {
        btn.addEventListener('click', function() {
            // Obtener el formulario asociado al botón clickeado
            const form = btn.closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres validar el pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma la acción, envía el formulario asociado
                    form.submit();
                }
            });
        });
    });




    eliminarProductoForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío automático del formulario

            // Obtener el botón de submit clickeado
            const submitButton = form.querySelector('[type="submit"]');

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres eliminar este producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma la acción, enviar el formulario
                    form.submit();
                }
            });

        });
    });




    // Iterar sobre cada botón y agregar un event listener
    actualizarPrecioButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtener el formulario asociado al botón clickeado
            const form = button.closest('form');

            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Quieres actualizar el producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma la acción, envía el formulario asociado
                    form.submit();
                }
            });
        });
    });




    // Recuperar el contenido del carrito del almacenamiento local al cargar la página
    if(localStorage.getItem('carrito')) {
        carrito = JSON.parse(localStorage.getItem('carrito'));
        actualizarContenidoCarrito(); // Actualizar el contenido del carrito
    }

    // Mostrar las primeras 12 comidas al cargar la página
    mostrarPrimerasComidas();

    restaurantesCheckbox.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const restaurantesSeleccionados = Array.from(document.querySelectorAll('.restaurante-checkbox:checked')).map(checkbox => checkbox.value);

            if (restaurantesSeleccionados.length === 0) {
                // Si no hay ningún restaurante seleccionado, mostrar solo las primeras 12 comidas
                mostrarPrimerasComidas();
            } else {
                // Filtrar comidas basadas en los restaurantes seleccionados
                filtrarComidas(restaurantesSeleccionados);
            }
        });
    });

    joinItems.forEach(item => {
        item.addEventListener('click', () => {
            const index = parseInt(item.getAttribute('data-index'));

            // Ocultar todas las comidas
            ocultarTodasLasComidas();

            // Mostrar las comidas correspondientes al índice
            const startIndex = (index - 1) * 12;
            const endIndex = startIndex + 12;
            for (let i = startIndex; i < endIndex && i < comidaItems.length; i++) {
                comidaItems[i].style.display = 'block';
            }

            // Quitar la clase 'active' de todos los botones y añadirla al botón clickeado
            joinItems.forEach(joinItem => {
                joinItem.classList.remove('active');
            });
            item.classList.add('active');
        });
    });

    mostrarContenidoCarrito();
});

function mostrarPrimerasComidas() {
    const comidaItems = document.querySelectorAll('.comida-item');
    for (let i = 0; i < 12 && i < comidaItems.length; i++) {
        comidaItems[i].style.display = 'block';
    }
}

function ocultarTodasLasComidas() {
    const comidaItems = document.querySelectorAll('.comida-item');
    comidaItems.forEach(comida => {
        comida.style.display = 'none';
    });
}

function filtrarComidas(restaurantesSeleccionados) {
    const comidaItems = document.querySelectorAll('.comida-item');
    comidaItems.forEach(comida => {
        const restauranteId = comida.getAttribute('data-restaurante');
        if (restaurantesSeleccionados.includes(restauranteId)) {
            comida.style.display = 'block';
        } else {
            comida.style.display = 'none';
        }
    });
}

function actualizarPrecio(comidaId) {
    // Obtener el valor de la cantidad y el precio por unidad
    var cantidad = document.getElementById("cantidad" + comidaId).value;
    var precioUnitario = document.getElementById("precioComida" + comidaId).getAttribute("data-precio");

    // Calcular el precio total
    var precioTotal = cantidad * precioUnitario;

    // Mostrar el precio total actualizado
    var precioTexto = "<b>Precio:</b> " + precioTotal.toFixed(2) + " €";
    document.getElementById("precioComida" + comidaId).innerHTML = precioTexto;
}

function incrementCantidad(comidaId) {
    var cantidadInput = document.getElementById("cantidad" + comidaId);
    cantidadInput.value = parseInt(cantidadInput.value) + 1;
    actualizarPrecio(comidaId);
}

function decrementCantidad(comidaId) {
    var cantidadInput = document.getElementById("cantidad" + comidaId);
    if (parseInt(cantidadInput.value) > 1) {
        cantidadInput.value = parseInt(cantidadInput.value) - 1;
        actualizarPrecio(comidaId);
    }
}

// Función para agregar una comida al carrito
let carrito = [];

function agregarAlCarrito(idComida) {
    Swal.fire({
        title: "Producto añadido al carrito!",
        icon: "success"
    });
    let nombre = document.getElementById('nombreComida' + idComida).innerText;
    let descripcion = document.getElementById('descripcionComida' + idComida).innerText;
    let cantidad = parseInt(document.getElementById('cantidad' + idComida).value);
    let precioUnitario = parseFloat(document.getElementById('precioComida' + idComida).dataset.precio);
    let restauranteId = document.getElementById('restaurante' + idComida).dataset.idrestaurante;
    let precioTotal = cantidad * precioUnitario;
    let imagen = document.getElementById('imagenComida' + idComida).getAttribute('data-imagen');


    let comida = {
        id: idComida,
        nombre: nombre,
        descripcion: descripcion,
        cantidad: cantidad,
        precioUnitario: precioUnitario,
        precioTotal: precioTotal,
        imagen: imagen,
        restaurante: restauranteId
    };
    carrito.push(comida);

    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContenidoCarrito();
    console.log(carrito); // Puedes eliminar esta línea, es solo para propósitos de depuración
    // Guardar el contenido del carrito en el almacenamiento local
}

function actualizarContenidoCarrito() {
    let itemCount = 0;
    let subtotal = 0;

    // Calcular el número total de ítems y el subtotal del carrito
    for (let i = 0; i < carrito.length; i++) {
        itemCount += carrito[i].cantidad;
        subtotal += carrito[i].precioTotal;
    }

    // Actualizar el contenido en el HTML
    document.getElementById('cartItemCount').textContent = `${itemCount} Productos`;
    document.getElementById('cartSubtotal').textContent = `Precio Total: ${subtotal.toFixed(2)}€`;
}

function limpiarCarrito(){
    // Eliminar el contenido del carrito del almacenamiento local
    localStorage.removeItem('carrito');

    // Actualizar el contenido del carrito en el HTML
    document.getElementById('cartItemCount').textContent = '0 Productos';
    document.getElementById('cartSubtotal').textContent = 'Precio total: 0.00€';

    // También puedes limpiar la variable carrito si lo deseas
    carrito = [];
}

function mostrarContenidoCarrito() {
    // Obtener el elemento donde se mostrará el contenido del carrito
    const contenidoCarrito = document.getElementById('contenidoCarrito');
    const subtotalElement = document.getElementById('subtotalCarrito');
    const subtotalCarritoTotal = document.getElementById('subtotalCarritoTotal');

    // Verificar si hay contenido en el carrito
    if (localStorage.getItem('carrito')) {
        // Obtener el contenido del carrito del almacenamiento local
        const carrito = JSON.parse(localStorage.getItem('carrito'));

        // Crear un objeto para agrupar los ítems del carrito por tipo
        const groupedItems = {};

        // Agrupar los ítems del carrito por tipo
        carrito.forEach(function(item) {
            if (groupedItems[item.id]) {
                groupedItems[item.id].cantidad += item.cantidad;
            } else {
                groupedItems[item.id] = { ...item };
            }
        });

        // Crear HTML para mostrar cada ítem del carrito
        let contenidoHTML = '';
        let subtotal = 0; // Inicializar el subtotal

        Object.values(groupedItems).forEach(function(item) {
            contenidoHTML += `
                <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                    <img src="${item.imagen}" alt="${item.nombre}" class="w-full rounded-lg sm:w-40" />
                    <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                        <div class="mt-5 sm:mt-0">
                            <h2 class="text-lg font-bold text-gray-900">${item.nombre}</h2>
                            <p class="mt-1 text-xs text-gray-700">${item.descripcion}</p>
                        </div>
                        <div class="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                            <div class="flex items-center border-gray-100">
                                <span class="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50" onclick="decrementCantidad(${item.id})"> - </span>
                                <input id="cantidad${item.id}" class="h-8 w-8 border bg-white text-center text-xs outline-none" type="number" value="${item.cantidad}" min="1" readonly />
                                <span class="cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50" onclick="incrementCantidad(${item.id})"> + </span>
                            </div>
                            <div class="flex items-center space-x-5">
                                <p class="text-sm">${(item.precioUnitario * item.cantidad).toFixed(2)} €</p>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 cursor-pointer duration-150 hover:text-red-500" onclick="eliminarDelCarrito(${item.id})">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            subtotal += item.precioUnitario * item.cantidad; // Actualizar el subtotal
        });

        // Sumar 4.99 al subtotal del carrito
        const nuevoSubtotal = subtotal + 4.99;
        // Actualizar el subtotal del carrito en el HTML
        subtotalElement.textContent = `${subtotal.toFixed(2)}€`;

        // Actualizar el subtotal del carrito total en el HTML
        subtotalCarritoTotal.textContent = `${nuevoSubtotal.toFixed(2)}€`;
        // Actualizar el contenido del elemento HTML con el contenido del carrito
        contenidoCarrito.innerHTML = contenidoHTML;
        console.log("Contenido del carrito actualizado:", contenidoHTML); // Agregar registro de consola
        console.log("Subtotal del carrito:", subtotal); // Agregar registro de consola

    } else {
        // Si no hay contenido en el carrito, mostrar un mensaje indicando que está vacío
        contenidoCarrito.innerHTML = '<p>El carrito está vacío</p>';
    }
}

function eliminarDelCarrito(comidaId) {
    // Buscar el índice del producto en el carrito
    const index = carrito.findIndex(item => item.id === comidaId);

    // Verificar si se encontró el producto en el carrito
    if (index !== -1) {
        // Eliminar el producto del carrito
        carrito.splice(index, 1);

        // Actualizar el carrito en el almacenamiento local
        localStorage.setItem('carrito', JSON.stringify(carrito));

        // Actualizar el contenido del carrito en la página
        mostrarContenidoCarrito();
    }
}

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




