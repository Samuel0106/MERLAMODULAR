<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Almacen;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Area;
use App\Models\Subarea;
use App\Models\Datosuser;

class OpenAIService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = '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';

        $this->baseUrl = 'https://api.openai.com/v1';
    }

    public function responder(string $query): string
    {
        // Primero intento con lógica interna
        $respuesta = $this->procesarConsultaInterna($query);
        if ($respuesta !== null) {
            return $respuesta;
        }

        // Si no se detectó ninguna intención clara, entonces uso OpenAI
        $data = [
            'productos'   => Producto::all()->toArray(),
            'almacenes'   => Almacen::all()->toArray(),
            'inventarios' => Inventario::all()->toArray(),
            'usuarios'    => Datosuser::all()->toArray(),
            'categorias'  => Categoria::all()->toArray(),
            'areas'       => Area::all()->toArray(),
            'subareas'    => Subarea::all()->toArray(),
        ];

        return $this->generateDynamicResponse($query, $data);
    }

    private function procesarConsultaInterna(string $query): ?string
    {
        $queryLower = strtolower($query);

        // --- Pedidos / Inventarios ---
        if (preg_match('/estatus.*pedido\s*(\d+)/', $queryLower, $match)) {
            $id = $match[1];
            $pedido = Inventario::find($id);
            if ($pedido) {
                return "El estatus del pedido {$id} es: {$pedido->status}.";
            } else {
                return "No encontré ningún pedido con el ID {$id}.";
            }
        }

        if (preg_match('/fecha.*entrega.*pedido\s*(\d+)/', $queryLower, $match)) {
            $id = $match[1];
            $pedido = Inventario::find($id);
            if ($pedido) {
                return "La fecha de entrega del pedido {$id} es: {$pedido->fecha_entrega}.";
            } else {
                return "No encontré ningún pedido con el ID {$id}.";
            }
        }

        // --- Productos ---
        if (preg_match('/(existencias|hay|disponible).*producto\s*(\w+)/', $queryLower, $match)) {
            $nombre = $match[2];
            $producto = Producto::where('nombre_producto', 'LIKE', "%$nombre%")->first();
            if ($producto) {
                return "El producto '{$producto->nombre_producto}' tiene {$producto->existencias} existencias.";
            } else {
                return "No encontré ningún producto que coincida con '{$nombre}'.";
            }
        }

        if (str_contains($queryLower, 'producto') && str_contains($queryLower, 'categoría')) {
            $categorias = Categoria::all();
            $productosPorCategoria = [];
            foreach ($categorias as $cat) {
                $productosPorCategoria[$cat->nombre_categoria] = Producto::where('categoria_id', $cat->id)->pluck('nombre_producto')->toArray();
            }
            $respuesta = '';
            foreach ($productosPorCategoria as $categoria => $productos) {
                $respuesta .= "Categoría: {$categoria} -> " . implode(', ', $productos) . "\n";
            }
            return $respuesta;
        }

          // --- Almacenes habilitados ---
    if (str_contains($queryLower, 'almacenes disponibles') || str_contains($queryLower, 'almacenes habilitados')) {
        $almacenes = Almacen::where('habilitado', 1)->pluck('almacen_nombre')->toArray();
        if (count($almacenes) > 0) {
            return "Los almacenes habilitados son: " . implode(', ', $almacenes);
        } else {
            return "No se encontraron almacenes habilitados en MERLA.";
        }
    }

    if (preg_match('/almacén.*producto\s*(\w+)/', $queryLower, $match)) {
        $nombreProducto = $match[1];
        $producto = Producto::where('nombre_producto', 'LIKE', "%$nombreProducto%")->first();
        if ($producto) {
            $almacen = Almacen::where('id', $producto->almacen_id)->first();
            return "El producto '{$producto->nombre_producto}' está almacenado en el almacén: {$almacen->almacen_nombre}.";
        } else {
            return "No encontré el producto '{$nombreProducto}'.";
        }
    }

    // --- Usuarios del sistema ---
    if (str_contains($queryLower, 'usuarios registrados') || str_contains($queryLower, 'cuántos usuarios')) {
        $total = Datosuser::count();
        return "Actualmente hay {$total} usuarios registrados en MERLA.";
    }

    if (preg_match('/usuario.*id\s*(\d+)/', $queryLower, $match)) {
        $idUsuario = $match[1];
        $usuario = Datosuser::find($idUsuario);
        if ($usuario) {
            return "El usuario con ID {$idUsuario} es {$usuario->nombre} {$usuario->paterno} {$usuario->materno}.";
        } else {
            return "No encontré ningún usuario con el ID {$idUsuario}.";
        }
    }

        // --- Categorías de productos ---
        if (str_contains($queryLower, 'categorías de productos')) {
            $categorias = Categoria::pluck('nombre_categoria')->toArray();
            return "Las categorías disponibles son: " . implode(', ', $categorias);
        }

        // --- Áreas ---
        if (str_contains($queryLower, 'áreas disponibles') || str_contains($queryLower, 'áreas del sistema')) {
            $areas = Area::pluck('area_nombre')->toArray();
            return "Las áreas disponibles son: " . implode(', ', $areas);
        }

        // --- Subáreas ---
        if (str_contains($queryLower, 'subáreas disponibles')) {
            $subareas = Subarea::pluck('subarea_nombre')->toArray();
            return "Las subáreas disponibles son: " . implode(', ', $subareas);
        }

        // Si no se detectó ninguna intención conocida
        return null;
    }

    private function generateDynamicResponse(string $query, array $data): string
    {
        if (empty($query)) {
            throw new \InvalidArgumentException('La consulta no puede estar vacía.');
        }

        $contexto = json_encode($data);

        // Preparar el mensaje
        $prompt = "MERLA. Datos disponibles:\n";

        foreach ($data['productos'] as $p) {
            $prompt .= "Producto: {$p['nombre_producto']}, Existencias: {$p['existencias']}\n";
        }

        foreach ($data['inventarios'] as $inv) {
            $prompt .= "Pedido ID: {$inv['id']}, Estado: {$inv['status']}, Entrega: {$inv['fecha_entrega']}\n";
        }

        $prompt .= "\nConsulta del usuario: {$query}";

        // Enviar a OpenAI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->withOptions([
            'verify' => false,
        ])->post("{$this->baseUrl}/chat/completions", [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "Eres un asistente experto en Manejo y Estrategia de Registros para Logística y Almacenes por sus siglas MERLA un sistema de inventarios . Responde de forma clara y concisa."
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.3,
            'max_tokens' => 300,
        ]);

        $body = $response->json();
        Log::info('Respuesta OpenAI:', $body);

        return $body['choices'][0]['message']['content'] ?? 'No pude generar una respuesta en este momento.';
    }
    public function generateResponse(string $query, array $data) {
        return $this->generateDynamicResponse($query, $data);
    }
    
}
