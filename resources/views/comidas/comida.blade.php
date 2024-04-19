@extends("layouts.layout")
@section("contenido")
    <div id="filtrosycomida">
        <div class="flex p-4">
            <div class="w-1/4 bg-gray-200 p-4 rounded-box">
            </div>
            <div class="w-3/4">
                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white ml-4 ">Listado de productos</h1>
                <div class="grid grid-cols-4 gap-4 md:grid-cols-4 ml-4">
                    @foreach($comidas as $key => $comida)

                        <div class="card bg-orange-100 shadow-xl p-5 comida-item" style="display: {{ $key < 4 ? 'block' : 'none' }}">
                            <figure><img class="comida-imagen" src="{{ asset($comida->imagen) }}" alt="{{ $comida->nom_comida }}" />
                            </figure>
                            <div class="card-body">
                                <h2 class="card-title">{{$comida->nom_comida}}</h2>
                                <p >{{$comida->descripcion}}</p>
                                <div class="card-actions justify-end">
                                    <button class="btn btn-primary">{{$comida->precio}} €</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="join ml-4 mt-4">
                    @for ($i = 1; $i <= ceil(count($comidas) / 12); $i++)
                        <button class="join-item btn btn-square{{ $i == 1 ? 'active' : '' }}" data-index="{{ $i }}">{{ $i }}</button>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@endsection

@section("titulo")
@endsection

