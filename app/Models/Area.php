<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'area_clave';

    protected $fillable = ['id', 'area_clave', 'area_nombre', 'division_id', 'tipo'];

    public function setAreaNombreAttribute($value)
    {
        $this->attributes['area_nombre'] = strtolower($value);
    }

    public function getAreaNombreAttribute($value)
    {
        return ucfirst($value);
    }

    public function subareas()
    {
        return $this->hasMany(Subarea::class, 'area_id', 'area_clave');
    }

    public function division()
    {
        return $this->hasOne(Division::class, 'division_clave', 'division_id');
    }

    public function getUsers()
    {
        return $this->hasManyThrough(
        Datosuser::class, //Modelo objetivo
        Subarea::class, //Modelo intermedio
        'area_id', //llave foranea del modelo intermedio
        'subarea', //llave foranea del modelo objetivo
        'area_clave', //Llave local del modelo actual
        'subarea_clave'); //Llave local de modelo intermedio
    }

    public function getSolicitudesVacaciones()
    {
        return $this->belongsToMany(Solicitudes_vacaciones::class, 'datosusers','area', 'eid', 'area_clave', 'eid');
    }
}
