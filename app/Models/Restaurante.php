<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;
    protected $table="restaurantes";
    protected $fillable=['id_restaurante','nom_restaurante','tlf_restaurante','dir_restaurante'];

    public function comidas()
    {
        return $this->hasMany(Comida::class, 'id_restaurante');
    }
}
