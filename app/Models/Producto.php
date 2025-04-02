<?php

namespace App\Models;

use App\Models\Area;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    // public function categoria()
    // {
    //     return $this->hasOne(Categoria::class);
    // }

    protected $fillable =  [
        'nombre_producto',
        'unidad',
        'stock_minimo',
        'id_categoria',
        'area',
        'subarea', 
        'existencias',
        'photo_prod',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id');
    }
    
    public function areas()
    {
        return $this->belongsTo(Area::class, "area", "area_clave");
    }

    public function subareas()
    {
        return $this->belongsTo(Subarea::class, "subarea", "subarea_clave");
    }

    public function almacenes()
    {
        return $this->belongsTo(Almacen::class, "subarea", "almacen_clave");
    }
    
    public function merma()
    {
        return $this->hasMany(Merma::class);
    }

}
