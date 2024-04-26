<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    //
    public function index()
    {
        // Recuperar los datos del carrito del localStorage
        $carrito = json_decode(request()->session()->get('carrito'), true);

        // Pasar los datos del carrito a la vista
        return view('carritos.carrito', ['carrito' => $carrito]);
    }
}
