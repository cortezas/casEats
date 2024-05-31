<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mesa;
use App\Http\Requests\StoreMesaRequest;
use App\Http\Requests\UpdateMesaRequest;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function mesasJefe() {
        // Obtiene el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante; 
        $nombreRestaurante = Auth::user()->name;

        // Obtén las mesas asociadas al restaurante del usuario autenticado
        $mesas = Mesa::where('RESTAURANTE_id_restaurante', $restauranteId)->get();

        return view('jefe.mesas_reservadas_jefe', ["mesas" => $mesas, "nombreRestaurante" => $nombreRestaurante]);
    }

    public function reservarMesa(Request $request, $id_mesa)
    {
        // Obtener el día seleccionado desde la solicitud
        $dia = $request->input('dia');
        // Almacenar el ID del Cliente
        $clienteId = Auth::user()->CLIENTE_id_cliente;
        $correoCliente = Auth::user()->email;
        $temp_infouser= $clienteId . ',' . $correoCliente;



        // Lógica para actualizar la reserva de la mesa con el ID proporcionado
        $mesa = Mesa::find($id_mesa);
        if ($dia === 'viernes') {
            // Verificar si la mesa ya está reservada para el viernes
            if ($mesa->estado_viernes !== 'libre') {
                return response()->json(['error' => 'La mesa no está disponible para reservar el viernes en este momento']);
            }

            // Actualizar el estado de la mesa a "pendiente" para el viernes
            $mesa->estado_viernes = 'pendiente';
            $mesa->temp_infouser_viernes = $temp_infouser;
        } elseif ($dia === 'sabado') {
            // Verificar si la mesa ya está reservada para el sábado
            if ($mesa->estado_sabado !== 'libre') {
                return response()->json(['error' => 'La mesa no está disponible para reservar el sábado en este momento']);
            }

            // Actualizar el estado de la mesa a "pendiente" para el sábado
            $mesa->estado_sabado = 'pendiente';
            $mesa->temp_infouser_sabado = $temp_infouser;
        } else {
            // Si el día seleccionado no es válido, devolver un error
            return response()->json(['error' => 'Día seleccionado no válido']);
        }

        // Guardar los cambios en la base de datos
        $mesa->save();

        return redirect()->route('reservar.mesa_cli')->with('success', 'Solicitud de reserva confirmada Se te notificará por correo.');
    }

    public function gestionMesasJefe(Request $request, $id_mesa)
    {
        // Obtener el día y la acción del formulario
        $dia = $request->input('dia');
        $accion = $request->input('accion');

        // Lógica para actualizar la reserva de la mesa con el ID proporcionado
        $mesa = Mesa::find($id_mesa);
        // Obtener los datos del cliente según el día
        if ($dia === 'viernes') {
            $temp_infouser = $mesa->temp_infouser_viernes;
        } elseif ($dia === 'sabado') {
            $temp_infouser = $mesa->temp_infouser_sabado;
        } else {
            
        }


        // Separar los datos del usuario
        if ($mesa->temp_infouser_viernes !== null ||  $mesa->temp_infouser_sabado !== null) {
            list($clienteId, $correoCliente) = explode(',', $temp_infouser);
        }


        // Verificar si el día es viernes o sábado
        if ($dia === 'viernes' || $dia === 'sabado') {
            // Verificar si la acción es "cancelar"
            if ($accion === 'cancelar') {
                // Cambiar el estado de la mesa a "libre"
                if ($dia === 'viernes') {
                    $mesa->estado_viernes = 'libre';
                } elseif ($dia === 'sabado') {
                    $mesa->estado_sabado = 'libre';
                }

                // Guardar los cambios en la base de datos
                $mesa->save();

                // Envía el correo electrónico de cancelación
                
                Mail::send([], [], function (Message $message) use ($correoCliente) {
                    $message->to($correoCliente)
                        ->subject('Cancelación de reserva')
                        ->text('Su reserva ha sido cancelada. Sentimos los inconvenientes.');
                });
                
            }
            // Verificar si la acción es "aceptar"
            elseif ($accion === 'aceptar') {
                // Cambiar el estado de la mesa a "ocupada"
                if ($dia === 'viernes') {
                    $mesa->estado_viernes = 'ocupada';
                } elseif ($dia === 'sabado') {
                    $mesa->estado_sabado = 'ocupada';
                }

                // Guardar los cambios en la base de datos
                $mesa->save();

                // Obtener la capacidad de la mesa desde la base de datos
                $capacidad = $mesa->capacidad;
                $restaurante = $mesa->restaurante->nom_restaurante;

                // Crear una nueva reserva
                $reserva = new Reserva();
                $reserva->fecha = date('Y-m-d'); // Fecha actual
                $reserva->hora = date('H:i:s'); // Hora actual
                $reserva->CLIENTE_id_cliente = $clienteId; // ID del cliente obtenido anteriormente
                $reserva->MESA_id_mesa = $id_mesa; // ID de la mesa
                $reserva->save();
                // Envía el correo electrónico de confirmación
                
                Mail::send([], [], function (Message $message) use ($correoCliente, $id_mesa, $capacidad, $restaurante) {
                    $message->to($correoCliente)
                            ->subject('Confirmación de reserva')
                            ->text("Su reserva ha sido confirmada con éxito. ¡Gracias por elegir $restaurante !\n\nMesa: $id_mesa, Capacidad: $capacidad");
                });
                
                
            }
            elseif ($accion === 'ocupada') {
                // Cambiar el estado de la mesa a "ocupada"
                if ($dia === 'viernes') {
                    $mesa->estado_viernes = 'ocupada';
                } elseif ($dia === 'sabado') {
                    $mesa->estado_sabado = 'ocupada';
                }

                // Guardar los cambios en la base de datos
                $mesa->save();

                // Obtener un cliente aleatorio existente de la base de datos
                $clienteAleatorio = Cliente::inRandomOrder()->first();


                $clienteId = rand(100, 500);
                // Crear una nueva reserva
                $reserva = new Reserva();
                $reserva->fecha = date('Y-m-d'); // Fecha actual
                $reserva->hora = date('H:i:s'); // Hora actual
                $reserva->CLIENTE_id_cliente = $clienteAleatorio->id_cliente; // ID del cliente obtenido anteriormente
                $reserva->MESA_id_mesa = $id_mesa; // ID de la mesa
                $reserva->save();
            }
            elseif ($accion === 'desmarcar') {
                // Cambiar el estado de la mesa a "ocupada"
                if ($dia === 'viernes') {
                    $mesa->estado_viernes = 'libre';
                } elseif ($dia === 'sabado') {
                    $mesa->estado_sabado = 'libre';
                }

                // Guardar los cambios en la base de datos
                $mesa->save();
            }
        }
        // Verificar si se han utilizado los datos del usuario
        if (isset($temp_infouser)) {
            // Limpiar las columnas temp_infouser_viernes y temp_infouser_sabado
            if ($dia === 'viernes') {
                $mesa->temp_infouser_viernes = null;
            } elseif ($dia === 'sabado') {
                $mesa->temp_infouser_sabado = null;
            }
            $mesa->save();
        }

        
        return redirect()->route('jefe.mesas_reservadas_jefe')->with('success', 'Reserva modificada. Notificando por correo al cliente');

    }

    public function limpiarMesas(Request $request){
        // Obtén el ID del restaurante asociado al usuario autenticado
        $restauranteId = Auth::user()->RESTAURANTE_id_restaurante;

        // Lógica para cambiar el estado de todas las mesas asociadas al restaurante a "libre"
        Mesa::where('RESTAURANTE_id_restaurante', $restauranteId)
            ->update(['estado_viernes' => 'libre', 'estado_sabado' => 'libre']);
        
        return redirect()->route('jefe.mesas_reservadas_jefe')->with('success', 'Ahora todas las mesas vuelven a estar libres');
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
