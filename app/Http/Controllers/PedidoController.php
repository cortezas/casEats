<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\PedidoComida;
use App\Models\Repartidor;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function realizarPedido(Request $request)
    {
        // Obtener el array enviado desde el formulario y decodificarlo
        $datosPedido = json_decode($request->datosPedido, true);


        $repartidor = $this->obtenerRepartidorAleatorio();

        // Insertar nuevo registro en la tabla 'pedidos'
        $pedido = new Pedido();
        $pedido->fecha = now();
        $pedido->estado = 'sin preparar';
        $pedido->CLIENTE_id_cliente = $request->user()->id;
        $pedido->REPARTIDOR_id_repartidor = $repartidor->id_repartidor;
        $pedido->save();

        // Obtener el ID del pedido recién creado
        $pedidoId = $pedido->id_pedido;

        // Iterar sobre los elementos del array $datosPedido y guardarlos en la tabla 'pedido_comida'
        foreach ($datosPedido as $item) {
            $pedidoComida = new PedidoComida();
            $pedidoComida->cantidad = $item['cantidad'];
            $pedidoComida->COMIDA_id_comida = $item['id'];
            $pedidoComida->PEDIDO_id_pedido = $pedidoId;
            $pedidoComida->save();
        }

        // Redirigir a la ruta principal
        return redirect()->back()->with('success', 'Pedido creado correctamente');
    }



    // Método para obtener un repartidor aleatorio
    private function obtenerRepartidorAleatorio()
    {
        return Repartidor::inRandomOrder()->first();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
