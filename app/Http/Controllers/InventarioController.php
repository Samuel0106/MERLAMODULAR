<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Datosuser;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Inventario;
use App\Models\Almacen;
use App\Models\Pedidoespecial;
use App\Models\Baja;
use App\Models\Subarea;
use App\Models\Merma;
use Auth;
use DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Collection;

// For the usage of the Cart class use this link: https://github.com/bumbummen99/LaravelShoppingcart#usage

class InventarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inventario');
        $this->middleware('can:inventario.autorizar')->only('autorizarIndex', 'comentario', 'entregarProductos', 'changeProductStatus');
        $this->middleware('can:inventario.authPedidoEspecial')->only('indexPedidoEspecial', 'authPedidoEspecial');
        $this->middleware('can:inventario.entregar')->only('entregarIndex', 'entregadosIndex', 'show');
        //$this->middleware('can:inventario.proximosAgotar')->only('proximosAgotar');
        $this->middleware('can:inventario.reponer')->only('reponer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $inventarios = Inventario::all();
        } else if (Auth::user()->hasRole(['JefeInventario', 'JefeArea'])) {
            $inventarios = Inventario::where('area', Auth::user()->datos->area)->get();
        } else {
            $inventarios = Inventario::where('eid', Auth::user()->eid)->get();
        }

        // Ordenar la colección de inventarios según su estado
        $inventarios = $inventarios->sortBy(function ($inventario) {
            // Comparar el estado de cada inventario con los posibles estados que pueden tener
            if ($inventario->status === 'Pendiente') {
                // Si el estado del inventario es 'Pendiente', devolver el valor 0 para que esté en la posición inicial de la colección
                return 0;
            } else if ($inventario->status === 'Entregado') {
                // Si el estado del inventario es 'Entregado', devolver el valor 2 para que esté en la última posición de la colección
                return 2;
            } else {
                // Si el estado del inventario es cualquier otro valor, devolver el valor 1 para que esté en una posición intermedia de la colección
                return 1;
            }
        });

        return view('inventarios.index', compact('inventarios'));
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $datos = Datosuser::where('eid', Auth::user()->eid)->firstOrFail();
    $user = User::where('eid', Auth::user()->eid)->firstOrFail();

    $categorias = Categoria::all();
    $productos = Producto::all();

    $carro = Cart::content()->keyBy('id');

    if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperRoot')) {

        $areas = DB::table('areas')->get();
        $subareas = DB::table('subareas')->get();
    } else {
        $areas = DB::table('areas')->where('area_clave', $datos->area)->get();
        $subareas = DB::table('subareas')->where('subarea_clave', $datos->subarea)->get();
    }
    return view('inventarios.crear', compact('datos', 'user', 'categorias', 'productos', 'carro', 'areas', 'subareas'));
}

    public function reponer()
    {

        $datos = Auth::user()->datos;
        $email = Auth::user()->email;
        $productos = Producto::all();
        $area = $datos->getArea()->first()->area_nombre;
        $subarea = $datos->getSubarea()->first()->subarea_nombre;
        return view('inventarios.reponer', compact('productos', 'datos', 'area', 'email', 'subarea'));
    }

    public function proximosAgotar()
    {

        $datos = Auth::user()->datos;
        $area = $datos->getArea()->first()->area_nombre;
        $area_clave = $datos->getArea()->first()->area_clave;
        $subarea = $datos->getSubarea()->first()->subarea_nombre;

        #Consulta de los productos cuando el area del producto es igual al del usuario autenticado
        #Muestra solo los productos con una existencia mayor al stock minimo + 10%
        $productos = DB::table('productos')
            ->select('productos.id', 'nombre_producto', 'unidad', 'existencias', 'photo_prod', 'stock_minimo', 'area')
            ->join('areas', 'productos.area', '=', 'areas.area_clave')
            ->where('area', $area_clave)
            ->whereRaw('existencias <= stock_minimo * 1.1')
            ->get();


        return view('inventarios.proximosAgotar', compact('productos', 'datos', 'area_clave', 'area', 'subarea'));
    }

    public function pedidoespecial()
    {
        $datos =  Datosuser::where('eid', Auth::user()->eid)->firstOrFail();
        $almacenes = Almacen::where('area_id', $datos->area)->with(['jefe'])->get();
        return view('inventarios.pedidoespecial', compact('datos', 'almacenes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->area) {
            return redirect()->route('inventarios.create', ['subareaSel' => $request->subarea, 'almacenes' => $request->almacen]);
        }

        $inventario = $request->all();
        $carro = Cart::content();
        $this->actualizarProductosSolicitados($carro, false);
        $data = json_encode($carro);
        $inventario['carrito'] = $data;
        $inventario['status'] = 'Pendiente';
        $inventario['oculto'] = false;
        $inventario['fecha_entrega'] = null;
        $inventario['fecha_autorizado'] = null;
        $inventario['foto_entrega'] = '';
        Cart::destroy();
        Inventario::create($inventario);

        $folio = Inventario::where('eid', Auth::user()->eid)->orderBy('id', 'DESC')->firstOrFail();

        $almacen = Almacen::query()->where('almacen_clave', $inventario['almacen'])->first();
        $jefe = User::query()->where('eid', $almacen->jefe_eid)->first();
        $subareaName = Subarea::query()->where('subarea_clave', $inventario['subarea'])->pluck('subarea_nombre')->first();
        $jefeNombre = $jefe->datos->paterno . " " . $jefe->datos->materno . " " . $jefe->datos->nombre;
        $today = Carbon::today()->format('Y-m-d');

        $nombreTmp = str_replace(",", "", $inventario['nombre']);
        $notificaciones = [
            [
                'destinatario' => $inventario['email'],
                'asunto' => 'Pedido realizado',
                'cuerpo' => 'Pedido con folio #' . $folio->id . ' realizado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
            ],
            [
                'destinatario' => $jefe->email,
                'asunto' => 'Pedido realizado',
                'cuerpo' => 'Pedido con folio #' . $folio->id . ' realizado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
            ],
        ];
        

        foreach ($notificaciones as $notificacion) {
            Notificacion::create($notificacion);
        }

        /* if($imagen = $request->file('foto_entrega')) {
            $rutaGuardarImg = "imagen/";
           //  $imagenRij = date('Ymd')."_".$area."_".$subarea."_"."saludo"."_".$eid. "." . $imagen->getClientOriginalExtension();
            $imagenSalud = date('YmdHis')."_"."entrega".".jpg";
            $imagen->move($rutaGuardarImg, $imagenSalud);
            $ms['foto_entrega'] = "$imagenSalud";
        } */

        return redirect()->route('inventarios.inicio')->with('message', 'Su solicitud ha sido creada. Su folio es: ' . $folio->id);
    }

    public function especial_store(Request $request)
    {
        $pedido = $request->validate(
            [
                'solicitante' => 'required|exists:datosusers,eid',
                'responsable' => 'required|exists:datosusers,eid',
                'nombre_producto' => 'required|min:1|max:191|regex:/^[a-zA-Z0-9\s\/.]+$/u',
                'cantidad' => 'required|numeric|min:1|max:2147483647', //int(11) en la base de datos
                'descripcion' => 'required|min:1|max:191|regex:/^[a-zA-Z0-9\s\/.]+$/u',
                'foto' => 'mimes:png,jpg,jpeg|max:8192',
                'justificacion' => 'required|min:1|max:191|regex:/^[a-zA-Z0-9\s\/.]+$/u',
                'import' => 'required',
            ],
            [
                'foto.max' => 'La imagen no debe exceder los 8192 kilobytes.'
            ]
        );

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = date('Ymdhi') . "_PE_" . $request->solicitante . "_" . $request->responsable . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/pedidoespecial/', $filename);
            $pedido['foto'] = $filename;
        } else {
            $pedido['foto'] = "iconProduct.png";
        }

        Pedidoespecial::create($pedido);

        return redirect()->route('inventarios.inicio')->with('message', 'Su pedido especial ha sido enviado a revision');
    }

    public function indexPedidoEspecial()
    {
        if (Auth::user()->hasRole('admin')) {
            $pedidos = Pedidoespecial::orderBy('import', 'DESC')->get();
        } else if (Auth::user()->hasRole('JefeInventario')) {
            $pedidos = Pedidoespecial::where('responsable', Auth::user()->eid)->orderBy('import', 'DESC')->get();
        }
        return view('inventarios.showpedidoespecial', compact('pedidos'));
    }

    public function authPedidoEspecial($id)
    {
        $pedido = Pedidoespecial::where('id', $id)->first();
        return view('inventarios.authpedidoespecial', compact('pedido'));
    }

    public function createpedidoespecial($pedido, $auth)
    {
        if ($auth == '0') {
            Pedidoespecial::where('id', $pedido)->update(['estado' => 'Rechazado']);
            return redirect()->route('inventarios.indexPedidoEspecial')->with('message', 'Pedido Rechazado');
        } else {
            return redirect()->route('productos.create', ['pedido' => $pedido]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        $productos = json_decode($inventario->carrito, false);

        foreach ($productos as $prod) {
            $data = Producto::Find($prod->id);
            if ($data ==  null) {
                return redirect()->back()->with('error', 'Pedido posee producto que ya no existe');
            }
        }

        $productosInfo = Producto::all();
        $productosInfo = $productosInfo->keyBy('id');
        return view('inventarios.editar', compact('inventario', 'productos', 'productosInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        if ($inventario->status == 'Pendiente') {
            $this->actualizarProductosSolicitados(json_decode($inventario->carrito, false), true);
            $inventario->delete();
            return redirect()->route('inventarios.index')->with('message', 'Su solicitud ha sido eliminada');
        } else {
            return redirect()->route('inventarios.index')->with('error', 'No se puede eliminar una solicitud que ya ha sido revisada por un supervisor');
        }
    }

    public function autorizarIndex()
    {
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/

        if (Auth::user()->can('producto.todosalmacenes')) {
            $inventariosPendientes = Inventario::where('status', 'Pendiente')->get();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
        }

        // Ordenamos los inventarios pendientes por fecha de creación de forma ascendente
        $inventariosPendientes = $inventariosPendientes->sortBy('created_at');
        return view('inventarios.autorizar', compact('inventariosPendientes'));
    }

    public function entregarIndex()
    {
        /*if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }*/
        if (Auth::user()->can('producto.todosalmacenes')) {
            $inventariosAutorizados = Inventario::where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
        } else {
            $inventariosAutorizados = Inventario::where('area', Auth::user()->datos->area)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get(); //Muestra todos los pedidos autorizados en la misma area
            /*
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }*/
        }
        // Ordenamos los inventarios pendientes por fecha de creación de forma ascendente
        $inventariosAutorizados = $inventariosAutorizados->sortBy('created_at');
        return view('inventarios.entregar', compact('inventariosAutorizados'));
    }
    public function entregadosIndex()
    {
        $inventariosEntregados = Inventario::where('status', 'Entregado')->get();
        /*
        if (Auth::user()->hasRole('usuario')) {
            return abort(403);
        }
        if (Auth::user()->hasRole('admin')) {
            $inventariosEntregados = Inventario::where('status', 'Entregado')->get();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosEntregados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Entregado')->get();
                $inventariosEntregados = $inventariosEntregados->merge($inventarios);
            }
        }
        */
        return view('inventarios.entregados', compact('inventariosEntregados'));
    }

    public function autorizarProductos(Inventario $inventario)
    {
        //dd("entra");
        if (!(($inventario->status == "Autorizado" and Auth::user()->can('inventario.entregar')) or ($inventario->status == "Pendiente" and Auth::user()->can('inventario.autorizar')))) {
            return abort(403);
        }
        $productos = json_decode($inventario->carrito, false);
        // $productosInfo = Producto::all();
        // $productosInfo = $productosInfo->keyBy('id');
        $productoIds = collect($productos)->pluck('id')->toArray();
        //info de los productos del carrito que existen en la base de datos
        $productosInfo = Producto::whereIn('id', $productoIds)->get()->keyBy('id');
        //se crea un array para almacenar las existencias de los productos del carrito
        $existencias = [];
        //se verifican exitencias existencias y se asignan a los productos del carrito
        foreach ($productos as $producto) {
            if (isset($productosInfo[$producto->id])) {
                $existencias[$producto->id] = $productosInfo[$producto->id]->existencias;
            } else {
                //si el producto no existe en la base de datos, asignar existencias como 0
                $existencias[$producto->id] = 0;
            }
        }

        return view('inventarios.autorizarProductos', compact('inventario', 'productos', 'productosInfo'));
    }

    public function comentario(Inventario $inventario, $id, Request $request)
    {
        $producto = Producto::findOrFail($id);
        $carrito = json_decode($inventario->carrito, false);
        $collection = collect($carrito);
        $collection = $collection->keyBy('id');

        if (isset($collection->get($id)->options)) {
            if (isset($collection->get($id)->options->justificacion)) {
                $collection->get($id)->options->justificacion = $request->comentario;
            } else {
                $collection->get($id)->options->justificacion = $request->comentario;
            }
        } else {
            $collection->get($id)->put('options', null);
            $collection->get($id)->options->put('justificacion', null);
            $collection->get($id)->options->justificacion = $request->comentario;
        }
        $collection = $collection->keyBy('rowId');
        $inventario->carrito = json_encode($collection);
        $inventario->save();

        $productos = json_decode($inventario->carrito, false);
        $productosInfo = Producto::all();
        $productosInfo = $productosInfo->keyBy('id');
        // dd($request->comentario);
        return view('inventarios.autorizarProductos', compact('inventario', 'id', 'productos', 'productosInfo'));
    }

    public function entregarProductos(Inventario $inventario)
    {
        $productos = json_decode($inventario->carrito, false);
        $productosInfo = Producto::all();
        $productosInfo = $productosInfo->keyBy('id');
        return view('inventarios.autorizarProductos', compact('inventario', 'productos', 'productosInfo'));
    }

    public function inventarioGeneral()
    {
        if (Auth::user()->eid == '9JJGM' || Auth::user()->can('producto.todosalmacenes')) {
            $productos = Producto::all();
            return view('inventarios.inventario_General', compact('productos'));
        }
        return abort(403);
    }

    //Here we change the status of the inventario
    public function changeInventarioStatus(Inventario $inventario, $status)
    {
        if ($status == 'Autorizado' || $status == 'Entregado') {
            $autorizados = 0;
            $noAutorizados = 0;
            $entregados = 0;
            $noEntregados = 0;
            $carrito = json_decode($inventario->carrito, false);
            foreach ($carrito as $item) {
                if ($item->options->status == 'Pendiente') {
                    //$this->actualizarProductosSolicitados($item, $item->options->status);
                    return redirect()->back()->with('error', 'No se puede cambiar el status de una solicitud que contiene productos que no han sido revisados');
                } else if ($item->options->status == 'Autorizado') {
                    $autorizados++;
                } else if ($item->options->status == 'Rechazado') {
                    $noAutorizados++;
                } else if ($item->options->status == 'Entregado') {
                    $producto = Producto::find($item->id);
                    $producto->existencias = $producto->existencias - $item->options->qtyAuth;
                    $producto->save();
                    Baja::create([
                        'eid' => 'Pedido N.°' . ' ' . $inventario->id,
                        'id_producto' => $producto->id,
                        'consumidos' => $item->options->qtyAuth,
                        'area' => $producto->area,
                        'subarea' => $producto->subarea,
                    ]);

                    if ($inventario->almacen != $inventario->subarea) {
                        $destino = $inventario->subarea;
                        $areaDestino = substr($destino, 0, -1);
                        $producto2 = Producto::where('subarea', $destino)->where('nombre_producto', $item->name)->get();
                        if (count($producto2) != 0) {
                            $producto2 = $producto2[0];
                            $producto2->existencias = $producto2->existencias + $item->options->qtyAuth;

                            $producto2->save();
                        } else {
                            $producto = Producto::find($item->id);
                            Producto::create([
                                'nombre_producto' => $producto->nombre_producto,
                                'unidad' => $producto->unidad,
                                'stock_minimo' => $producto->stock_minimo,
                                'id_categoria' => $producto->id_categoria,
                                'area' => $areaDestino,
                                'subarea' => $destino,
                                'existencias' => $item->options->qtyAuth,
                                'total_agregado' => $item->options->qtyAuth,
                                'photo_prod' => $producto->photo_prod,
                            ]);
                        }
                    }

                    $entregados++;
                } else if ($item->options->status == 'No entregado') {
                    $noEntregados++;
                }
            }
            if (($autorizados == 0 && $noAutorizados != 0 && $entregados == 0) || ($entregados == 0 && $noEntregados != 0)) {
                //return redirect()->route('inventarios.entregar')->with('error', 'No se puede cambiar el status de una solicitud que contiene productos que solo han sido rechazados');
                return redirect()->back()->with('error', 'No se puede cambiar el status de una solicitud que contiene productos que solo han sido rechazados');
            }
            if ($status == 'Autorizado') {
                $inventario->fecha_autorizado = Carbon::now();
                $inventario->status = $status;
                $inventario->save();
                $almacen = Almacen::query()->where('almacen_clave', $inventario->almacen)->first();
                $jefe = User::query()->where('eid', $almacen->jefe_eid)->first();
                $subareaName = Subarea::query()->where('subarea_clave', $inventario->subarea)->pluck('subarea_nombre')->first();
                $jefeNombre = $jefe->datos->paterno . " " . $jefe->datos->materno . " " . $jefe->datos->nombre;
                $today = Carbon::today()->format('Y-m-d');

                $nombreTmp = str_replace(",", "", $inventario['nombre']);
                $notificaciones = [
                    [
                        'destinatario' => $inventario['email'],
                        'asunto' => 'Pedido autorizado',
                        'cuerpo' => 'Pedido con folio #' . $inventario->id . ' autorizado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
                    ],
                    [
                        'destinatario' => $jefe->email,
                        'asunto' => 'Pedido autorizado',
                        'cuerpo' => 'Pedido con folio #' . $inventario->id . ' autorizado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
                    ],
                ];

                foreach ($notificaciones as $notificacion) {
                    Notificacion::create($notificacion);
                }
                //Notificacion::createMany($notificaciones);
                //                return redirect()->route('inventarioEmails.codigoVerificacion', ['email' => $inventario->email, 'folio' => $inventario->id]);
            } else {
                $inventario->fecha_entrega = Carbon::now();
                $almacen = Almacen::query()->where('almacen_clave', $inventario->almacen)->first();
                $jefe = User::query()->where('eid', $almacen->jefe_eid)->first();
                $subareaName = Subarea::query()->where('subarea_clave', $inventario->subarea)->pluck('subarea_nombre')->first();
                $jefeNombre = $jefe->datos->paterno . " " . $jefe->datos->materno . " " . $jefe->datos->nombre;
                $today = Carbon::today()->format('Y-m-d');

                $nombreTmp = str_replace(",", "", $inventario['nombre']);
                $notificaciones = [
                    [
                        'destinatario' => $inventario['email'],
                        'asunto' => 'Pedido entregado',
                        'cuerpo' => 'Pedido con folio #' . $inventario->id . ' fue entregado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
                    ],
                    [
                        'destinatario' => $jefe->email,
                        'asunto' => 'Pedido entregado',
                        'cuerpo' => 'Pedido con folio #' . $inventario->id . ' fue entregado el dia ' . $today . ' por ' . $nombreTmp . ' al almacen ' . $almacen->almacen_nombre . ' encargado de revisar el pedido ' . $jefeNombre . ' lugar de entrega ' . $subareaName,
                    ],
                ];


                foreach ($notificaciones as $notificacion) {
                    Notificacion::create($notificacion);
                }
            }
        }
        $inventario->status = $status;
        $inventario->save();
        return redirect()->route('inventarios.entregar')->with('message', 'El pedido fue ' . $status);
    }

    //Here we change the status of the product to $status
    public function changeProductStatus(Inventario $inventario, $status, $id, Request $request)
    {
        $producto = Producto::findOrFail($id);
        $carrito = json_decode($inventario->carrito, false);
        $collection = collect($carrito);
        $collection = $collection->keyBy('id');
        /*if ($status == 'Autorizado' && $request->cantAuth < $collection->get($id)->qty) {
            $collection->get($id)->options->status = "Autorizado parcialmente";
        }else{
            $collection->get($id)->options->status = $status;
        }*/
        if ($status == 'Autorizado' && $request->cantAuth != $collection->get($id)->qty) {
            $status = "Autorizado parcialmente";
        }
        $collection->get($id)->options->status = $status;
        if ($status == "Autorizado" || $status == "Autorizado parcialmente") {
            $collection->get($id)->options->qtyAuth = $request->cantAuth;
        }
        $collection = $collection->keyBy('rowId');
        $inventario->carrito = json_encode($collection);
        $inventario->save();
        return redirect()->route('inventarios.autorizarProductos', compact('inventario'))->with('message', 'El status del producto cambio a ' . $status);
    }

    public function updateTable(Request $request)
    {
        $area = $request->area;
        $status = $request->status;
        $inventarios = Inventario::when($area == "ALL", function () use ($status) {
            return Inventario::where('status', $status)->with('almacenes')->with('subareas')->get();
        }, function () use ($area, $status) {
            return Inventario::where('area', $area)->where('status', $status)->with('almacenes')->with('subareas')->get();
        });

        foreach ($inventarios as $inventario) {
            $inventario->almacen_nombre = $inventario->almacenes()->first()->almacen_nombre;
            $inventario->subarea_nombre = $inventario->subareas()->first()->subarea_nombre;
        }

        return response()->json(
            [
                'success' => true,
                'lista' => $inventarios,
            ]
        );
    }

    public function inicio()
    {
        if (Auth::user()->hasRole(['admin', 'SuperRoot'])) {
            $countPendientes = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Pendiente')->get();
            $countPendientes = $countPendientes[0]->count;
            $countAutorizados = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Autorizado')->get();
            $countAutorizados = $countAutorizados[0]->count;
            $countMermas = Merma::all()->count();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
            $countPendientes = count($inventariosPendientes);

            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }
            $countAutorizados = count($inventariosAutorizados);

            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $mermas = collect([]);
            foreach ($productos as $p) {
                $m = Merma::where('producto_id', $p->id)->where('status', 'pendiente')->get();
                $mermas = $mermas->merge($m);
            }
            $countMermas = $mermas->count();
        }
        $countPedidos = Inventario::select(DB::raw('count(*) as count'))->where('eid', Auth::user()->eid)->get();
        $countPedidos = $countPedidos[0]->count;
        $area = auth()->user()->datos->area;
        $almacen = null;
        if($almacen == null){
            $almacen = "";
        }else{
            $almacen = Almacen::where('area_id', $area)->first()->almacen_clave;
        }
        $productos = Producto::where('subarea', $almacen)->count();
        $countCategorias = Categoria::select(DB::raw('count(*) as count'))->get();
        $countCategorias = $countCategorias[0]->count;

        $vc = DB::table('view_counter')->where('pagina', 'merla')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'merla')->update(['visitas' => $vc]);

        return view('inventarios.inicio', compact('countPendientes', 'countAutorizados', 'productos', 'countCategorias', 'countPedidos', 'countMermas'));
    }

    public function iniciopedidos()
    {
        if (Auth::user()->hasRole(['admin', 'SuperRoot'])) {
            $countPendientes = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Pendiente')->get();
            $countPendientes = $countPendientes[0]->count;
            $countAutorizados = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Autorizado')->get();
            $countAutorizados = $countAutorizados[0]->count;
            $countMermas = Merma::all()->count();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
            $countPendientes = count($inventariosPendientes);

            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }
            $countAutorizados = count($inventariosAutorizados);

            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $mermas = collect([]);
            foreach ($productos as $p) {
                $m = Merma::where('producto_id', $p->id)->where('status', 'pendiente')->get();
                $mermas = $mermas->merge($m);
            }
            $countMermas = $mermas->count();
        }
        $countPedidos = Inventario::select(DB::raw('count(*) as count'))->where('eid', Auth::user()->eid)->get();
        $countPedidos = $countPedidos[0]->count;
        $area = auth()->user()->datos->area;
        $almacen = Almacen::where('area_id', $area)->first()->almacen_clave;
        $productos = Producto::where('subarea', $almacen)->count();
        $countCategorias = Categoria::select(DB::raw('count(*) as count'))->get();
        $countCategorias = $countCategorias[0]->count;

        $vc = DB::table('view_counter')->where('pagina', 'merla')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'merla')->update(['visitas' => $vc]);

        return view('inventarios.iniciopedidos', compact('countPendientes', 'countAutorizados', 'productos', 'countCategorias', 'countPedidos', 'countMermas'));
    }

    public function inicioinventario()
    {
        if (Auth::user()->hasRole('admin')) {
            $countPendientes = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Pendiente')->get();
            $countPendientes = $countPendientes[0]->count;
            $countAutorizados = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Autorizado')->get();
            $countAutorizados = $countAutorizados[0]->count;
            $countMermas = Merma::all()->count();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
            $countPendientes = count($inventariosPendientes);

            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }
            $countAutorizados = count($inventariosAutorizados);

            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $mermas = collect([]);
            foreach ($productos as $p) {
                $m = Merma::where('producto_id', $p->id)->where('status', 'pendiente')->get();
                $mermas = $mermas->merge($m);
            }
            $countMermas = $mermas->count();
        }
        $countPedidos = Inventario::select(DB::raw('count(*) as count'))->where('eid', Auth::user()->eid)->get();
        $countPedidos = $countPedidos[0]->count;
        $area = auth()->user()->datos->area;
        $almacen = Almacen::where('area_id', $area)->first()->almacen_clave;
        $productos = Producto::where('subarea', $almacen)->count();
        $countCategorias = Categoria::select(DB::raw('count(*) as count'))->get();
        $countCategorias = $countCategorias[0]->count;

        $vc = DB::table('view_counter')->where('pagina', 'merla')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'merla')->update(['visitas' => $vc]);

        return view('inventarios.inicioinventario', compact('countPendientes', 'countAutorizados', 'productos', 'countCategorias', 'countPedidos', 'countMermas'));
    }

    public function inicioproductos()
    {
        if (Auth::user()->hasRole(['admin', 'SuperRoot'])) {
            $countPendientes = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Pendiente')->get();
            $countPendientes = $countPendientes[0]->count;
            $countAutorizados = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Autorizado')->get();
            $countAutorizados = $countAutorizados[0]->count;
            $countMermas = Merma::all()->count();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
            $countPendientes = count($inventariosPendientes);

            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }
            $countAutorizados = count($inventariosAutorizados);

            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $mermas = collect([]);
            foreach ($productos as $p) {
                $m = Merma::where('producto_id', $p->id)->where('status', 'pendiente')->get();
                $mermas = $mermas->merge($m);
            }
            $countMermas = $mermas->count();
        }
        $countPedidos = Inventario::select(DB::raw('count(*) as count'))->where('eid', Auth::user()->eid)->get();
        $countPedidos = $countPedidos[0]->count;
        $area = auth()->user()->datos->area;
        $almacen = Almacen::where('area_id', $area)->first()->almacen_clave;
        $productos = Producto::where('subarea', $almacen)->count();
        $countCategorias = Categoria::select(DB::raw('count(*) as count'))->get();
        $countCategorias = $countCategorias[0]->count;

        $vc = DB::table('view_counter')->where('pagina', 'merla')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'merla')->update(['visitas' => $vc]);

        return view('inventarios.inicioproductos', compact('countPendientes', 'countAutorizados', 'productos', 'countCategorias', 'countPedidos', 'countMermas'));
    }

    public function iniciomermas()
    {
        if (Auth::user()->hasRole(['admin', 'SuperRoot'])) {
            $countPendientes = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Pendiente')->get();
            $countPendientes = $countPendientes[0]->count;
            $countAutorizados = Inventario::select(DB::raw('count(*) as count'))->where('status', 'Autorizado')->get();
            $countAutorizados = $countAutorizados[0]->count;
            $countMermas = Merma::all()->count();
        } else {
            $almacenes = Almacen::where('jefe_eid', auth()->user()->datos->eid)->get();
            $inventariosPendientes = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Pendiente')->get();
                $inventariosPendientes = $inventariosPendientes->merge($inventarios);
            }
            $countPendientes = count($inventariosPendientes);

            $inventariosAutorizados = collect([]);
            foreach ($almacenes as $a) {
                $inventarios = Inventario::where('almacen', $a->almacen_clave)->where('status', 'Autorizado')->orWhere('status', 'Autorizado parcialmente')->get();
                $inventariosAutorizados = $inventariosAutorizados->merge($inventarios);
            }
            $countAutorizados = count($inventariosAutorizados);

            $productos = collect([]);
            foreach ($almacenes as $a) {
                $prod = Producto::where('subarea', $a->almacen_clave)->get();
                $productos = $productos->merge($prod);
            }
            $mermas = collect([]);
            foreach ($productos as $p) {
                $m = Merma::where('producto_id', $p->id)->where('status', 'pendiente')->get();
                $mermas = $mermas->merge($m);
            }
            $countMermas = $mermas->count();
        }
        $countPedidos = Inventario::select(DB::raw('count(*) as count'))->where('eid', Auth::user()->eid)->get();
        $countPedidos = $countPedidos[0]->count;
        $area = auth()->user()->datos->area;
        $almacen = Almacen::where('area_id', $area)->first()->almacen_clave;
        $productos = Producto::where('subarea', $almacen)->count();
        $countCategorias = Categoria::select(DB::raw('count(*) as count'))->get();
        $countCategorias = $countCategorias[0]->count;

        $vc = DB::table('view_counter')->where('pagina', 'merla')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'merla')->update(['visitas' => $vc]);

        return view('inventarios.iniciomermas', compact('countPendientes', 'countAutorizados', 'productos', 'countCategorias', 'countPedidos', 'countMermas'));
    }

    private function actualizarProductosSolicitados($carrito, $cancelado)
    {
        if (!$cancelado)
            foreach ($carrito as $item) {
                $cantidad = $item->qty;
                $producto = Producto::find($item->id);
                if ($item->options->status == "Pendiente")
                    $producto->solicitados_cant += $cantidad;
                $producto->save();
            }
        else
            foreach ($carrito as $item) {
                $cantidad = $item->qty;
                $producto = Producto::find($item->id);
                $producto->solicitados_cant -= $cantidad;
                if ($producto->solicitados_cant < 0)
                    $producto->solicitados_cant = 0;
                $producto->save();
            }
    }
}
