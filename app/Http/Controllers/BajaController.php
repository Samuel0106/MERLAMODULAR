<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Baja;
use App\Models\Producto;
use App\Models\Subarea;

class BajaController extends Controller
{
    public function show($id)
    {
        $producto = Producto::query()->where('id', $id)->with(['almacenes', 'subareas'])->first();
        $producto->ubicacion = "Unknow";
        if($producto->subareas){
            $producto->ubicacion = $producto->subareas->subarea_nombre;
        }
        else{
            $producto->ubicacion = $producto->almacenes->almacen_nombre;
        }
        
        $bajas = Baja::where('id_producto', $id)->get();
        return view('productos.historialProducto', compact('bajas', 'producto'));
    }

   
}
