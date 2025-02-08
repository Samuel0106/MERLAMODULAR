<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidoespecial extends Model
{
    use HasFactory;
    protected $table = "pedidoespecial";
    protected $fillable =  [
        'solicitante',
        'responsable',
        'nombre_prod',
        'cantidad',
        'descripcion',
        'foto',
        'justificacion',
        'import',
        'estado',
    ];
}
