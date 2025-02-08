<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;
use Auth;

class AlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventarios.almacenes');
    }
    public function index()
    {
        /*if(!Auth::user()->can('inventarios.almacenes')){
            return abort(403);
        }*/
        $almacenes = Almacen::where('area_id', auth()->user()->datos->getArea)->get();
        return view('almacenes', compact('almacenes'));
    }

    public function update(Request $request)
    {
        $almacen = Almacen::where('almacen_nombre', $request->almacen_nombre);
        $almacen->habilitado = $request->habilitado;
        $almacen->save();
    }
}
