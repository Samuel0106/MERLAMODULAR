<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use DataTables;
use App\Models\area;
use App\Models\User;
use App\Models\Datosuser;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DatosuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperRoot') || Auth::user()->hasRole('Doctora'))
        {
            $datosuser = Datosuser::all();
            return view('datos.index', compact('datosuser'));
        }
        else
        {
            return abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperRoot'))
        {
            $divisiones = DB::table('divisiones')->get();
            $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DN' . '%')->get();
            $subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', 'DN00' . '%')->get();
            /**$datosuser = DB::table('datosusers')->get();*/
            return view('datos.crear',['areas' => $areas, 'subareas' => $subareas, 'divisiones' => $divisiones]);
        }
        else
        {
            return abort(403);
        }
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
            'eid' => 'max:5|unique:App\Models\Datosuser',
            'email' => 'required|unique:App\Models\User',
            'nombre' => 'required|max:191',
            'paterno' => 'required|max:191',
            'materno' => 'required|max:191',
            'ingreso' => 'required|date|before:tomorrow',
            'area' => 'required',
            'subarea' => 'required',
        ]);
        
        $area = $request->input('area');
        $subarea = $request->input('subarea');
        $du = $request->all();
        Datosuser::create($du);
        return redirect()->route('datos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Datosuser  $datos
     * @return \Illuminate\Http\Response
     */
    public function show(Datosuser $datos)
    {
        return view('datos.editar', compact('datos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Datosusers  $datos
     * @return \Illuminate\Http\Response
     */
    public function edit($datos)
    {
        /**$datosuser = DB::table('datosusers')->get();*/
        if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('SuperRoot'))
        {
            $datos = Datosuser::where('id',$datos)->firstOrFail();
            $datosuser = DB::table('datosusers')->get(); 

            $divisiones = DB::table('divisiones')->get();
            $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DN' . '%')->get();
            $subareas = DB::table('subareas')->where('subarea_clave', 'lIKE', 'DN00' . '%')->get();

            return view('datos.editar', ['areas' => $areas, 'subareas' => $subareas, 'divisiones' => $divisiones], compact('datos'));
        }
        else
        {
            return abort(403);   
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Datosuser  $datosuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'eid' => 'required|max:5|unique:App\Models\Datosuser,eid,'.$id,
            'nombre' => 'required|max:191',
            'paterno' => 'required|max:191',
            'materno' => 'required|max:191',
            'ingreso' => 'required|date|before:tomorrow',
        ]);
        /*$user = User::FindOrFail($id);
        $user-> = $request->;
        $user->save();
        $datos = Datosuser::FindOrFail($id);
        $datos->fill($request->all());
        $datos->save();*/
        
        $datos = DatosUser::FindOrFail($id);
        $usereid = DB::table('users')->where('eid', $datos->eid)->first();
        $user = User::FindOrFail($usereid->id);
        $user->eid = $request->eid;
        $user->save();
        $datos->fill($request->all());
        $datos->save();

        if(isset($request->origen)){
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
        else{
            return redirect()->route('datos.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Datosuser  $datosuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datosuser $datos)
    {
        $datos->forceDelete();
        return redirect()->route('datos.index');
    }

    public function bajar(Request $request, Datosuser $datos)
    {    
        $datos = Datosuser::FindOrFail($request['id']);
        $datos->delete();
        return redirect()->route('datos.index');
    }

    public function buscarUsuario($usuario)
    {
        // Se utiliza el método where para buscar un registro en la tabla 'datosusers' con el eid igual a $usuario.
        $usuari = DB::table('datosusers')->where('eid', $usuario)->first();

        // Si se encontró un registro, se devuelve como resultado. Si no se encontró, se devuelve null utilizando el operador de fusión de null.
        return $usuari ?? null;
    }
}
