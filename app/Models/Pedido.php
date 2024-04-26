<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pedido'; // Para que no coja por defecto id al realizar la consulta
    protected $table="pedidos";
    public $timestamps = false; // Para que no busque update_at
    protected $fillable=['id_pedido','fecha','estado'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RESTAURANTE_id_restaurante', 'id_restaurante');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'CLIENTE_id_cliente', 'id_cliente');
    }

    public function repartidor()
    {
        return $this->belongsTo(Repartidor::class, 'REPARTIDOR_id_repartidor', 'id_repartidor');
    }
}
