<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Datosuser extends Model
{
    use HasFactory;

    protected $fillable =  [
        'eid',
        'nombre',
        'paterno',
        'materno',
        'ingreso',
        'antiguedad',
        'contrato',
        'area',
        'puesto',
        'subarea',
    ];

    public function seteidAttribute($value)
    {
        $this->attributes['eid'] = strtoupper($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'eid', 'eid');
    }

    public function getArea()
    {
        return  $this->hasOne(Area::class, 'area_clave', 'area');
    }

    public function getSubarea()
    {
        return $this->hasOne(Subarea::class, 'subarea_clave', 'subarea');
    }

    public function getDivision()
    {
        return $this->hasOne(Division::class, 'division_clave', 'division');
    }

    public function getDiasVac()
    {
        return $this->hasOne(Dia_vac_disponibles::class, 'eid', 'eid');
    }

    public function getSolicitudesVacaciones()
    {
        return $this->hasMany(Solicitudes_vacaciones::class, 'eid', 'eid');
    }

    public function vacacionUsuario(){
        return $this->hasOne(Vacacion_Usuario::class, 'eid', 'eid');
    }

    public function isInPersonalConfianza()
    {
        if(PersonalConfianza::where('eid', $this->eid)->count() > 0)
            return true;
        return false;
    }

    public function scopeHaveAntiquity(){
        return $this->whereNotNull('antiguedad');
    }

    public function contratos(){
        return $this->hasOne(Contratos::class, 'cl_tipco', 'contrato');
    }
}
