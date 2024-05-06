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

Route::get('/listado_de_pedidos/{id_pedido?}', [PedidoComidaController::class, 'listadoPorPedido'])->name('listado_de_pedidos');

Route::get('/seguimiento_de_pedido', [PedidoComidaController::class, 'seguimientoPedidosRepartidor'])->name('seguimiento_de_pedido');

Route::get('/gestion_de_productos_repar/{id_pedido?}', [PedidoComidaController::class, 'listadoPorPedidoRepar'])->name('repartidor.gestion_de_productos_repar');

Route::get('/listado_de_pedidos', [PedidoComidaController::class, 'listadoDePedidos'])->name('jefe.listado_de_pedidos');

Route::get('/gestion_de_productos_repar', [PedidoComidaController::class, 'listadoDePedidosRepartidor'])->name('repartidor.gestion_de_productos_repar');

Route::put('/pedido_de_venta/{pedido_id_comida}', [PedidoComidaController::class, 'update'])->name('pedido_de_venta.update');

Route::put('/seguimiento_de_pedido/{pedido_id_comida}', [PedidoComidaController::class, 'updateRepartidor'])->name('modificar_estado_repar');

Route::delete('/pedido_de_venta/{pedido_id_comida}', [PedidoComidaController::class, 'destroy'])->name('pedido_de_venta.destroy');

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
