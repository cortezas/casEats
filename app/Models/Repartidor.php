<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_repartidor'; // Para que no coja por defecto id al realizar la consulta
    protected $table="repartidores";
    protected $fillable=['id_repartidor','tlf_repartidor'];
}
