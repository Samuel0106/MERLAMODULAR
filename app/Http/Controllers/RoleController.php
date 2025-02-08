<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionServiceProvider;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.edit')->only('edit', 'update');
        $this->middleware('can:roles.create')->only('create', 'store');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return view('roles.crear', compact('permissions'));
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
            'nombre' => ['required', 'unique:roles,name']
        ]);
        $rules = $this->validate($request, array('permisos' => 'required'));
        $validator = Validator::make($request->permisos, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $role = Role::create(['name' => $request->nombre, 'guard_name' => 'web']);
        $role->permissions()->sync($request->permisos);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.index')->with('info', 'El rol se creo con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($role)
    {
        $role = Role::FindOrFail($role);
        $permissions = Permission::all();
        return view('roles.editar', compact('role', 'permissions'));
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

        $role = Role::FindOrFail($id);
        $request->validate([
            'nombre' => ['required', 'unique:roles,name,' . $role->id],
        ]);
        $rules = $this->validate($request, array('permisos' => 'required'));
        $validator = Validator::make($request->permisos, $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $role->update($request->all());
        $role->permissions()->sync($request->permisos);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::FindorFail($id);
        
        for($i = 0; $i <count($role->users); $i++ )
        {
            $user = User::FindorFail($role->users[$i]['id']);
            $user->roles()->detach();
            $user->assignRole('Generico');
        }
        $role->delete();
        return redirect()->route('roles.index');
    }

}
