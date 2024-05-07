<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Http\Requests\StoreMesaRequest;
use App\Http\Requests\UpdateMesaRequest;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los restaurantes únicos
        $restaurantes = Mesa::with('restaurante')->get()->unique('restaurante.id_restaurante')->pluck('restaurante');

        // Obtener todas las mesas de la base de datos
        $mesas = Mesa::all();

        // Pasar los restaurantes y las mesas a la vista y renderizarla
        return view('cliente.reservar_mesa_cli', ['restaurantes' => $restaurantes, 'mesas' => $mesas]);
    }

    public function reservarMesa(Request $request, $id_mesa)
    {
        // Obtener el día seleccionado desde la solicitud
        $dia = $request->input('dia');
        // Lógica para actualizar la reserva de la mesa con el ID proporcionado
        $mesa = Mesa::find($id_mesa);
        if ($dia === 'viernes') {
            // Verificar si la mesa ya está reservada para el viernes
            if ($mesa->estado_viernes !== 'libre') {
                return response()->json(['error' => 'La mesa no está disponible para reservar el viernes en este momento']);
            }

            // Actualizar el estado de la mesa a "pendiente" para el viernes
            $mesa->estado_viernes = 'pendiente';
        } elseif ($dia === 'sabado') {
            // Verificar si la mesa ya está reservada para el sábado
            if ($mesa->estado_sabado !== 'libre') {
                return response()->json(['error' => 'La mesa no está disponible para reservar el sábado en este momento']);
            }

            // Actualizar el estado de la mesa a "pendiente" para el sábado
            $mesa->estado_sabado = 'pendiente';
        } else {
            // Si el día seleccionado no es válido, devolver un error
            return response()->json(['error' => 'Día seleccionado no válido']);
        }

        // Guardar los cambios en la base de datos
        $mesa->save();

        // Puedes devolver una respuesta si es necesario
        return redirect()->route('reservar.mesa_cli')->with('success', 'Solicitud de reserva confirmada Se te notificará por correo.');
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
    public function store(StoreMesaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesa $mesa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMesaRequest $request, Mesa $mesa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mesa $mesa)
    {
        //
    }
}
