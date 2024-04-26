<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComidaRequest;
use App\Http\Requests\UpdateComidaRequest;
use App\Models\Comida;
use Illuminate\Http\Request;

class ComidaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */

    public function index(Request $request)
    {
        $categoria = $request->query('categoria');

        if ($categoria) {
            $comidas = Comida::where('categoria', $categoria)->with('restaurante')->get();
        } else {
            $comidas = Comida::with('restaurante')->get()->shuffle();
        }

        return view("comidas.comida", ["comidas" => $comidas]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("comidas.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComidaRequest $request)
    {
        //
        $datos = request()->input();
        $comida = new Comida();
        info("Comida: ".$comida);
        $comida->save();
        $comidas = Comida::all();
        return view("comidas.comida", ["comidas" => $comidas]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        $comida = Comida::find($id);
        return view("comidas.edit", ["comida" => $comida]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comida $comida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComidaRequest $request, Comida $comida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comida $comida)
    {
        //
    }

    public function mostrarComidasPorPrecio(Request $request)
    {
        // Obtener los valores de precio mínimo y máximo del formulario
        $precioMinimo = $request->input('precio_minimo');
        $precioMaximo = $request->input('precio_maximo');

        // Filtrar las comidas por precio dentro del rango especificado
        $comidas = Comida::whereBetween('precio', [$precioMinimo, $precioMaximo])->get();

        // Pasar las comidas filtradas a la vista
        return view('comidas.comida', ['comidas' => $comidas]);
    }

}
