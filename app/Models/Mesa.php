<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_mesa'; // Para que no coja por defecto id al realizar la consulta
    protected $table="mesas";
    public $timestamps = false; // Para que no busque update_at
    protected $fillable=['id_mesa','num_mesa','capacidad','ubicacion', 'RESTAURANTE_id_restaurante', 'estado_viernes', 'estado_sabado'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RESTAURANTE_id_restaurante', 'id_restaurante');
    }
}
