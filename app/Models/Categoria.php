<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable =  [
        'nombre_cat',
    ];

    public function producto()
    {
        return $this->hasMany(Producto::class);
    }
/*
    public function setNombreCatAttribute($value)
    {
        $this->attributes['nombre_cat'] = strtolower($value);
    }*/
}
