<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Método para realizar pedidos
    public function realizarPedidos()
    {
        // Aquí se manejará la lógica para realizar pedidos
        return view('pedidos.realizar'); // Asegúrate de tener la vista 'pedidos/realizar'
    }

    // Método para consultar el estado de los pedidos
    public function estadoPedidos()
    {
        // Aquí se manejará la lógica para consultar el estado de los pedidos
        return view('pedidos.estado'); // Asegúrate de tener la vista 'pedidos/estado'
    }
}
