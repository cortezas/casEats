<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoComida extends Model
{
    protected $table = 'pedido_comida'; // Especifica el nombre de la tabla si no sigue la convención de nombres de Eloquent

    protected $fillable = ['cantidad', 'COMIDA_id_comida', 'PEDIDO_id_pedido', 'validado', 'RESTAURANTE_id_restaurante']; // Especifica los campos que se pueden asignar masivamente

    public $timestamps = false; // Si no necesitas los campos de timestamps created_at y updated_at en esta tabla

    // Relación con el modelo Comida
    public function comida()
    {
        return $this->belongsTo(Comida::class, 'COMIDA_id_comida');
    }

    // Relación con el modelo Pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'PEDIDO_id_pedido');
    }

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RESTAURANTE_id_restaurante');
    }
}
