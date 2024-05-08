<header class="w-full p-8 ">
    <div class="navbar bg-amber-300 rounded-xl">
        @include('components.layout.nav')
        <div class="flex-1" >
            <a class="text-xl" href="/" >
                <img id="logo-img" src="{{ asset('logo-lightmode.png') }}" alt="Logo Claro" class="h-16 w-auto">
            </a>
        </div>
        <div class="flex-none gap-2">
            @auth
                <div class="name mr-2 bg-yellow-700 text-white p-2 rounded-full">
                    <span>¡Bienvenido, <b>{{ auth()->user()->name }}</b>!</span>
                </div>
            @endauth
            <div class="form-control">
                <input type="text" placeholder="Buscar productos..."
                       class="input input-bordered input-primary w-full max-w-xs"/>
            </div>
            @guest
                <a href="{{route("login")}}" class="btn btn-active btn-primary">Iniciar Sesion</a>
                <a href="{{route("register")}}" class="btn btn-active btn-primary">Registrarme</a>

            @endguest

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="badge badge-sm indicator-item">8</span>
                    </div>
                </div>
                <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-56 bg-base-100 shadow" id="cartContent">
                    <div class="card-body flex justify-between items-center">
                        <div class="flex items-center">
                            <span class="font-bold text-lg" id="cartItemCount">0 Productos</span>
                            <button class="btn btn-sm ml-2" onclick="limpiarCarrito()">Limpiar</button>
                        </div>
                        <span class="text-info" id="cartSubtotal">Precio total: 0.00€</span>
                        <div class="card-actions">
                            <a href="{{ route('carritos.carrito') }}" class="btn btn-primary btn-block">Ver carrito</a>
                        </div>
                    </div>
                </div>

            </div>
            @auth

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                             src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg"/>
                    </div>
                </div>
                <ul tabindex="0"
                    class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li>
                        <a class="justify-between">
                            Modo Oscuro
                            <input id="toggle-darkmode" type="checkbox" value="synthwave" class="toggle theme-controller" onchange="toggleDarkMode()">

                        </a>
                    </li>
                    <li>
                        <form action="{{route("logout")}}" method="post">
                            @csrf
                            <button type="submit">Cerrar Sesion</button>
                        </form>
                    </li>
                </ul>

            </div>
            @endauth
        </div>
    </div>
</header>

