<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comida;
use Illuminate\Support\Facades\Auth;

class GestionDeProductosController extends Controller
{
    //

        public function index()
    {
        // Obtiene el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante;
        $nombreRestaurante = Auth::user()->name;

        // Comidas asociadas al restaurante del usuario autenticado
        $comidas = Comida::where('RESTAURANTE_id_restaurante', $restauranteId)->get();

        return view('jefe.gestion_de_productos', [
            'comidas' => $comidas,
        'nombreRestaurante' => $nombreRestaurante
            ]);
    }

    public function updatePrecio(Request $request, $id_comida)
    {

        $comida = Comida::where('id_comida', $id_comida)->firstOrFail();
        $comida->precio = $request->input('precio');
        $comida->save();

        return redirect()->back()->with('success', 'Precio actualizado correctamente');
    }

    public function eliminarComida(Request $request, $id_comida)
    {
        $comida = Comida::findOrFail($id_comida);
        $comida->delete();

        return redirect()->back()->with('success', 'Comida eliminada correctamente');
    }
}
