<?php

namespace App\Http\Controllers;

use App\Models\PedidoComida;
use App\Http\Requests\StorePedidoComidaRequest;
use App\Http\Requests\UpdatePedidoComidaRequest;
use Illuminate\Support\Facades\Auth;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoComidaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PedidoComida $pedidoComida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PedidoComida $pedidoComida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoComidaRequest $request, PedidoComida $pedidoComida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PedidoComida $pedidoComida)
    {
        //
    }
}
