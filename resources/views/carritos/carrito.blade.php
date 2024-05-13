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
    <div class="flex">
        @if(auth()->check() && auth()->user()->role === 'cliente')
        <div class="h-screen bg-gray-50 pt-20 w-2/3">
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
                                <div class="flex justify-cente">
                                    <button type="submit" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600 mr-1">Realizar pedido</button>
                                    <button type="submit" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600 ml-1">Pagar Online</button>
                                </div>

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
        <div class="w-1/3">
            <!-- component -->
            <style>@import url(https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css);</style>
            <style>
                /*
                module.exports = {
                    plugins: [require('@tailwindcss/forms'),]
                };
                */
                .form-radio {
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                    display: inline-block;
                    vertical-align: middle;
                    background-origin: border-box;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    flex-shrink: 0;
                    border-radius: 100%;
                    border-width: 2px;
                }

                .form-radio:checked {
                    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
                    border-color: transparent;
                    background-color: currentColor;
                    background-size: 100% 100%;
                    background-position: center;
                    background-repeat: no-repeat;
                }

                @media not print {
                    .form-radio::-ms-check {
                        border-width: 1px;
                        color: transparent;
                        background: inherit;
                        border-color: inherit;
                        border-radius: inherit;
                    }
                }

                .form-radio:focus {
                    outline: none;
                }

                .form-select {
                    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23a0aec0'%3e%3cpath d='M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z'/%3e%3c/svg%3e");
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    -webkit-print-color-adjust: exact;
                    color-adjust: exact;
                    background-repeat: no-repeat;
                    padding-top: 0.5rem;
                    padding-right: 2.5rem;
                    padding-bottom: 0.5rem;
                    padding-left: 0.75rem;
                    font-size: 1rem;
                    line-height: 1.5;
                    background-position: right 0.5rem center;
                    background-size: 1.5em 1.5em;
                }

                .form-select::-ms-expand {
                    color: #a0aec0;
                    border: none;
                }

                @media not print {
                    .form-select::-ms-expand {
                        display: none;
                    }
                }

                @media print and (-ms-high-contrast: active), print and (-ms-high-contrast: none) {
                    .form-select {
                        padding-right: 0.75rem;
                    }
                }
            </style>

            <div class="min-w-screen min-h-screen bg-gray-100 flex items-start justify-center px-5 pb-10 pt-16">
                <div class="w-full mx-auto rounded-lg bg-white shadow-lg p-5 text-gray-700" style="max-width: 600px">
                    <div class="w-full pt-1 pb-5">
                        <div class="bg-indigo-500 text-white overflow-hidden rounded-full w-20 h-20 -mt-16 mx-auto shadow-lg flex justify-center items-center">
                            <i class="mdi mdi-credit-card-outline text-3xl"></i>
                        </div>
                    </div>
                    <div class="mb-10">
                        <h1 class="text-center font-bold text-xl uppercase">Secure payment info</h1>
                    </div>
                    <div class="mb-3 flex -mx-2">
                        <div class="px-2">
                            <label for="type1" class="flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type1" checked>
                                <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png" class="h-8 ml-3">
                            </label>
                        </div>
                        <div class="px-2">
                            <label for="type2" class="flex items-center cursor-pointer">
                                <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type" id="type2">
                                <img src="https://www.sketchappsources.com/resources/source-image/PayPalCard.png" class="h-8 ml-3">
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Name on card</label>
                        <div>
                            <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="John Smith" type="text"/>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold text-sm mb-2 ml-1">Card number</label>
                        <div>
                            <input class="w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="0000 0000 0000 0000" type="text"/>
                        </div>
                    </div>
                    <div class="mb-3 -mx-2 flex items-end">
                        <div class="px-2 w-1/2">
                            <label class="font-bold text-sm mb-2 ml-1">Expiration date</label>
                            <div>
                                <select class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                    <option value="01">01 - January</option>
                                    <option value="02">02 - February</option>
                                    <option value="03">03 - March</option>
                                    <option value="04">04 - April</option>
                                    <option value="05">05 - May</option>
                                    <option value="06">06 - June</option>
                                    <option value="07">07 - July</option>
                                    <option value="08">08 - August</option>
                                    <option value="09">09 - September</option>
                                    <option value="10">10 - October</option>
                                    <option value="11">11 - November</option>
                                    <option value="12">12 - December</option>
                                </select>
                            </div>
                        </div>
                        <div class="px-2 w-1/2">
                            <select class="form-select w-full px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                                <option value="2028">2028</option>
                                <option value="2029">2029</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-10">
                        <label class="font-bold text-sm mb-2 ml-1">Security code</label>
                        <div>
                            <input class="w-32 px-3 py-2 mb-1 border-2 border-gray-200 rounded-md focus:outline-none focus:border-indigo-500 transition-colors" placeholder="000" type="text"/>
                        </div>
                    </div>
                    <div>
                        <button class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-3 font-semibold"><i class="mdi mdi-lock-outline mr-1"></i> PAY NOW</button>
                    </div>
                </div>
            </div>

        </div>
        @else
        <div class="h-screen bg-gray-50 pt-20 w-full">
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
                                    <div class="flex justify-cente">
                                        <button type="submit" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600 mr-1">Realizar pedido</button>
                                        <button type="submit" class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600 ml-1">Pagar Online</button>
                                    </div>

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
        @endif
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
