@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')

    <style>
        @layer utilities {
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        }
    </style>

    <body>
    <div class="h-screen bg-gray-100 pt-20">
        <h1 class="mb-10 text-center text-2xl font-bold text-gray-900 dark:text-white">Productos Carrito</h1>
        <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
            <div class="rounded-lg md:w-2/3">
                <!-- Aquí se mostrarán los elementos del carrito -->
                <div id="contenidoCarrito"></div>
            </div>
            <!-- Sub total -->
            <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
                <div class="mb-2 flex justify-between">
                    <p class="text-gray-700">Subtotal</p>
                    <p id="subtotalCarrito" class="text-gray-700">$0.00</p> <!-- Aquí se actualizará el subtotal -->
                </div>
                <div class="flex justify-between">
                    <p class="text-gray-700">Envío</p>
                    <p class="text-gray-700">4.99€</p>
                </div>
                <hr class="my-4" />
                <div class="flex justify-between">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Total</p>
                    <div class="">
                        <p id="subtotalCarritoTotal" class="mb-1 text-lg font-bold text-gray-900 dark:text-white">0.00€</p>
                        <p class="text-sm text-gray-700">including VAT</p>
                    </div>
                </div>


                @auth
                    @if(auth()->check() && auth()->user()->role === 'cliente')
                        <form method="POST" action="{{ route('realizar.pedido') }}">
                            @csrf
                            @php
                                // Obtener los datos del carrito desde localStorage
                                    $carritoData = '<script>localStorage.getItem("carrito")</script>';


                                    // Convertir los datos del carrito a un array de PHP
                                    $datosPedido = json_decode($carritoData, true);

                            @endphp
                            <!-- Campo oculto para enviar el array -->
                            <input type="hidden" name="datosPedido" value="{{ json_encode($datosPedido) }}">

                            <!-- Botón de enviar -->
                            <button type="submit" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Realizar pedido</button>
                            <script>
                                @if(session('success'))
                                Swal.fire({
                                    title: '{{ session('success') }}',
                                    icon: 'success',
                                    showConfirmButton: false, // Oculta el botón de confirmación
                                    timer: 2000 // Muestra el mensaje por 2 segundos
                                }).then((result) => {
                                    // Después de que el SweetAlert se cierre automáticamente después de 2 segundos,
                                    // se ejecutará esta función.
                                    limpiarCarrito(); // Limpia el carrito
                                    window.location.replace("{{ url('http://localhost:8000/') }}"); // Redirige a la página principal
                                });
                                @endif
                            </script>
                        </form>
                    @else
                        <button class="mt-6 w-full rounded-md bg-gray-300 py-1.5 font-medium text-gray-500 cursor-not-allowed">Tienes que ser cliente</button>
                    @endif
                @else
                    <button class="mt-6 w-full rounded-md bg-gray-300 py-1.5 font-medium text-gray-500 cursor-not-allowed">Inicia sesión para pagar</button>
                @endauth
            </div>
        </div>
    </div>
    <!-- Encuentra el lugar adecuado en tu vista Blade para colocar el script -->
    <script>
        // Obtener el contenido del localStorage con clave "carrito"
        var carritolist = localStorage.getItem('carrito');

        // Convertir la cadena JSON en un objeto JavaScript
        var carritoObj = JSON.parse(carritolist);

        // Ahora puedes acceder a las propiedades del objeto
        console.log(carritoObj);

        // Por ejemplo, para acceder a la información del primer elemento del carrito
        console.log("ID:", carritoObj[0].id);
        console.log("Nombre:", carritoObj[0].nombre);
        console.log("Descripción:", carritoObj[0].descripcion);
        console.log("Cantidad:", carritoObj[0].cantidad);
        // Y así sucesivamente para cada propiedad que desees acceder

        // Asignar el objeto al campo oculto
        document.querySelector('input[name="datosPedido"]').value = JSON.stringify(carritoObj);

    </script>

    </body>
@endsection
