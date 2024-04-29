<?php

namespace App\Http\Controllers;

use App\permissions\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\interaccion;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        Gate::authorize('haveaccess','permission.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $rutavolver = route('internoconfiguracion');
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $permissions = Permission::Buscar($tipo, $busqueda)->orderBy('id','desc')->paginate(10)->appends($variablesurl);
            $filtro = "SI";
        } else{
            $permissions = Permission::orderBy('id','desc')->paginate(10);
        }
        return view('permission.index', compact('permissions','filtro','busqueda','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','permission.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $rutavolver = route('permission.index');
        return view('permission.create',compact('rutavolver'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|unique:permissions,slug',
            'slug' => 'required|max:50|unique:permissions,slug',
            'description' => 'required'
        ]);
        $permissions = Permission::create($request->all());
        return redirect()->route('permission.index')->with('status_success', 'Permiso creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
        Gate::authorize('haveaccess','permission.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $rutavolver = route('permission.index');
        return view('permission.view', compact('permission','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        Gate::authorize('haveaccess','permission.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Permisos']);
        $rutavolver = route('permission.index');
        return view('permission.edit', compact('permission','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        request()->validate([
            'name' => 'required',
            'slug' => 'required|max:50',
            'description' => 'required'
        ]);
        Gate::authorize('haveaccess','permission.edit');

        $permission->update($request->all());
        return redirect()->route('permission.index')->with('status_success', 'Permiso modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\antena  $antena
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        Gate::authorize('haveaccess','permission.destroy');
        $permission->delete();
        return redirect()->route('permission.index')->with('status_success', 'Permiso eliminado con exito');
    }
}