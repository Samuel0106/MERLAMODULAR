<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;

    protected $fillable =  [
        'eid',
        'id_producto',
        'consumidos',
        'area',
        'subarea',
        'archivo',
    ];
}

