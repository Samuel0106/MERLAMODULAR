<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\Division;
use DB;
use App\Models\Datosuser;
use App\Models\Subarea;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Contratos;
use App\Models\Evidencia;
use Database\Seeders\AreaSeeder;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index', 'inicio');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.destroy')->only('destroy');
        $this->middleware('can:users.datosPersonales')->only('datosPersonales');
        $this->middleware('can:users.baja')->only('usuariosBaja');
    }

    public function index()
    {
        $divisiones = Division::all();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $datos = Datosuser::query()
            ->where('subarea', Auth::user()->datos->getSubarea->subarea_clave)
            ->get();
        $datos = $datos->keyBy('eid');
        
        $datos_eid = Datosuser::query()
            ->where('subarea', Auth::user()->datos->getSubarea->subarea_clave)
            ->pluck('eid');
            
        $users = User::query()
            ->whereIn('eid', $datos_eid)
            ->get()->map(function ($user) {
                $user->roles_J = $user->roles;
                return $user;
            });

        $roles = Role::all();

        return view('users.index', compact('users', 'roles', 'datos', 'divisiones', 'areas', 'subareas'));
    }
    public function updateTable(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $sec = $request->seccion;
        $rol = $request->rol;

        $documentos = Datosuser::query()
            ->with(['divisiones', 'areas', 'secciones', 'roles'])
            ->where('division', $div)
            ->get();
        return response()->json(
            [
                'success' => true,
                'lista' => $documentos,
            ]
        );
    }
    public function updateTableIndex(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $rol = $request->rol;
        $sec = $request->seccion;

        //info($div . '-' . $area . '-' . $subarea . '-' . $sec . '-' . $doc . '-' . $year . '-' . $month);
        $usuarios = Datosuser::query()
            ->with(['divisiones', 'areas', 'subareas', 'secciones'])
            ->where('division', $div)
            ->where('area', $area)
            ->when($rol != '0', function ($query) use ($rol) {
                return $query->where('subarea', $rol);
            })
            ->when($sec != '0', function ($query) use ($sec) {
                return $query->where('seccion', $sec);
            })->get();
        ////info($evidencias);
        return response()->json(
            [
                'success' => true,
                'lista' => $div,
            ]
        );
    }

    public function index_Specification()
    {
        $datos = Datosuser::all();
        $datos = $datos->keyBy('eid');
        $divisiones = DB::table('divisiones')->get();
        $areas = DB::table('areas')->where('area_clave', 'lIKE', 'DX' . '%')->get();
        $secciones = DB::table('secciones')->get();

        $users = User::all();

        $roles = Role::all();
        return view('users.index', compact('users', 'roles', 'datos', 'divisiones', 'areas', 'secciones'));
    }

    public function datosPersonales()
    {
        $datos = Datosuser::where('eid', Auth::user()->eid)->firstOrFail();
        $correo = DB::table('users')->select('email')->where('eid', Auth::user()->eid)->first();
        $division = DB::table('divisiones')->select('division_nombre')->where('division_clave', str_split($datos->area, 2)[0])->first();
        $contrato = $datos['contrato'] ? Contratos::where('id', $datos['contrato'])->first()['tipo_de_contrato'] : 'Sin contrato';
        $area = $datos['area'] ? Area::where('area_clave', $datos->area)->first()['area_nombre'] : 'Sin area';
        $subarea = $datos['subarea'] ? Subarea::where('subarea_clave', $datos->subarea)->first()['subarea_nombre'] : 'Sin subarea';

        return view('users.datos-personales', compact('datos', 'correo', 'division', 'contrato', 'area', 'subarea'));
    }

    public function usuariosBaja()
    {
        $users = Datosuser::where('contrato', '3')->orWhere('contrato', '4')->get();
        $areas = Area::all();
        $subareas = Subarea::all();
        return view('users.usuariosBaja', compact('users', 'areas', 'subareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisiones = DB::table('divisiones')->get();
        $areas = Auth::user()->datos->getDivision->areas;
        $subareas =  Auth::user()->datos->getArea->subareas;
        $roles = Role::all();


        return view('users.crear', compact('areas', 'subareas', 'divisiones' ,'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!isset($request->password)){
            $request->request->add( ['password' => bcrypt('password')]);
        }
        else{
            $request->request->add( ['password' => bcrypt($request->password)]);
        }
        $request->validate([
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'ingreso' => 'required',
            'contrato' => 'required',
            'area' => 'required',
            'subarea' => 'required',
            'division' => 'required',
            'roles' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            // 'password' => 'required|confirmed|min:8',
        ]);

        $user = new User($request->safe()->only(['eid', 'email', 'password']));     

        $user->assignRole($request->roles);

        $user->save();

        $datos = new Datosuser($request->safe()->except(['eid', 'email', 'password', 'ingreso']));
        $datos->antiguedad =  $request->ingreso;
        $user->datos()->save($datos);
        // $pass = $request->input('password');
        // $user['password'] = bcrypt($pass);
        return redirect()->route('users.index');
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

    public function centros(){
        $divisiones = DB::table('divisiones')->get();
        $areas = DB::table('areas')->where('division_id',$divisiones[0]->division_clave)->get();
        $subareas = DB::table('subareas')->where('area_id',$areas[0]->area_clave)->get();
        return view('users.centros',compact('divisiones','areas','subareas'));
    }

    public function areas(Request $request){
        $areas = DB::table('areas')->where('division_id',$request->division)->get();
        return response()->json(
            [
                'success' => true,
                'lareas' => $areas,
            ]
        );
    }
    public function subareas(Request $request){
        $subareas = DB::table('subareas')->where('area_id',$request->area)->get();
        return response()->json(
            [
                'success' => true,
                'lsubarea' => $subareas,
            ]
        );
    }

    public function filterUsers(Request $request)
    {
        $div = $request->division;
        $area = $request->area;
        $subarea = $request->subarea;
        $rol = $request->rol;

        $datos = Datosuser::query()
            ->where('division', $div)
            ->when($area != 0, function($query) use($area){
                return $query->where('area', $area);
            })
            ->when($subarea != 0, function ($query) use ($subarea) {
                return $query->where('subarea', $subarea);
            })
            ->get();
        $datos = $datos->keyBy('eid');

        $datos_eid = Datosuser::query()
            ->where('division', $div)
            ->when($area != 0, function($query) use($area){
                return $query->where('area', $area);
            })
            ->when($subarea != 0, function ($query) use ($subarea) {
                return $query->where('subarea', $subarea);
            })
            ->pluck('eid');
        $users = User::query()
            ->whereIn('eid', $datos_eid)
            ->when($rol != 0, function ($query) use ($rol) {
                return $query->whereHas('roles', function ($query) use ($rol) {
                    $query->where('name', $rol);
                });
            })
            ->get()
            ->map(function ($user) {
                $user->role_J = $user->getRoleNames()->first();
                return $user;
            });
        $roles = Role::all();
        //info($users[0]);
        return response()->json(
            [
                'success' => true,
                'users' => $users, 
                'datos' => $datos,
                'roles' => $roles,
            ]
        );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) 
    {   
        $user = User::FindorFail($id);
        $datos = Datosuser::where('eid', $user->eid)->firstOrFail();
        $area_id = Subarea::find($datos->subarea)->area_id;
        $subareas = DB::table('subareas')->where('area_id', 'lIKE', $area_id . '%')->get();
        $division_id = Area::find($area_id)->division_id;
        $areas = DB::table('areas')->where('division_id', 'lIKE', $division_id . '%')->get();
        $divisiones = DB::table('divisiones')->get();
        $roles = Role::all();
        return view('users.editar', compact('user', 'divisiones', 'areas', 'subareas', 'area_id', 'division_id', 'datos' ,'roles'));
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
        $user = User::FindOrFail($id);
        $user->syncRoles($request->roles);
        $datos = Datosuser::where('eid', $user->eid)->firstOrFail();
        $user->fill($request->all());
        $user->save();
        $datos->fill($request->all());
        $datos->save();
            return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return redirect()->route('users.index');
    }

    function permisosRol()
    {
 

        $roleJSub = [['name', '!=', 'SuperRoot'], ['name', '!=', 'JefeDivision'], ['name', '!=', 'RecursosHumanos'], ['name', '!=', 'JefeSindicato'], ['name', '!=', 'JefeArea'], ['name', '!=', 'JefeSubarea']];
        $roleJArea = [['name', '!=', 'SuperRoot'], ['name', '!=', 'JefeDivision'], ['name', '!=', 'RecursosHumanos'], ['name', '!=', 'JefeSindicato'], ['name', '!=', 'JefeArea']];
        $roleJSindicato = [['name', '!=', 'SuperRoot'], ['name', '!=', 'JefeDivision'], ['name', '!=', 'RecursosHumanos'], ['name', '!=', 'JefeSindicato']];
        $roleRH = [['name', '!=', 'SuperRoot'], ['name', '!=', 'JefeDivision'], ['name', '!=', 'RecursosHumanos']];
        $roleJDivision = [['name', '!=', 'JefeDivision'], ['name', '!=', 'SuperRoot']];
        $roleSuper = [['name', '!=', 'SuperRoot']];
        $roleDoctora = [['name', '!=', 'SuperRoot'], ['name', '!=', 'Doctora']];

        $currentRole = Auth::user()->getRoleNames()->first();
        switch ($currentRole) {
            case 'Doctora':
                return $roleDoctora;
            case 'SuperRoot':
                return $roleSuper;
            case 'JefeDivision':
                return $roleJDivision;
            case 'RecursosHumanos':
                return $roleRH;
            case 'JefeSindicato':
                return $roleJSindicato;
            case 'JefeArea':
                return $roleJArea;
            case 'JefeSubarea':
                return $roleJSub;
        }
    }

    public function bajar(Request $request)
    {
        $user = User::FindOrFail($request['id']);
        $user->delete();
        return redirect()->route('users.index');
    }

    public function inicio()
    {
        $vc = DB::table('view_counter')->where('pagina', 'usuarios')->first()->visitas + 1;
        DB::table('view_counter')->where('pagina', 'usuarios')->update(['visitas'=>$vc]);
        return view('users.inicio');
    }
}
