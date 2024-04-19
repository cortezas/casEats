<ul class="menu menu-horizontal lg:menu-horizontal rounded-box mx-5 flex justify-center m-2.5">
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Hamburguesas']) }}" class="filter-icon mx-auto" data-category="Hamburguesa" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="hamburguesa" src="{{ asset('images/svg/hamburger-icon.svg') }}"  class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Burgers</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Bocadillos']) }}" class="filter-icon mx-auto" data-category="Bocadillo" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="bocadillo" src="{{ asset('images/svg/bread-icon.svg') }}" class="mt-4">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Bocadillos</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Bebidas']) }}" class="filter-icon mx-auto" data-category="Bebida" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="bebida" src="{{ asset('images/svg/cerveza-icon.svg') }}"  class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Bebidas</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Pizzas']) }}" class="filter-icon mx-auto" data-category="Pizza" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="pizza" src="{{ asset('images/svg/pizza-icon.svg') }}"  class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white ml-2">Pizzas</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Postres']) }}" class="filter-icon mx-auto" data-category="Postre" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="postre" src="{{ asset('images/svg/postre-icon.svg') }}" class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white ml-1">Postres</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Pescados']) }}" class="filter-icon mx-auto" data-category="Pescado" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="pescado" src="{{ asset('images/svg/fish-icon.svg') }}" class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Pescados</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Carnes']) }}" class="filter-icon mx-auto" data-category="Carne" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="bebida" src="{{ asset('images/svg/turkey-icon.svg') }}" class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Carnes</span>
    </li>
    <li class="text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Otros']) }}" class="filter-icon mx-auto" data-category="Carne" style="display: inline-block; width: 120px; height: 120px;">
            <img alt="otro" src="{{ asset('images/svg/otros-icon.svg') }}" class="mt-3">
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white ml-3">Otros</span>
    </li>
</ul>
