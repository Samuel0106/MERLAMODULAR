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
        $this->apiKey = env('OPENAI_API_KEY');
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

        if (str_contains($queryLower, 'cómo hacer un pedido') || str_contains($queryLower, 'crear pedido')) {
            return "Para hacer un pedido, dirígete al módulo de Productos, selecciona lo que necesitas y agrégalo al carrito. Luego confirma el pedido en la sección del Carrito.";
        }

        if (str_contains($queryLower, 'ver historial') || str_contains($queryLower, 'consultar historial')) {
            return "Puedes consultar el historial de pedidos en la sección 'Historial de Bajas' desde el menú principal.";
        }

        if (str_contains($queryLower, 'gestionar productos') || str_contains($queryLower, 'agregar producto')) {
            return "Puedes gestionar productos en el apartado de 'Productos' del menú. Desde ahí puedes crear, editar o eliminar productos.";
        }

        if (str_contains($queryLower, 'gestionar usuarios') || str_contains($queryLower, 'crear usuario')) {
            return "Para crear o editar usuarios, ve al módulo de 'Usuarios'. Ahí puedes asignar roles, áreas, subáreas y divisiones.";
        }

        if (str_contains($queryLower, 'ver almacenes') || str_contains($queryLower, 'navegar almacén')) {
            return "En la sección de 'Almacenes' puedes visualizar, habilitar o deshabilitar almacenes disponibles para el sistema.";
        }

        if (str_contains($queryLower, 'ver categorías') || str_contains($queryLower, 'gestionar categorías')) {
            return "En el módulo 'Categorías' puedes crear nuevas categorías o modificar las existentes para clasificar tus productos.";
        }
        // 3. ¿Qué puedo hacer en MERLA?
    if (str_contains($queryLower, '¿qué puedo hacer') || str_contains($queryLower, 'que puedo hacer') || str_contains($queryLower, 'funciones merla')) {
        $acciones = implode(", ", array_keys($this->funcionesSistema));
        return "En MERLA puedes realizar acciones como: $acciones.";
    }

    // 4. ¿Qué módulos hay?
    if (str_contains($queryLower, '¿qué módulos hay') || str_contains($queryLower, 'que modulos hay') || str_contains($queryLower, 'módulos del sistema')) {
        return "Los módulos disponibles en MERLA incluyen: Productos, Inventarios, Bajas, Usuarios, Roles, Categorías y Almacenes.";
    }

    // 5. ¿Qué permisos necesito para crear usuarios?
    if (str_contains($queryLower, 'permiso') && str_contains($queryLower, 'crear') && str_contains($queryLower, 'usuario')) {
        return "Para crear usuarios necesitas el permiso: 'users.create'.";
    }

        // Si no se detectó ninguna intención conocida
        return null;
    }
    
    private $funcionesSistema = [
        'crear pedido' => 'Ir a Productos -> Agregar al carrito -> Ver carrito -> Enviar pedido',
        'dar de baja' => 'Ir a Bajas -> Seleccionar producto -> Llenar formulario',
        'nuevo usuario' => 'Ir a Usuarios -> Crear -> Llenar datos -> Guardar',
        'autorizar pedido' => 'Ir a Inventarios -> Ver pedidos pendientes -> Autorizar',
        'ver historial de bajas' => 'Ir a Bajas -> Historial',
    ];
    

    private function generateDynamicResponse(string $query, array $data): string
    {
        if (empty($query)) {
            throw new \InvalidArgumentException('La consulta no puede estar vacía.');
        }

        $contexto = json_encode($data);

        // Preparar el queryLower
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
                    'content' => "Eres un asistente virtual llamado Merl-IA, experto en el sistema MERLA (Manejo y Estrategia de Registros para Logística y Almacenes). Solo responde preguntas relacionadas con pedidos, inventarios, productos, almacenes, usuarios, categorías, áreas y subáreas. Si la pregunta no es relevante para MERLA, responde amablemente que solo puedes ayudar con temas del sistema."
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
