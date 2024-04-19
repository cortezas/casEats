<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table="alumnos"; // Tabla de base de datos
    protected $fillable=['dni','nombre','dir','email']; // Sirve para mandar un array para no ir campo a campo
}
