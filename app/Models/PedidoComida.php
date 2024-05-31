<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoComida extends Model
{
    protected $table = 'pedido_comida'; 



    protected $fillable = ['cantidad', 'COMIDA_id_comida', 'PEDIDO_id_pedido', 'validado', 'RESTAURANTE_id_restaurante'];

    public $timestamps = false; 

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
        return $this->belongsTo(Restaurante::class, 'RESTAURANTE_id_restaurante', 'id_restaurante');
    }


}
