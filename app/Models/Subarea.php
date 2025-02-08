<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'subarea_clave';

    protected $fillable = ['id','subarea_clave', 'subarea_nombre'];

    public function setSubareaNombreAttribute($value)
    {
        $this->attributes['subarea_nombre'] = strtolower($value);
    }

    public function getSubareaNombreAttribute($value)
    {
        return ucfirst($value);
    }
    public function almacen()
    {
        return $this->hasOne(Almacen::class, 'area_id', 'area_id');
    }

    public function area()
    {
        return $this->hasOne(Area::class, 'area_clave', 'area_id');
    }
    public function division()
    {
        return $this->area->division();
    }

    public function getUsers()
    {
        return $this->hasMany(DatosUser::class, 'subarea', 'subarea_clave');
    }

    public function getSolicitudesVacaciones()
    {
        return $this->belongsToMany(Solicitudes_vacaciones::class, 'datosusers','subarea', 'eid', 'subarea_clave', 'eid');
    }
}
