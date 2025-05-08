<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\Inventario;
use App\Models\Pedidoespecial;
use App\Models\User;
use App\Models\Datosuser;
use App\Models\Almacen;
use App\Models\Baja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatBrainService
{
    protected $openAI;

    public function __construct(OpenAIService $openAI)
    {
        $this->openAI = $openAI;
    }

    public function responder($userMessage)
    {
        $respuestaInterna = $this->procesarConsultaInterna($userMessage);
        if ($respuestaInterna) {
            return $respuestaInterna;
        }

        $messages = [
            ['role' => 'system', 'content' => 'Eres un asistente útil que responde preguntas sobre el sistema de gestión de inventario, almacenes, usuarios y productos de la empresa.'],
            ['role' => 'user', 'content' => $userMessage],
        ];

        return $this->openAI->chat($messages);
    }

    private function procesarConsultaInterna($message)
    {
        $mensaje = strtolower($message);

        if (str_contains($mensaje, 'estado') && str_contains($mensaje, 'pedido especial')) {
            return $this->estadoPedidoEspecial($mensaje);
        }

        if (str_contains($mensaje, 'estado') && str_contains($mensaje, 'pedido')) {
            return $this->estadoPedidoNormal($mensaje);
        }

        if (str_contains($mensaje, 'productos') && str_contains($mensaje, 'pedido especial')) {
            return $this->productosPedidoEspecial($mensaje);
        }

        if (str_contains($mensaje, 'baja existencia') || str_contains($mensaje, 'existencia baja') || (str_contains($mensaje, 'productos') && str_contains($mensaje, 'pocos'))) {
            return $this->productoExistenciaBaja();
        }

        if (str_contains($mensaje, 'productos disponibles')) {
            return $this->productosDisponibles();
        }

        if (str_contains($mensaje, 'inventario total') && str_contains($mensaje, 'jalisco')) {
            return $this->inventarioTotalJalisco();
        }

        if (str_contains(strtolower($mensaje), 'sí')) {
            return $this->productosDisponibles(true);  // Mostrar más productos
        }
        
        return "Lo siento, no entendí tu consulta. ¿Puedes reformularla o darme más detalles?";
    }

    // ✅ Estado del pedido normal desde Inventario
    private function estadoPedidoNormal($mensaje)
    {
        preg_match('/pedido (\d+)/', $mensaje, $match);
        $id = $match[1] ?? null;

        if (!$id) {
            return "Por favor proporciona un ID de pedido válido.";
        }

        $pedido = Inventario::find($id);
        if (!$pedido) {
            return "No se encontró el pedido con ID $id.";
        }

        return "El estado del pedido con ID $id es: " . ucfirst($pedido->status) . ".";
    }

    // ✅ Estado del pedido especial
    private function estadoPedidoEspecial($mensaje)
    {
        preg_match('/pedido especial (\d+)/', $mensaje, $match);
        $id = $match[1] ?? null;

        if (!$id) {
            return "Por favor proporciona un ID de pedido especial válido.";
        }

        $pedido = Pedidoespecial::find($id);
        if (!$pedido) {
            return "No se encontró el pedido especial con ID $id.";
        }

        return "El estado del pedido especial con ID $id es: " . ucfirst($pedido->status) . ".";
    }

    // ✅ Productos del pedido especial
    private function productosPedidoEspecial($mensaje)
    {
        preg_match('/pedido especial (\d+)/', $mensaje, $match);
        $id = $match[1] ?? null;

        if (!$id) {
            return "Proporcióname el ID del pedido especial.";
        }

        $pedido = Pedidoespecial::with('productos')->find($id);
        if (!$pedido) {
            return "No se encontró el pedido especial con ID $id.";
        }

        $nombres = $pedido->productos->pluck('nombre')->toArray();
        if (empty($nombres)) {
            return "El pedido especial $id no tiene productos asociados.";
        }

        return "Productos del pedido especial $id: " . implode(', ', $nombres) . ".";
    }

    private function productoExistenciaBaja()
{
    // Verifica si productos con existencias menores a 5 se están recuperando correctamente
    $productos = Producto::where('existencias', '<', 50)->get();

    if ($productos->isEmpty()) {
        return "Actualmente no hay productos con existencia baja.";
    }

    // Si hay productos, devuelve los nombres
    $lista = $productos->pluck('nombre_producto')->implode(', ');
    return "Productos con baja existencia: $lista.";
}

// ✅ Productos disponibles
private function productosDisponibles($verMas = false)
{
    // Si el usuario quiere ver más, obtenemos la siguiente página de productos
    if ($verMas) {
        // Aquí podrías manejar la paginación o lógica para obtener más productos
        $productos = Producto::where('existencias', '>', 100)
                             ->skip(5)  // Saltamos los primeros 5 productos
                             ->take(5)  // Tomamos los siguientes 5
                             ->get();
    } else {
        // Obtener los primeros 5 productos con más de 100 existencias
        $productos = Producto::where('existencias', '>', 100)->take(5)->get();
    }

    if ($productos->isEmpty()) {
        return "No hay productos disponibles con más de 100 existencias.";
    }

    // Mostrar productos
    $listaProductos = $productos->pluck('nombre_producto')->implode(', ');

    // Verificar si hay más productos
    $totalProductos = Producto::where('existencias', '>', 100)->count();
    if ($totalProductos > 5) {
        return "Productos disponibles actualmente: $listaProductos. ¿Quieres ver más? Responde 'sí' para ver más productos.";
    }

    return "Productos disponibles actualmente: $listaProductos.";
}

    // ✅ Inventario total Jalisco
    private function inventarioTotalJalisco()
    {
        $productos = Producto::where('division', 'like', 'jalisco')->get();

        if ($productos->isEmpty()) {
            return "No se encontraron productos registrados en la división Jalisco.";
        }

        $total = $productos->sum('existencias');
        return "
        El inventario total en Jalisco es de $total unidades.";
    }
     public function procesarConsulta($consulta)
{
    return $this->procesarConsultaInterna($consulta);
}
}
