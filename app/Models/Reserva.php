<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_reserva'; // Para que no coja por defecto id al realizar la consulta
    protected $table="reservas";
    public $timestamps = false; // Para que no busque update_at
    protected $fillable=['id_reserva', 'fecha', 'hora', 'CLIENTE_id_cliente', 'MESA_id_mesa'];

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'MESA_id_mesa', 'id_mesa');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'CLIENTE_id_cliente', 'id_cliente');
    }
}
