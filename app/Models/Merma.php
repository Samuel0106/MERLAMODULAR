<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merma extends Model
{
    use HasFactory;
    protected $fillable =  [
        'producto_id',
        'eid',
        'cantidad',
        'archivo',
        'status'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
