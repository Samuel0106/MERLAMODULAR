<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personales extends Model
{
    use HasFactory;
    protected $fillable =  [
    'eid',
    'cirugia',
    'vacuna',
    'fecha',
    'inmunizaciones',
    'area',
    'subarea',
    'herencia',
    'tabaquismo',
    'alcholismo',
    'toxicomanias',
    'par_sexuales',
    'fum',
    'menarca',
    'para',
    'aborto',
    'cesaria',
    'ets',
    'anticonceptivos',
    'pap',
    ];
}
