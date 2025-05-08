<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Categoria;
use App\Models\Almacen;
use App\Models\User;
use App\Models\Datosuser;
use App\Models\Area;
use App\Models\Subarea;

class AiQueryController extends Controller
{
    public function query(Request $request, OpenAIService $openAIService)
{
    // Obtener el mensaje
    $query = $request->input('message'); 

    if (!$query) {
        \Log::info('El mensaje está vacío.');
        return response()->json(['reply' => 'Por favor, ingresa una pregunta.']);
    }

    // Obtener datos del sistema como contexto
    $data = $this->fetchDataResumen();

    // Enviar la consulta y el contexto a OpenAI para generar la respuesta
    $response = $openAIService->generateResponse($query, $data);

    return response()->json(['reply' => $response]);
}

private function fetchDataResumen()
{
    // Aquí puedes incluir los datos más relevantes sobre los pedidos.
    return [
        'productos' => Producto::select('id', 'nombre_producto', 'existencias')->get(),
        'almacenes' => Almacen::select('id', 'almacen_nombre', 'habilitado')->get(),
        'inventarios' => Inventario::select('id', 'status', 'carrito', 'almacen', 'fecha_entrega')->get(),
        'usuarios' => Datosuser::select('id', 'nombre', 'paterno', 'materno')->get(),
        'categorias' => Categoria::select('id', 'nombre_categoria')->get(),
        'areas' => Area::select('id', 'area_nombre')->get(),
        'subareas' => Subarea::select('id', 'subarea_nombre')->get(),
    ];
}


}
