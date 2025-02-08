<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    protected $primaryKey = 'almacen_clave';

    protected $fillable = ['id','almacen_clave', 'almacen_nombre', 'area_id', 'habilitado', 'jefe_eid'];

    public function setSubareaNombreAttribute($value)
    {
        $this->attributes['almacen_nombre'] = strtolower($value);
    }

    public function getSubareaNombreAttribute($value)
    {
        return ucfirst($value);
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'area_clave');
    }

    public function jefe(){
        return $this->hasOne(Datosuser::class, 'eid', 'jefe_eid');
    }
}
