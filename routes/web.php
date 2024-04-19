<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepartidorController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;


Route::resource("alumnos", AlumnoController::class);

Route::resource("clientes", ClienteController::class);

Route::resource("comidas", ComidaController::class);

Route::resource("mesas", MesaController::class);

Route::resource("pedidos", PedidoController::class);

Route::resource("repartidores", RepartidorController::class);

Route::resource("reservas", ReservaController::class);

Route::resource("restaurantes", RestauranteController::class);


Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
