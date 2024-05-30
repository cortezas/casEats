<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dir_cliente' => ['required', 'string'],
            'tlf_cliente' => ['required', 'string'],
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


// Crear el cliente asociado al usuario
        $cliente = new Cliente([
            'nom_cliente' => $request->name,
            'dir_cliente' => $request->dir_cliente,
            'tlf_cliente' => $request->tlf_cliente,
        ]);

// Guardar el cliente asociado al usuario
        $user->cliente()->save($cliente);

        $user->update([
            'CLIENTE_id_cliente' => $cliente->id_cliente,
        ]);

// Evento de registro
        event(new Registered($user));

// Iniciar sesión del usuario recién registrado
        Auth::login($user);

// Redireccionar al usuario a la página de inicio
        return redirect('/');

    }
}
