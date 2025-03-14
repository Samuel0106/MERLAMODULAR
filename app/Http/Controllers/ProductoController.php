<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subarea;
use App\Models\almacenes;
use App\Models\Pedidoespecial;
use App\Models\Baja;
use DataTables;
use Auth;
use App\Models\Merma;
use File;
use App\Models\Division;
use App\Models\Area;
use Illuminate\Support\Facades\DB;



class ProductoController extends Controller
{
    public $categorias;
    public $categoriasT;
    public $categoriaSelect;
    public $productos;
    public $productosT;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() //Permisos de rol $this->middleware('can:permiso')->only(metodos);
    {
        $this->middleware('can:producto.crear')->only('create', 'store', 'index', 'edit', 'update', 'destroy', 'editI', 'updateI');
        $this->middleware('can:producto.existencias')->only('eliminarExistenciasIndex');
        $this->middleware('can:producto.TodosAlmacenes')->only('indexTotal');
    }
    public function index()
    {
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/
        $categorias = Categoria::all();
        //Obtener el almacen del usuario autenticado y mostrar esos productos
        if (Auth::user()->can('producto.TodosAlmacenes') || Auth::user()->hasRole('admin')) {
            $productos = Producto::with(['areas', 'subareas', 'categoria', 'almacenes'])
                ->where('id_categoria', $categorias[0]->id)->get();
        } /* else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->get();
            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::query()
                    ->with(['areas', "subareas", "almacenes"])
                    ->where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                // ->where('subarea', $almacenes[0]->almacen_clave)
                ->where('subarea', Auth::user()->datos->subarea)
                ->where('id_categoria', $categorias[0]->id)->get();
        } */
        else if(Auth::user()->hasRole(['JefeInventario', 'JefeArea'])){
            $almacen = Almacen::where('jefe_eid', auth()->user()->eid)
            ->where('habilitado', 1)->first();
            if($almacen){
                $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('subarea', $almacen->almacen_clave)
                ->where('id_categoria', $categorias[0]->id)->get();
            }
            else{
                $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('area', auth()->user()->datos->area)
                ->where('id_categoria', $categorias[0]->id)->get();
            }
        }
        else if(Auth::user()->hasRole(['JefeSubarea'])){
            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('subarea', auth()->user()->datos->subarea)
                ->where('id_categoria', $categorias[0]->id)->get();
        }

        return view('productos.index', compact(['productos', 'categorias']));
    }
    public function indexSubareas()
    {
        $categorias = Categoria::all();
        $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->get();
        $productos = collect([]);

        $area = Area::where('area_clave',  $almacenes[0]->area_id)->get();
        $subareas =  $area->first()->subareas;
        foreach ($almacenes as $a) {
            $prod = Producto::query()
                ->with(['areas', "subareas", "almacenes"])
                ->where('subarea', $a->almacen_clave)->get();
            $productos = $productos->merge($prod);
        }
        $productos = Producto::query()
            ->with(['categoria', 'areas', 'subareas', 'almacenes'])
            ->where('subarea', $subareas[0]->subarea_clave)
            ->where('id_categoria', $categorias[0]->id)->get();
        return view('productos.indexSubareas', compact(['productos', 'categorias', 'subareas', 'area']));
    }
    public function indexTotal()
    {
        if(!(Auth::user()->eid == '9JJGM' || Auth::user()->can('producto.TodosAlmacenes'))) {
            return abort(403);
        }
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/
        /* else{
            $productos = Producto::all();
        }
        $categorias = Categoria::all();

        // $productos = Producto::paginate(50);
        $productos = Producto::all();
        return view('productos.indexTotal', compact(['productos', 'categorias'])); */
        $categorias = Categoria::all();
        $div = Division::first();
        $areas = Area::where('division_id', $div->division_clave)->get();
        $subareas = Subarea::where('area_id', $areas[0]->area_clave)->get();

        $almacenes = Almacen::where('area_id', $areas[0]->area_clave)->get();

        $productos = Producto::where('id_categoria', $categorias[0]->id)
            ->with(['subareas', 'almacenes'])
            ->where('subarea', $almacenes[2]->almacen_clave)->get();

        return view('productos.indexTotal', compact('productos', 'categorias', 'areas', 'almacenes', 'subareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/
        $pedidoesp = null;
        if(isset($_GET['pedido'])){
            $pedidoesp = Pedidoespecial::where('id',$_GET['pedido'])->first();
        }

        $area = DB::table('datosusers')->where('eid', 'LIKE', Auth::user()->eid)->get()->first()->area;
        $categorias = DB::table('categorias')->get();

        if (Auth::user()->can('producto.TodosAlmacenes')) {
            $almacenes = Almacen::where('habilitado', 1)->get();
            $almacen_nombre = null;
            $almacen_clave = null;
        } else {
            if ($almacenes = Almacen::where('jefe_eid', Auth::user()->eid)->where('habilitado', 1)->first()) {
                $almacen_nombre = $almacenes->almacen_nombre;
                $almacen_clave = $almacenes->almacen_clave;
            } else {
                $almacen_nombre = null;
                $almacen_clave = null;
            }
        }

        return view('productos.crear', compact('categorias', 'almacen_clave', 'area', 'almacen_nombre', 'almacenes', 'pedidoesp'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = $request->validate([
            'nombre_producto' => 'required|max:191|min:1|regex:/^[a-zA-Z0-9\s@#$%&*]+$/u',
            'unidad' => 'required',
            'stock_minimo' => 'required|numeric|max:2147483647|min:0',//int(11) en la base de datos
            'id_categoria' => 'required',
            'existencias' => 'required|numeric|max:2147483647|min:0',//int(11) en la base de datos
            'area' => 'required',
            'subarea' => 'required',
            'photo_prod' => 'image|mimes:jpeg,png,svg,jpg|max:8192',
        ],
        [
            'photo_prod.max' => 'La imagen no debe exceder los 8192 kilobytes.'
        ]);
        
        $subarea = $request->input('subarea');
        $producto['area'] = substr($subarea, 0, 4);
        $producto['photo_prod'] = "iconProduct.png";
        $producto['nombre_producto'] = preg_replace('/[^\p{L}0-9\s\/.-]+/u', '', $producto['nombre_producto']);
        $nombre = $producto['nombre_producto'];
        $categoria = $producto['id_categoria'];
        $data = Producto::create($producto);
        if($request->has('photo_prod')){
            $imagen = $request->file('photo_prod');
            $rutaGuardarImg = public_path() . '/imagen_productos/';
            $imagenProd = date('Ymdhi') . "_" . $subarea . "_" . "_" . $data->id . "_" . $nombre . "_" . "photo_prod" . "_" . $categoria . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaGuardarImg, $imagenProd);
            $producto['photo_prod'] = "$imagenProd";
            
            Producto::where('id', $data->id)->update(['photo_prod' => $imagenProd]);
        }
        
        if($request['id_pedidoesp'] != null){
            Pedidoespecial::where('id', $request['id_pedidoesp'])->update(['estado' => 'Autorizado']);
        }
        
        return redirect()->route('productos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $almacenes = DB::table('almacenes')->get();
        $categorias = DB::table('categorias')->get();
        //$area_id = Subarea::find($producto->subarea)->area_id;
        //$areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
        //$subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', $area_id . '%')->get();
        return view('productos.editar', compact('categorias', 'producto', 'almacenes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $validacion = $request->validate([              //Variable no se usa pero valida correctamente
            'nombre_producto' => 'required|max:191|min:1|regex:/^[a-zA-Z0-9\s@#$%&*]+$/u',
            'unidad' => 'required',
            'stock_minimo' => 'required|numeric|max:2147483647|min:0',//int(11) en la base de datos
            'id_categoria' => 'required',
            'existencias' => 'required|numeric|max:2147483647|min:0',//int(11) en la base de datos
            'area' => 'required',
            'subarea' => 'required',
            'photo_prod' => 'image|mimes:jpeg,png,svg,jpg|max:8192',
        ],
        [
            'photo_prod.max' => 'La imagen no debe exceder los 8192 kilobytes.'
        ]);

        $producto->fill($request->all());
        if ($request->photo_prod) {
            $imagenProd = date('Ymdhi') . "_" . $producto->almacen . "_" . $producto->id . "_" . $producto->nombre . "_" . "photo_prod" . "_" . $producto->id_categoria . "." . $request->photo_prod->getClientOriginalExtension();
            $request->photo_prod->move(public_path('imagen_productos'), $imagenProd);
            $producto->photo_prod = "$imagenProd";
        }
        $producto->save();
        if (isset($request->origen)) {
            return response()->json(
                [
                    'success' => true,
                ]
            );
        } else {
            return redirect()->route('productos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * $producto->existencias  += $request->cantidad;
     * $producto->save();
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {

        $eid_almacen = Almacen::query()->where('jefe_eid', Auth::user()->eid)->get();
        if(Auth::user()->hasRole(['JefeInventario', 'admin', 'SuperRoot']) || $eid_almacen->count() > 0){
            if($producto->existencias == 0){
                Merma::where('producto_id', $producto->id)->delete();
                $producto->delete();

                if($producto->photo_prod != "iconProduct.png"){
                    if (File::exists(public_path('imagen_productos/' . $producto->photo_prod))) {
                        File::delete(public_path('imagen_productos/' . $producto->photo_prod));
                        
                    }
                }

                return redirect()->back()->with('success', 'Se ha eliminado el producto correctamente');
            }
            else{
                return redirect()->back()->withErrors(['msg'=>'No se puede borrar un producto con existencias']);
            }
        }
        else{
            return redirect()->back()->withErrors(['msg'=>'No está autorizado para eliminar un producto']);
        }
    }

    public function indexI()
    {
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('productos.indexI', compact('productos', 'categorias'));
    }

    public function editI(Producto $producto)
    {
        $almacen = Almacen::find($producto->subarea);
        $subarea = Subarea::find($producto->subarea);
        if($almacen){
            $subarea_nombre = $almacen->almacen_nombre;
        }
        elseif($subarea){
            $subarea_nombre = $subarea->subarea_nombre;
        }
        else{
            $subarea_nombre = 'Unknow';
        }
        return view('productos.editarI', compact('producto', 'subarea_nombre'));
    }
    
    public function updateI(Request $request, Producto $producto)
    {
        $request->validate([
            'existencias' => 'required|numeric|min:1|max:2147483647'//int(11) en la base de datos
        ]);
        $producto->existencias  += $request->existencias;
        $producto->save();
        return redirect()->back()->with('success', 'Existencia agregada correctamente!');
    }
    public function eliminarExistenciasIndex()
    {
        $categorias = Categoria::all();
        if (Auth::user()->hasRole('usuario')) {
            $productos = Producto::query()
                ->with(['areas', 'subareas', 'almacenes'])
                ->where('id_categoria', $categorias[0]->id)
                ->where('subarea', auth()->user()->datos->subarea)->get();
        } else if (Auth::user()->hasRole('admin')) {
            $productos = Producto::query()
                ->where('id_categoria', $categorias[0]->id)
                ->with(['areas', 'subareas', 'almacenes'])->get();
        } elseif (Auth::user()->hasRole(['JefeInventario', 'JefeArea'])) {
            $almacen = Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->first();
            /* $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::query()
                    ->with(['areas', 'subareas', 'almacenes'])
                    ->where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            } */
            $productos = Producto::query()
                ->with(['areas', 'subareas', 'almacenes'])
                ->where('id_categoria', $categorias[0]->id)
                ->where('area', auth()->user()->datos->area)->get();

            if($almacen){
                $productos = Producto::query()
                ->with(['areas', 'subareas', 'almacenes'])
                ->where('id_categoria', $categorias[0]->id)
                ->where('subarea', $almacen->almacen_clave)->get();
            }
        }
        else{
            $productos = Producto::query()
            ->with(['areas', 'subareas', 'almacenes'])
            ->where('id_categoria', $categorias[0]->id)->get();
        }
        // $productos = Producto::paginate(50);
        return view('productos.bajas', compact(['productos', 'categorias']));
        //$subarea_nombre = Subarea::find($producto->subarea)->subarea_nombre;
        //return view('productos.bajaProducto', compact('producto', 'subarea_nombre'));
    }

    public function eliminarExistenciasProducto(Producto $producto)
    {
        $almacen = Almacen::find($producto->subarea);
        $subarea = Subarea::find($producto->subarea);
        if($almacen){
            $subarea_nombre = $almacen->almacen_nombre;
        }
        elseif($subarea){
            $subarea_nombre = $subarea->subarea_nombre;
        }
        else{
            $subarea_nombre = 'Unknow';
        }
        /* $subarea_nombre = Almacen::find($producto->subarea)->almacen_nombre; */
        if ($producto->existencias > 0) {
            return view('productos.bajaProducto', compact('producto', 'subarea_nombre'));
        } else {
            return redirect()->back()->with('error', 'No hay existencias por eliminar');
        }
    }
    public function actualizarExistencias(Request $request, Producto $producto)
    {
        $request->validate([
            'existencias' => ['numeric', 'min:1']
        ]);
        $eliminadas = $request->existencias;
        if ($eliminadas > $producto->existencias) {
        } else {
            $producto->existencias  -= $eliminadas;
            $producto->save();
        }

        if ($archivo = $request->file('archivo')) {
            $rutaGuardarArch = public_path() . '/reportes/';
            $archBaja = $archivo->getClientOriginalName();
            $archivo->move($rutaGuardarArch, $archBaja);
            $arch['archivo'] = $archBaja;
        }

        Baja::create([
            'eid' => auth()->user()->datos->eid,
            'id_producto' => $producto->id,
            'consumidos' => $request->existencias,
            'area' => $producto->area,
            'subarea' => $producto->subarea,
            'archivo' => $arch['archivo'],
        ]);
        return redirect()->route('productos.eliminarExistenciasIndex');
    }

    public function updateTable(Request $request)
    {
        $cat = $request->categoria;
        $eli = $request->bandera;
        if($eli === 0)
        {
            if (Auth::user()->can('producto.TodosAlmacenes') || Auth::user()->hasRole('admin')) {
                $productos = Producto::with(['areas', 'subareas', 'categoria', 'almacenes'])
                    ->where('id_categoria', $cat)->get();
            } 
            else if(Auth::user()->hasRole(['JefeInventario', 'JefeArea'])){
                $almacen = Almacen::where('jefe_eid', auth()->user()->eid)
                ->where('habilitado', 1)->first();
                if($almacen){
                    $productos = Producto::query()
                    ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('subarea', $almacen->almacen_clave)
                    ->where('id_categoria', $cat)->get();
                }
                else{
                    $productos = Producto::query()
                    ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('area', auth()->user()->datos->area)
                    ->where('id_categoria', $cat)->get();
                }
            }
            else if(Auth::user()->hasRole(['JefeSubarea'])){
                $productos = Producto::query()
                    ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('subarea', auth()->user()->datos->subarea)
                    ->where('id_categoria', $cat)->get();
            }
        }
        else {
            
            if (Auth::user()->can('producto.TodosAlmacenes') || Auth::user()->hasRole('admin')) {
                $productos = Producto::onlyTrashed()->with(['areas', 'subareas', 'categoria', 'almacenes'])
                    ->where('id_categoria', $cat)->get();
            } 
            else if(Auth::user()->hasRole(['JefeInventario', 'JefeArea'])){
                $almacen = Almacen::where('jefe_eid', auth()->user()->eid)
                ->where('habilitado', 1)->first();
                if($almacen){
                    $productos = Producto::query()
                    ->onlyTrashed()->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('subarea', $almacen->almacen_clave)
                    ->where('id_categoria', $cat)->get();
                }
                else{
                    $productos = Producto::query()
                    ->onlyTrashed()->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('area', auth()->user()->datos->area)
                    ->where('id_categoria', $cat)->get();
                }
            }
            else if(Auth::user()->hasRole(['JefeSubarea'])){
                $productos = Producto::query()
                    ->onlyTrashed()->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    ->where('subarea', auth()->user()->datos->subarea)
                    ->where('id_categoria', $cat)->get();
            }
        }
        return response()->json(
            [
                'success' => true,
                'lista' => $productos,
            ]
        );
    }

    //dt nuevo
    public function fetchProductos(Request $request)
    {
        $cat = $request->categoria;
        $categorias = Categoria::all();
        if (Auth::user()->can('producto.TodosAlmacenes') || Auth::user()->hasRole('admin')) {
            $productos = Producto::with(['areas', 'subareas', 'categoria', 'almacenes'])
                ->where('id_categoria', $categorias[0]->id)->get();
        }else if(Auth::user()->hasRole(['JefeInventario', 'JefeArea'])){
            $almacen = Almacen::where('jefe_eid', auth()->user()->eid)
            ->where('habilitado', 1)->first();
            if($almacen){
                $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('subarea', $almacen->almacen_clave)
                ->where('id_categoria', $categorias[0]->id)->get();
            }
            else{
                $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('area', auth()->user()->datos->area)
                ->where('id_categoria', $categorias[0]->id)->get();
            }
        }
        else if(Auth::user()->hasRole(['JefeSubarea'])){
            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->where('subarea', auth()->user()->datos->subarea)
                ->where('id_categoria', $categorias[0]->id)->get();
        }
        
        //se modifica cada producto para añadir lo que llevara la columna almacen
        $productos = $productos->map(function ($producto) {
            //se inicia almacen con el nombre del area si esta disponible
            $almacen = $producto->areas ? $producto->areas->area_nombre . ", " : "";
            //se agrega al nombre el nombre almacen o de la subarea segun lo que este disponible
            if ($producto->almacenes) {
                $almacen .= $producto->almacenes->almacen_nombre;
            } elseif ($producto->subareas) {
                $almacen .= $producto->subareas->subarea_nombre;
            } else {
                $almacen .= "Unknown";
            }
            $producto->almacen = $almacen;
            return $producto;
        });

        return response() -> json([
            'productos' => $productos
        ]);
    }

    public function filtrarProd(Request $request)
    {
        $cat = $request->categoria;
        $eliminados = $request->eliminados;

        $query = Producto::query()->with(['categoria', 'areas', 'subareas', 'almacenes']);

        if ($cat) {
            $query->where('id_categoria', $cat);
        }
        if ($eliminados) {
            $query->onlyTrashed();
        }
        if (!Auth::user()->can('producto.TodosAlmacenes') && !Auth::user()->hasRole('admin')) {
            if (Auth::user()->hasRole(['JefeInventario', 'JefeArea'])) {
                $almacen = Almacen::where('jefe_eid', auth()->user()->eid)
                    ->where('habilitado', 1)->first();
                if ($almacen) {
                    $query->where('subarea', $almacen->almacen_clave);
                } else {
                    $query->where('area', auth()->user()->datos->area);
                }
            } elseif (Auth::user()->hasRole('JefeSubarea')) {
                $query->where('subarea', auth()->user()->datos->subarea);
            }
        }
        $productos = $query->get();
        $productos = $productos->map(function ($producto) {
            $almacen = $producto->areas ? $producto->areas->area_nombre . ", " : "";
            if ($producto->almacenes) {
                $almacen .= $producto->almacenes->almacen_nombre;
            } elseif ($producto->subareas) {
                $almacen .= $producto->subareas->subarea_nombre;
            } else {
                $almacen .= "Unknown";
            }
            $producto->almacen = $almacen;
            return $producto;
        });

        return response()->json([
            'productos' => $productos
        ]);
    }

    public function filtroInventarioGeneral(Request $request)
    {
        $cat = $request->categoria;
        $documentos = Producto::query()
            ->with(['categoria', 'area'])
            ->where('id_categoria', $cat)
            ->get();

        return response()->json(
            [
                'success' => true,
                'lista' => $documentos,
            ]
        );
    }

    public function filtroQuitarExistencias(Request $request)
    {
        $cat = $request->categoria;
        if (Auth::user()->hasRole('usuario')) {
            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->when($cat != 0, function($query) use($cat){
                    return $query->where('id_categoria', $cat);
                })
                ->where('subarea', auth()->user()->datos->subarea)->get();
        } else if (Auth::user()->hasRole('admin')) {
            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->when($cat != 0, function($query) use($cat){
                    return $query->where('id_categoria', $cat);
                })->get();
        } elseif (Auth::user()->hasRole(['JefeInventario', 'JefeArea'])) {
            $almacen = Almacen::where('jefe_eid', auth()->user()->datos->eid)->where('habilitado', 1)->first();

            $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->when($cat != 0, function($query) use($cat){
                    return $query->where('id_categoria', $cat);
                })
                ->where('area', auth()->user()->datos->area)->get();

            if($almacen){
                $productos = Producto::query()
                ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                ->when($cat != 0, function($query) use($cat){
                    return $query->where('id_categoria', $cat);
                })
                ->where('subarea', $almacen->almacen_clave)->get();
            }
        }
        else{
            $productos = Producto::query()
            ->with(['categoria', 'areas', 'subareas', 'almacenes'])
            ->when($cat != 0, function($query) use($cat){
                return $query->where('id_categoria', $cat);
            })->get();
        }
        /* $productos = Producto::query()
            ->with(['categoria', 'areas', 'subareas', 'almacenes'])
            ->where('id_categoria', $cat)
            ->get(); */

        return response()->json(
            [
                'success' => true,
                'lista' => $productos,
            ]
        );
    }

    public function actualizarDatos()
    {

        if ($this->categoriaSelect != 0) {
            $this->productosT = Producto::where([
                ['id_categoria', '=', $this->categoriaSelect],
            ])->get();
        } else {
            // $this->productosT = Producto::all();
            // $this->productosT = Producto::latest()->take(5)->get();
            $this->productosT = Producto::all()->orderBy('id', 'DESC')->take(5)->get();
        }
    }

    public $pagination = [
        'page' => 1,
        'perPage' => 5
    ];

    public function render()
    {
        return view('livewire.inventario-index', [
            'registros' => Producto::paginate($this->pagination['perPage'], ['*'], 'page', $this->pagination['page']),
        ]);
    }

    public function generalStockFilter(Request $request)
    {
        $eliminados = $request->bandera;
        if($eliminados == 0)
        {
            if (empty($request->opcion)) {
                $ubicacion = $request->input('ubicacion');
                $categoria = $request->input('categoria');
                $area = $request->input('area');
                //$producto = $request->input('producto');
                $productos = Producto::query()
                    ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    //->where('area', $area)
                    ->when($ubicacion != '0', function ($query) use ($ubicacion) {
                        return $query->where('subarea', $ubicacion);
                    })
                    /* ->when($subarea != '0', function($query) use ($subarea){
                    return $query->where('subarea', $subarea);
                }) */
                    ->when($categoria != '0', function ($query) use ($categoria) {
                        return $query->where('id_categoria', $categoria);
                    })
                    /* ->when($producto != '0', function($query) use ($producto){
                    return $query->where('id', $producto);
                }) */
                    ->get();
            } else {
                $area = $request->input('area');
                $opcion = $request->input('opcion');
                $ubicacion = $request->input('ubicacion');
                $categoria = $request->input('categoria');
                //$producto = $request->input('producto');
                $productos = Producto::query()
                    ->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    /* ->when($area != '0', function ($query) use ($area) {
                        return $query->where('area', $area);
                    }) */
                    ->when($ubicacion != '0', function ($query) use ($ubicacion) {
                        return $query->where('subarea', $ubicacion);
                    })
                    /* ->when($subarea != '0', function($query) use ($subarea){
                    return $query->where('subarea', $subarea);
                }) */
                    ->when($categoria != '0', function ($query) use ($categoria) {
                        return $query->where('id_categoria', $categoria);
                    })
                    /* ->when($producto != '0', function($query) use ($producto){
                    return $query->where('id', $producto);
                }) */
                    ->get();
            }
        }
        else
        {
            if (empty($request->opcion)) {
                $ubicacion = $request->input('ubicacion');
                $categoria = $request->input('categoria');
                $area = $request->input('area');
                //$producto = $request->input('producto');
                $productos = Producto::query()
                    ->onlyTrashed()->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    //->where('area', $area)
                    ->when($ubicacion != '0', function ($query) use ($ubicacion) {
                        return $query->where('subarea', $ubicacion);
                    })
                    /* ->when($subarea != '0', function($query) use ($subarea){
                    return $query->where('subarea', $subarea);
                }) */
                    ->when($categoria != '0', function ($query) use ($categoria) {
                        return $query->where('id_categoria', $categoria);
                    })
                    /* ->when($producto != '0', function($query) use ($producto){
                    return $query->where('id', $producto);
                }) */
                    ->get();
            } else {
                $area = $request->input('area');
                $opcion = $request->input('opcion');
                $ubicacion = $request->input('ubicacion');
                $categoria = $request->input('categoria');
                //$producto = $request->input('producto');
                $productos = Producto::query()
                    ->onlyTrashed()->with(['categoria', 'areas', 'subareas', 'almacenes'])
                    /* ->when($area != '0', function ($query) use ($area) {
                        return $query->where('area', $area);
                    }) */
                    ->when($ubicacion != '0', function ($query) use ($ubicacion) {
                        return $query->where('subarea', $ubicacion);
                    })
                    /* ->when($subarea != '0', function($query) use ($subarea){
                    return $query->where('subarea', $subarea);
                }) */
                    ->when($categoria != '0', function ($query) use ($categoria) {
                        return $query->where('id_categoria', $categoria);
                    })
                    /* ->when($producto != '0', function($query) use ($producto){
                    return $query->where('id', $producto);
                }) */
                    ->get();
            }
        }
        

        //info($productos);
        return response()->json(
            [
                'success' => true,
                'lista' => $productos,
            ]
        );
    }

    /*     public function almacenes(Request $request){
        //info($request->input('area'));
        $almacenes = Almacen::where('area_id', $request->input('area'))->get();
        return response()->json(
            [
                'lista' => $almacenes,
                'success' => true
            ]
        );
    } */

    public function ubicacionInvGen(Request $request)
    {
        $opcion = $request->input("opcion");
        $ubicacion = $request->input("ubicacion");
        if ($opcion == 1) {
            $ubicaciones = Subarea::where('area_id', $ubicacion)->get();
            return response()->json(
                [
                    'opcion' => 1,
                    'subareas' => $ubicaciones,
                ]
            );
        } else {
            $ubicaciones = Almacen::where('area_id', $ubicacion)->get();
            return response()->json(
                [
                    'opcion' => 2,
                    'almacenes' => $ubicaciones,
                ]
            );
        }
        return response()->json(
            [
                'message' => "error",
            ]
        );
    }


    // public static function editar($id)
    // {
    //     //$id = Crypt::decrypt($id);
    //     // $producto = Producto::FindOrFail($id);
    //     // // $evidencia->estatus = '1';
    //     // $producto->save();
    //     // return redirect()->route('productos.edit', ['id' => $id]);
    //     return view('productos.edit', ['id' => $id]);
    // }

    // public function editar($id)
    // {
    //     $almacenes = DB::table('almacenes')->get();
    //     $categorias = DB::table('categorias')->get();
    //     $producto = Producto::where('id', $id)->get();
    //     //$area_id = Subarea::find($producto->subarea)->area_id;
    //     //$areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
    //     //$subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', $area_id . '%')->get();
    //     info ($producto);
    //     return view('productos.editar', compact('categorias', 'producto', 'almacenes'));
    // }
}
