<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoComida;
use App\Http\Requests\StorePedidoComidaRequest;
use App\Http\Requests\UpdatePedidoComidaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PedidoComidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Obtiene el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante; // Suponiendo que el campo se llame 'restaurante_id'

        $comidasRestaurante = PedidoComida::where('RESTAURANTE_id_restaurante', $restauranteId)->get();

        return view('jefe.pedido_de_venta', ['comidasRestaurante' => $comidasRestaurante]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function listadoDePedidos()
    {
        //
        // Obtiene el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante; // Suponiendo que el campo se llame 'restaurante_id'

        $comidasRestaurante = PedidoComida::where('RESTAURANTE_id_restaurante', $restauranteId)->get();

        return view('jefe.listado_de_pedidos', ['comidasRestaurante' => $comidasRestaurante]);
    }

    public function listadoDePedidosRepartidor()
    {
        // Obtiene el ID del repartidor asociado al usuario autenticado
        $repartidorId = Auth::user()->REPARTIDOR_id_repartidor;

        // Obtener los ID de los pedidos asociados al repartidor
        $pedidosIds = Pedido::where('REPARTIDOR_id_repartidor', $repartidorId)->pluck('id_pedido')->toArray();

        // Obtener los registros de PedidoComida asociados a los pedidos del repartidor
        $pedidosComidaRepartidor = PedidoComida::whereIn('PEDIDO_id_pedido', $pedidosIds)->get();

        // Retornar la vista con los registros de PedidoComida asociados al repartidor
        return view('repartidor.gestion_de_productos_repar', ['pedidosComidaRepartidor' => $pedidosComidaRepartidor]);
    }

    public function seguimientoPedidosRepartidor()
    {
        // Obtiene el ID del repartidor asociado al usuario autenticado
        $repartidorId = Auth::user()->REPARTIDOR_id_repartidor;

        // Obtener los ID de los pedidos asociados al repartidor
        $pedidosIds = Pedido::where('REPARTIDOR_id_repartidor', $repartidorId)->pluck('id_pedido')->toArray();

        // Obtener los registros de PedidoComida asociados a los pedidos del repartidor
        $pedidosComidaRepartidor = PedidoComida::whereIn('PEDIDO_id_pedido', $pedidosIds)->get();

        // Retornar la vista con los registros de PedidoComida asociados al repartidor
        return view('repartidor.seguimiento_de_pedido', ['pedidosComidaRepartidor' => $pedidosComidaRepartidor]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoComidaRequest $request)
    {
        //
    }

    public function listadoPorPedido(Request $request)
    {
        // Obtiene el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante;

        // Obtener el valor del parámetro id_pedido de la consulta GET
        $id_pedido = $request->input('id_pedido');

        // Consultar todos los pedidos del restaurante
        $query = PedidoComida::where('RESTAURANTE_id_restaurante', $restauranteId);

        // Si se proporciona un ID de pedido, aplicar el filtro
        if ($id_pedido) {
            $query->where('PEDIDO_id_pedido', $id_pedido);
        }

        // Obtener los resultados
        $comidasRestaurante = $query->get();

        return view('jefe.listado_de_pedidos', ['comidasRestaurante' => $comidasRestaurante]);
    }

    public function listadoPorPedidoRepar(Request $request)
    {
        // Obtiene el ID del repartidor asociado al usuario autenticado
        $repartidorId = Auth::user()->REPARTIDOR_id_repartidor;

        // Obtener el valor del parámetro id_pedido de la consulta GET
        $id_pedido = $request->input('id_pedido');

        // Consultar todos los pedidos del repartidor
        $query = Pedido::where('REPARTIDOR_id_repartidor', $repartidorId);

        // Si se proporciona un ID de pedido, aplicar el filtro
        if ($id_pedido) {
            $query->where('id_pedido', $id_pedido);
        }

        // Obtener los ID de los pedidos del repartidor
        $pedidosIds = $query->pluck('id_pedido')->toArray();

        // Obtener los registros de PedidoComida asociados a los pedidos del repartidor
        $pedidosComidaRepartidor = PedidoComida::whereIn('PEDIDO_id_pedido', $pedidosIds)->get();


        return view('repartidor.gestion_de_productos_repar', ['pedidosComidaRepartidor' => $pedidosComidaRepartidor]);
    }

    public function update(Request $request, $pedido_id_comida)
    {
        // Dividir el parámetro para obtener id_pedido e id_comida
        list($id_pedido, $id_comida) = explode('_', $pedido_id_comida);

        // Actualizar el campo validado a 1 donde id_pedido y id_comida coincidan
        PedidoComida::where('PEDIDO_id_pedido', $id_pedido)
            ->where('COMIDA_id_comida', $id_comida)
            ->update(['validado' => 1, 'estado' => 'en cocina']);

        // Redirigir a la página deseada después de realizar la actualización
        return redirect()->route('jefe.pedido_de_venta')->with('success', 'Pedido de venta actualizado exitosamente.');
    }

    public function updateRepartidor(Request $request, $pedido_id_comida)
    {
        // Dividir el parámetro para obtener id_pedido e id_comida
        list($id_pedido, $id_comida) = explode('_', $pedido_id_comida);

        // Obtener el nuevo estado seleccionado del formulario
        $nuevoEstado = $request->estado;

        // Actualizar el estado del pedido de comida
        PedidoComida::where('PEDIDO_id_pedido', $id_pedido)
            ->where('COMIDA_id_comida', $id_comida)
            ->update(['estado' => $nuevoEstado]);

        // Redirigir a la página deseada después de realizar la actualización
        return redirect()->route('seguimiento_de_pedido')->with('success', 'Pedido actualizado exitosamente.');
    }

    public function destroy(Request $request, $pedido_id_comida)
    {
        // Dividir el parámetro para obtener id_pedido e id_comida
        list($id_pedido, $id_comida) = explode('_', $pedido_id_comida);

        // Buscar el registro en la base de datos y eliminarlo
        PedidoComida::where('PEDIDO_id_pedido', $id_pedido)
            ->where('COMIDA_id_comida', $id_comida)
            ->delete();

        // Redirigir a la página deseada después de eliminar el registro
        return redirect()->route('jefe.pedido_de_venta')->with('success', 'Pedido de venta eliminado exitosamente.');
    }

}
