<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RijController;
use App\Http\Controllers\BajaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MermaController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DatosuserController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PersonalesController;
use App\Http\Controllers\PedidoController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\GuzzleTestController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AiQueryController;

// Ruta para procesar la consulta de IA
Route::post('/ai/query', [AiQueryController::class, 'query'])->name('ai.query');

Route::post('/chat', [ChatController::class, 'send']);

Route::get('/guzzle-test', [GuzzleTestController::class, 'test']);

Route::get('/', function () {
    return redirect()->route('inventarios.inicio'); 
});
Route::get('/productosfetch',  [ProductoController::class, 'fetchProductos'])->name('productos.fetch');
Route::post('/filtrarProd',  [ProductoController::class, 'filtrarProd'])->name('productos.filtrarP');


//Nuevo
// Gestionar Productos
Route::get('productos/gestion', [App\Http\Controllers\ProductoController::class, 'gestionProductos'])->name('productos.gestionproductos');

Route::get('/getNotificationsExcel', [\App\Http\Controllers\NotificacionesController::class, 'exportNotificationsExcel']);
Route::get('/users/datosPersonales', [App\Http\Controllers\UserController::class, 'datosPersonales'])->name('users.datosPersonales');
Route::get('/users/usuariosBaja', [App\Http\Controllers\UserController::class, 'usuariosBaja'])->name('users.usuariosBaja');
Route::get('/users/centros', [App\Http\Controllers\UserController::class, 'centros'])->name('users.centros');
Route::get('productos/inventario', [App\Http\Controllers\ProductoController::class,'indexI'])->name('productos.indexI');
Route::get('productos/inventario', [App\Http\Controllers\ProductoController::class,'inicioproductos'])->name('productos.inicioproductos');
Route::get('productos/inventarioSubareas', [App\Http\Controllers\ProductoController::class,'indexSubareas'])->name('productos.indexSubareas');
Route::get('productos/inventarioGeneral', [App\Http\Controllers\ProductoController::class,'indexTotal'])->name('productos.indexTotal');
Route::get('productos/inventario/edit/{producto}', [App\Http\Controllers\ProductoController::class,'editI'])->name('productos.editI');
Route::patch('productos/inventario/edit/producto/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
Route::patch('productos/inventario/edit/producto/{producto}', [App\Http\Controllers\ProductoController::class, 'updateI'])->name('productos.updateAgregarExistencias');
Route::get('productos/inventario/eliminar/', [App\Http\Controllers\ProductoController::class,'eliminarExistenciasIndex'])->name('productos.eliminarExistenciasIndex');
Route::get('productos/inventario/eliminar/producto/{producto}', [App\Http\Controllers\ProductoController::class, 'eliminarExistenciasProducto'])->name('productos.eliminarExistenciasProducto');
Route::patch('productos/inventario/actualizar/producto/{producto}', [App\Http\Controllers\ProductoController::class, 'actualizarExistencias'])->name('productos.actualizarExistencias');
Route::post('/recargarCategorias', [App\Http\Controllers\ProductoController::class, 'updateTable']);
Route::post('/filtroInventarioGeneral', [App\Http\Controllers\ProductoController::class, 'filtroInventarioGeneral']);
Route::post('/filtroQuitarExistencias', [App\Http\Controllers\ProductoController::class, 'filtroQuitarExistencias']);


Route::get('/profile', 'App\Http\Controllers\UserController@profile')->name('user.profile');
Route::patch('/profile', 'App\Http\Controllers\UserController@update_profile')->name('user.profile.update');
Route::get('/datosuserexcel', [App\Http\Controllers\DatosuserController::class, 'datosuserexcel']);
Route::get('/inventarios/index', [App\Http\Controllers\InventarioController::class, 'index'])->name('inventarios.index');
Route::get('/inventarios/general', [App\Http\Controllers\InventarioController::class, 'inventarioGeneral'])->name('inventarios.inventarioGeneral');
Route::get('/inventarios/autorizarindex', [App\Http\Controllers\InventarioController::class, 'autorizarIndex'])->name('inventarios.autorizar');
Route::get('/inventarios/entregarindex', [App\Http\Controllers\InventarioController::class, 'entregarIndex'])->name('inventarios.entregar');
Route::get('/inventarios/entregadosindex', [App\Http\Controllers\InventarioController::class, 'entregadosIndex'])->name('inventarios.entregados');
Route::get('/inventarios/autorizarproductos/{inventario}', [App\Http\Controllers\InventarioController::class, 'autorizarProductos'])->name('inventarios.autorizarProductos');
Route::get('/inventarios/pedidoespecial', [App\Http\Controllers\InventarioController::class, 'pedidoespecial'])->name('inventarios.pedidoespecial');
Route::post('/inventarios/pedidoespecial', [App\Http\Controllers\InventarioController::class, 'especial_store'])->name('inventarios.especial_store');
Route::get('/inventarios/pedidoespecial/autorizar', [App\Http\Controllers\InventarioController::class, 'indexPedidoEspecial'])->name('inventarios.indexPedidoEspecial');
Route::get('/inventarios/pedidoespecial/autorizar/{id}', [App\Http\Controllers\InventarioController::class, 'authPedidoEspecial'])->name('inventarios.authPedidoEspecial');
Route::get('/inventarios/pedidoespecial/create/{pedido}/{auth}', [App\Http\Controllers\InventarioController::class, 'createpedidoespecial'])->name('inventarios.createpedidoespecial');
Route::get('/inventarios/changeinventariostatus/{inventario}/{status}', [App\Http\Controllers\InventarioController::class, 'changeInventarioStatus'])->name('inventarios.changeInventarioStatus');
Route::get('/inventarios/changeproductstatus/{inventario}/{status}/{id}', [App\Http\Controllers\InventarioController::class, 'changeProductStatus'])->name('inventarios.changeProductStatus');
Route::get('/inventarios/comentario/{inventario}/{id}', [App\Http\Controllers\InventarioController::class, 'comentario'])->name('inventarios.comentario');
Route::get('/inventarios/reponer/', [App\Http\Controllers\InventarioController::class, 'reponer'])->name('inventarios.reponer');
Route::get('/inventarios/proximosAgotar/', [App\Http\Controllers\InventarioController::class, 'proximosAgotar'])->name('inventarios.proximosAgotar');

// Route::get('/solicitars/reporte', function () { return Excel::download(new VacationDays, 'vacaciones_solicitadas.xlsx');})->name('solicitars.reporte');
// Route::get('/solicitars/reportes', [App\Http\Controllers\Solicitudes_vacacionesController::class,'reportes'])->name('solicitars.reportes');
// Route::post('/filtrarVacaciones', [App\Http\Controllers\Solicitudes_vacacionesController::class, 'filterReportes'])->name('solicitars.filterRep');


Route::get('buscar-user/{usuario}', [App\Http\Controllers\DatosuserController::class, 'buscarUsuario']);

Route::get('/get-subarea', function () {
    return Auth::user()->datos->subarea;
});

Route::middleware(['auth:sanctum', 'verified', 'datos.completos'])->group( function () {
    Route::post('/user/bajar', [UserController::class, 'bajar'])->name('users.bajar');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('soportes', SoporteController::class);
    Route::resource('inventarios', InventarioController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('productos', ProductoController::class);
    // Route::resource('solicitars', Solicitudes_vacacionesController::class);
    // Route::resource('solicitarfuera', VacacionesFueraController::class);
    Route::resource('datos', DatosuserController::class)->except(['create', 'edit', 'update']);
    Route::resource('bajas', BajaController::class);
    Route::get('/merma/añadir/{producto}', [MermaController::class, 'anadirMermas'])->name('mermas.anadirMermas');
    Route::post('/mermas/actualizar', [MermaController::class, 'autorizarMermas'])->name('mermas.autorizarMermas');
    Route::get('mermas/historial/',[MermaController::class, 'indexHistorial'])->name('mermas.indexHistorial');
    Route::post('/storeMerma', [App\Http\Controllers\MermaController::class, 'store']);
    Route::resource('mermas', MermaController::class);
    Route::resource('almacenes', AlmacenController::class);

    Route::post('/filtrarUsuarios', [App\Http\Controllers\UserController::class, 'filterUsers'])->name('users.filterUsers');
    Route::post('/filtrarProductos', [App\Http\Controllers\ProductoController::class, 'generalStockFilter']);
    Route::post('/almacenesSelect', [App\Http\Controllers\ProductoController::class, 'almacenes']);
    Route::post('/ubicacionSelect', [App\Http\Controllers\ProductoController::class, 'ubicacionInvGen']);

    // Route::post('/filtrarVacacionesFuera', [App\Http\Controllers\VacacionesFueraController::class, 'filterVacations'])->name('solicitarfuera.filterVacations');
    Route::post('/recargarCategorias', [App\Http\Controllers\ProductoController::class, 'updateTable']);
    Route::post('/actualizar', [App\Http\Controllers\InventarioController::class, 'updateTable']);
    Route::post('/areas', [App\Http\Controllers\UserController::class,'areas']);
    Route::post('/subareas', [App\Http\Controllers\UserController::class,'subareas']);

    //Rutas para acceder al inicio de cada módulo:
    Route::get('/usuarios', [App\Http\Controllers\UserController::class, 'inicio'])->name('users.inicio');
    Route::get('/', [App\Http\Controllers\InventarioController::class, 'inicio'])->name('inventarios.inicio');
    //Rutas main
    Route::get('/iniciopedidos', [App\Http\Controllers\InventarioController::class, 'iniciopedidos'])->name('inventarios.iniciopedidos');
    Route::get('/inicioinventario', [App\Http\Controllers\InventarioController::class, 'inicioinventario'])->name('inventarios.inicioinventario');
    Route::get('/inicioproductos', [App\Http\Controllers\InventarioController::class, 'inicioproductos'])->name('inventarios.inicioproductos');
    Route::get('/iniciomermas', [App\Http\Controllers\InventarioController::class, 'iniciomermas'])->name('inventarios.iniciomermas');
    
    //Ruta del correo de verificación.
    Route::get('/inventarioEmails', [App\Http\Controllers\InventarioEmailController::class, 'codigoVerificacion'])->name('inventarioEmails.codigoVerificacion');
    Route::get('/codigoInventario', [App\Http\Controllers\InventarioEmailController::class, 'verificarCodigo'])->name('inventarioEmails.verificarCodigo');
    Route::post('/addFoto', [App\Http\Controllers\InventarioEmailController::class, 'addFoto'])->name('inventarioEmails.addFoto');


    });

