<?php
use App\Http\Controllers;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\GestionDeProductosController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\PedidoComidaController;
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

Route::get('/carrito', [CarritoController::class, 'index'])->name('carritos.carrito');

Route::get('/gestion_de_productos', [GestionDeProductosController::class, 'index'])->name('jefe.gestion_de_productos');

Route::get('/pedido_de_venta', [PedidoComidaController::class, 'index'])->name('jefe.pedido_de_venta');

Route::put('/actualizar-precio/{id_comida}', [GestionDeProductosController::class, 'updatePrecio'])->name('actualizar_precio');

Route::delete('/eliminar-comida/{id_comida}', [GestionDeProductosController::class, 'eliminarComida'])->name('eliminar_comida');

Route::post('/realizar-pedido', [PedidoController::class, 'realizarPedido'])->name('realizar.pedido');




Route::get('/', function () {
    return view('main');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/filtrar-por-precio', [ComidaController::class, 'mostrarComidasPorPrecio'])->name('filtrar_por_precio');
;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
