<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class view_counter extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pagina',
        'visitas',
    ];
}
