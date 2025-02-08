<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalConfianza extends Model
{
    use HasFactory;
    protected $table = "personal_confianza";
    protected $fillable =  [
        'eid',
        'area',
    ];

    public function getDatosuser()
    {
        return $this->hasOne(Datosuser::class, 'eid', 'eid');
    }
}
