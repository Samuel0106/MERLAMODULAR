<?php

namespace App\Http\Controllers;

use App\Models\codValidacion;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail; //Esta clase se encarga del envío del correo.
use Auth;
use DB;

class InventarioEmailController extends Controller
{
    public function codigoVerificacion() {

        $subject = "CFE - Su pedido ha sido autorizado";
        $for = $_GET['email'];
        $id = $_GET['folio'];
        $data = [
            'for'=>$for,
            'folio'=>$id
        ];
        Mail::send('emails.codigoInventario', $data, function($msj) use($subject, $for) {
            $msj->from("innovacioncfedx@gmail.com", "CFE-DCJ");
            $msj->subject($subject);
            $msj->to($for);
        });
        $codigo = codValidacion::where('correo',null)->orderBy('id','DESC')->firstOrFail();
        $codigo['correo'] = $for;
        $codigo['folio'] = $id;
        $codigo->save();
        return redirect()->route('inventarios.entregar')->with('message', 'El pedido fue Autorizado');
    }

    public function verificarCodigo(){
        $codigo = $_GET['codigo'];
        $folio = $_GET['folio'];
        $allCode = codValidacion::where('folio',$folio)->firstOrFail();
        if($codigo==$allCode->codigo){
            return redirect()->back()->with('success','El codigo es correcto');
        }
        else{
            return redirect()->back()->with('error','El codigo es incorrecto, vuelva a intentarlo');
        }
    }
    public function addFoto(Request $request){
        $codigo = codValidacion::where('folio',$request->folio)->firstOrFail();
        $imagen = $request->file('foto');
        $rutaGuardarImg = public_path() . '/entregas/';
        $imagenEntrega = date('YmdHis')."_"."entrega"."$request->folio".".". $imagen->getClientOriginalExtension();
        $imagen->move($rutaGuardarImg, $imagenEntrega);
        $codigo['foto'] = $imagenEntrega;
        $codigo->save();
        return redirect()->route('inventarios.changeInventarioStatus', ['inventario' => $codigo->folio, 'status' => 'Entregado'])->with('message', 'El pedido fue Entregado');
    }
}
