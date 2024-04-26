<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_cliente';
    public $timestamps = false; // Para que no busque update_at
    protected $fillable = ['id_cliente','nom_cliente', 'dir_cliente', 'tlf_cliente'];
}
