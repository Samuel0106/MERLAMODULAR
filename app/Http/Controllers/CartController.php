<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'cantidad' => 'required|numeric|min:1|max:2147483647',  //int(11) en base de datos
        ]);

        if($request->producto_id != null){
            $producto = Producto::findOrFail($request->input(key:'producto_id'));
            Cart::add(
                $producto->id, 
                $producto->nombre_prod, 
                $request->input(key:'cantidad'),
                $price = 0,
                $weight = 0,
                $options = [
                    'status' => 'Pendiente',
                    'descripcion' => $request->descripcion,
                    'justificacion' => $request->justificacion,
                    'import' => $request->import,
                    'qtyAuth' => 0,
                ]
            );
        }else{
            Cart::add(
                $producto_id = 'esp', 
                $request->nombre_prod, 
                $request->input(key:'cantidad'),
                $price = 0,
                $weight = 0,
                $options = [
                    'status' => 'Pendiente',
                    'descripcion' => $request->descripcion,
                    'justificacion' => $request->justificacion,
                    'import' => $request->import,
                ]
            );
        }
        $request->session()->put('subareaDestino', $request->get('subareaDestino'));
        $request->session()->put('almacenpe', $request->get('almacen'));
        return redirect()->route('inventarios.create')->with('message', 'Su producto ha sido agregado');//->with(compact('almacenpe'));
    }
    public function update(Request $request){
        $request->validate([
            'cantidad' => 'required|numeric|min:1|max:2147483647', //int(11) en base de datos
        ]);
        $row = $request->input(key:'row');

        $row = json_decode($row, true);
        // $flat = $row->flatten(1);
        // $flat = $flat->values()->all();
        // dd($flat);
        // dd($row['0']['rowId']);
        // dd(gettype($row));
        
        $rowId = reset($row)['rowId'];
        Cart::update($rowId, $request->input(key:'cantidad'));
        return redirect()->route('inventarios.create')->with('message', 'Su producto ha sido actualizado');

        // dd($request->input(key:'carro'));
        // $producto = Producto::findOrFail($request->input(key:'producto_id'));
        // $id = Cart::where('id', $producto->id)->get('rowId');
        // Cart::update($id, $request->input(key:'cantidad'));
        // return redirect()->route('inventarios.create')->with('message', 'Su producto ha sido modificado');
    }

    public function destroy(Request $request){
        $row = $request->input(key:'row');
        $row = json_decode($row, true);
        $rowId = reset($row)['rowId'];
        Cart::remove($rowId);
        return redirect()->route('inventarios.create')->with('message', 'Su producto ha sido eliminado del carrito');
    }
}
