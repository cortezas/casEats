<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    use HasFactory;
    protected $table="comidas";
    protected $fillable=['id_comida','nom_comida','descripcion','precio'];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'RESTAURANTE_id_restaurante', 'id_restaurante');
    }
}
