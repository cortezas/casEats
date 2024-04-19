<ul class="menu menu-horizontal lg:menu-horizontal rounded-box mx-5 flex justify-center m-2.5">
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Hamburguesas']) }}" class="filter-icon mx-auto" data-category="Hamburguesa">
            <i class="fas fa-hamburger fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Burgers</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Bocadillos']) }}" class="filter-icon mx-auto" data-category="Bocadillo">
            <i class="fas fa-bread-slice fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Bocadillos</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Bebidas']) }}" class="filter-icon mx-auto" data-category="Bebida">
            <i class="fas fa-beer fa-6x block ml-3"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Bebidas</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Pizzas']) }}" class="filter-icon mx-auto" data-category="Pizza">
            <i class="fas fa-pizza-slice fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white ml-1">Pizzas</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Postres']) }}" class="filter-icon mx-auto" data-category="Postre">
            <i class="fas fa-ice-cream fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Postres</span>
    </li>
    <li class="mr-20 text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Pescados']) }}" class="filter-icon mx-auto" data-category="Pescado">
            <i class="fas fa-fish fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Pescados</span>
    </li>
    <li class="text-center">
        <a href="{{ route('comidas.index', ['categoria' => 'Pescados']) }}" class="filter-icon mx-auto" data-category="Pescado">
            <i class="fas fa-fish fa-6x block"></i>
        </a>
        <span class="text-2xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Pescados</span>
    </li>
</ul>
