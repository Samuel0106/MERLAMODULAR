<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\Merma;
use App\Models\Producto;
use App\Models\Subarea;
use App\Models\Almacen;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MermaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:inventario.mermas');
    }
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $mermas = Merma::all();
        } else {
            if (auth()->user()->datos->subarea == 'DN07') { //Si usuario de Edificio Divisional
                $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get(); //Almacenes donde el usuario es Jefe
                $productos = collect([]);
                foreach ($almacenes as $a) {
                    $prod = Producto::where('subarea', $a->almacen_clave)->get(); //Todos los productos de cada almacen
                    $productos = $productos->merge($prod);
                }
                $mermas = collect([]);
                foreach ($productos as $p) {
                    /* Todas las mermas de los productos NO realizadas por el usuario*/
                    $m = Merma::where('producto_id', $p->id)->where('eid', '!=', auth()->user()->datos->eid)->get();
                    $mermas = $mermas->merge($m);
                }
                $jefes = collect([]);
                $usuarios = User::all();

                foreach ($usuarios as $usuario) {
                    if ($usuario->hasRole('JefeInventario')) {
                        $jefes = $jefes->merge(collect([$usuario])); //Todos los usuarios con rol JefeInventario
                    }
                }
                foreach ($jefes as $jefe) {
                    $m = Merma::where('eid', $jefe->datos->eid)->get(); //Todas las mermas realizadas por Jefes de Inventario
                    $mermas = $mermas->merge($m);
                }
            } else {
                $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
                if($almacenes){
                    $productos = collect([]);
                    foreach ($almacenes as $a) {
                        $prod = Producto::where('subarea', $a->almacen_clave)->get();
                        $productos = $productos->merge($prod);
                    }
                    $mermas = collect([]);
                    foreach ($productos as $p) {
                        $m = Merma::where('producto_id', $p->id)->where('eid', '!=', auth()->user()->datos->eid)->get();
                        $mermas = $mermas->merge($m);
                    }
                }
                else{
                    $mermas = Merma::all();
                }
            }
        }
        return view('productos.mermas', compact('mermas'));
    }

    public function anadirMermas(Producto $producto)
    {
        $producto = Producto::with(["subareas", "almacenes"])->find($producto->id);
        $producto->ubicacion = "Unknow";
        if($producto->subareas){
            $producto->ubicacion = $producto->subareas->subarea_nombre;
        }
        else{
            $producto->ubicacion = $producto->almacenes->almacen_nombre;
        }
        
        if($producto->existencias > 0){
            return view('productos.anadirMermas', compact('producto'));
        }        
        return redirect()->back()->with('error', 'No hay existencias para realizar la merma');
    }

    public function store(Request $request)
    {

        $arch = $request->all();

        if ($archivo = $request->file('archivo')) {
            $rutaGuardarArch = public_path() . '/reportes/';
            $archMerma = $archivo->getClientOriginalName();
            $archivo->move($rutaGuardarArch, $archMerma);
            $arch['archivo'] = $archMerma;
        }
        
        Merma::create([
            'producto_id' => $request->producto,
            'eid' => auth()->user()->eid,
            'cantidad' => $request->cantidad,
            'archivo' => $arch['archivo'],
            'status' => 'pendiente',
        ]);
        //        $arch = $request->all();
        /*         $arch['eid'] = auth()->user()->eid;
        $arch['status'] = 'pendiente'; */


        //Merma::create($arch);

        return redirect()->back();
    }

    public function autorizarMermas(Request $request)
    {
        $merma = Merma::FindOrFail($request->merma);
        $merma->status = 'Autorizado';
        $merma->save();
        $producto = Producto::FindOrFail($merma->producto_id);
        //Si no hay existencias, se puede crear la merma pero no disminuye las existencias
        if ($producto->existencias >= $merma->cantidad) {
            $producto->existencias = $producto->existencias -= $merma->cantidad;
            $producto->save();
        }

        Baja::create([
            'eid' => 'Merma',
            'id_producto' => $producto->id,
            'consumidos' => $merma->cantidad,
            'area' => $producto->area,
            'subarea' => $producto->subarea,
            'archivo' => $merma->archivo,
        ]);
        return redirect()->back();
    }

    public function indexHistorial()
    {
        if (Auth::user()->hasRole('admin')) { //Todas las mermas
            $mermas = Merma::where('status', 'Autorizado')->get();
        } elseif (Auth::user()->hasRole(['JefeInventario', 'JefeArea'])) { //Mermas de toda la zona (almacenes y subareas)
            $productos = Producto::where('area', auth()->user()->datos->area)->get();
            $mermas = collect([]);
            foreach ($productos as $producto) {
                $m = Merma::where('producto_id', $producto->id)->get();
                $mermas = $mermas->merge($m);
            }
        } else { //Mermas creadas por el usuario
            $mermas = Merma::where('eid', auth()->user()->eid)->get();
        }
        //$mermas = Merma::where('status', 'Autorizado')->get();
        return view('productos.mermasHistorial', compact('mermas'));
    }

    public function show()
    {
        //
    }
}
