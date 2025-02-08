<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;
    protected $fillable =  [
        'division_clave',
        'division_nombre'

    ];

    protected $table = 'divisiones';

    public function areas()
    {
        return $this->hasMany('App\Models\Area', 'division_id', 'division_clave');
    }
    public function getUsers()
    {
        return $this->hasMany(DatosUser::class, 'division', 'division_clave');
    }
    public function getSolicitudesVacaciones()
    {
        return $this->belongsToMany(Solicitudes_vacaciones::class, 'datosusers','division', 'eid', 'division_clave', 'eid');
    }

}
