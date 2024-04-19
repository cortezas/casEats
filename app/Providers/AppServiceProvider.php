<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Comida;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Obtener todas las comidas de la base de datos en un orden aleatorio
        $comidasAleatorias = Comida::inRandomOrder()->get();

        // Compartir las comidas aleatorias con todas las vistas
        view()->share('comidas', $comidasAleatorias);
    }
}
