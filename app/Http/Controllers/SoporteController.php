<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Datosuser;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Facade\FlareClient\View;
use App\Http\Controllers\Controller;

class SoporteController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:soportes.create')->only('create');
        $this->middleware('can:soportes.store')->only('store');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dudas = Soporte::all();
        return view('soportes.index', compact('dudas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $datos = Datosuser::where('eid',Auth::user()->eid)->firstOrFail();
        $soporte = DB::table('soportes')->get();
         
        return view('soportes.crear',['datos'=>$datos,'soporte'=>$soporte]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'fecha' => 'required',
            'eid' => 'required', 
            'titulo' => 'required', 
            'descripcion' => 'required'
        ]);
        $fecha = $request->input('fecha');
        $eid = Auth::user()->eid;
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $sop = $request->all();
        
        //dd($sop);
        Soporte::create($sop);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }

    

}

