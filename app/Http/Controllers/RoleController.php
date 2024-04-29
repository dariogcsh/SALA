<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interaccion;
use App\permissions\Models\Role;
use App\permissions\Models\Permission;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','role.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $rutavolver = route('internoconfiguracion');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $roles = Role::Buscar($tipo, $busqueda)->orderBy('id','desc')->paginate(10)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $roles = Role::orderBy('id','desc')->paginate(10);
        }
        return view('role.index', compact('roles','filtro','busqueda','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        Gate::authorize('haveaccess','role.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $permissions = Permission::get();
        $rutavolver = route('role.index');
        return view('role.create', compact('permissions','rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Gate::authorize('haveaccess','role.create');
        $request->validate([
            'name'          => 'required|max:50|unique:roles,name',
            'slug'          => 'required|max:50|unique:roles,slug',
            'full-access'   => 'required|in:yes,no'
        ]);

        $role = Role::create($request->all());

        //if($request->get('permission')){
            //return $request->all();
            $role->permissions()->sync($request->get('permission'));
        //} 

        return redirect()->route('role.index')->with('status_success', 'Rol guardado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        Gate::authorize('haveaccess','role.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $permission_role = [];
        foreach($role->permissions as $permission){
            $permission_role[] = $permission->id;
        }
        $permissionsver = Permission::where('slug','LIKE','%index%')
                                    ->orWhere('slug','LIKE','%informe%')
                                    ->orWhere('slug','LIKE','%detalle%')
                                    ->orWhere('slug','LIKE','%menu%')->get();
        $permissionscrear = Permission::where('slug','LIKE','%create%')->get();
        $permissionseditar = Permission::where('slug','LIKE','%edit%')->get();
        $permissionsdetalle = Permission::where('slug','LIKE','%show%')->get();
        $permissionseliminar = Permission::where('slug','LIKE','%destroy%')->get();
        $permissionsreparacion = Permission::where('slug','LIKE','%reparacion%')->get();
        $rutavolver = route('role.index');
        return view('role.view', compact('permissionsver','permissionscrear','permissionseditar','permissionsdetalle',
                                        'permissionseliminar','permissionsreparacion','role','permission_role','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        Gate::authorize('haveaccess','role.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $permission_role = [];
        foreach($role->permissions as $permission){
            $permission_role[] = $permission->id;
        }
        $permissionsver = Permission::where('slug','LIKE','%index%')
                                    ->orWhere('slug','LIKE','%informe%')
                                    ->orWhere('slug','LIKE','%gestion%')
                                    ->orWhere('slug','LIKE','%detalle%')->get();
        $permissionscrear = Permission::where('slug','LIKE','%create%')->get();
        $permissionseditar = Permission::where('slug','LIKE','%edit%')
                                    ->orWhere('slug','LIKE','%vendido%')->get();
        $permissionsdetalle = Permission::where('slug','LIKE','%show%')->get();
        $permissionseliminar = Permission::where('slug','LIKE','%destroy%')->get();
        $rutavolver = route('role.index');
        return view('role.edit', compact('permissionsver','permissionscrear','permissionseditar','permissionsdetalle',
                                        'permissionseliminar','role','permission_role','rutavolver'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        Gate::authorize('haveaccess','role.edit');
        $request->validate([
            'name'          => 'required|max:50|unique:roles,name,'.$role->id,
            'slug'          => 'required|max:50|unique:roles,slug,'.$role->id,
            'full-access'   => 'required|in:yes,no'
        ]);

        $role->update($request->all());

        //if($request->get('permission')){
            //return $request->all();
            $role->permissions()->sync($request->get('permission'));
        //} 

        return redirect()->route('role.index')->with('status_success', 'Rol modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        Gate::authorize('haveaccess','role.destroy');
        $role->delete();
        return redirect()->route('role.index')->with('status_success', 'Rol eliminado con exito');
  
    }
}
