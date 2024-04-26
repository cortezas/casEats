@extends("layouts.layout")

@section('buscador')
    <!-- Ocultar la seccion de buscadores -->
@endsection

@section('contenido')

    <div class="container">
        <h1>Comidas del restaurante</h1>
        <ul>
            @foreach($comidasRestaurante as $comida)
                <li>{{ $comida->cantidad}}</li>
                <li>{{ $comida->comida->nom_comida}}</li>
                <li>{{ $comida->PEDIDO_id_pedido}}</li>
                <li>{{ $comida->validado}}</li>
            @endforeach
        </ul>
    </div>
@endsection
