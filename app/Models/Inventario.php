<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable =  [
        'eid',
        'nombre',
        'email',
        'almacen',
        'area',
        'subarea',
        'status',
        'comentario',
        'carrito',
        'oculto',
        //'proposito',
        'fecha_entrega',
        'fecha_autorizado',
        'foto_entrega',
        'fecha_estimada',
    ];

    protected $casts = [
        'carrito' => 'array'
    ];

    public function subareas()
    {
        return $this->hasMany(Subarea::class, 'subarea_clave', 'subarea');
    }
    public function almacenes()
    {
        return $this->hasMany(Almacen::class, 'almacen_clave', 'almacen');
    }
    
}
