<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\permissions\Models\Role;
use App\organizacion;
use App\puesto_empleado;
use App\sucursal;
use App\User;
use App\interaccion;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ///
        $this->authorize('haveaccess','user.index'||'haveaccess','userown.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $filtro="";
        $busqueda="";
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $users = User::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else {
            $nomborg = User::select('organizacions.NombOrga')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('users.id', auth()->id())
                        ->first();
                        
            if ($nomborg->NombOrga == 'Sala Hnos'){
                $users = User::with('organizacions','sucursals')->orderBy('id','desc')->paginate(20);
            } else {
                $users = User::select('users.id','users.name','users.last_name', 'organizacions.NombOrga','sucursals.NombSucu',
                                    'users.TokenNotificacion','users.nacimiento')
                            ->join('organizacions','users.CodiOrga','=','organizacions.id')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where('organizacions.NombOrga', $nomborg->NombOrga)
                            ->orderBy('id','desc')
                            ->paginate(20);
            }
        }
        
        //return $users;
        return view('user.index', compact('users','filtro','busqueda'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize('create', User::class);
        //return "Create";
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', [$user, ['user.show', 'userown.show']]);
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $roles = Role::orderBy('name')->get();
        $organizacions = Organizacion::orderBy('NombOrga')->get();
        $puestoemps = Puesto_empleado::orderBy('NombPuEm')->get();
        $sucursals = Sucursal::orderBy('id')->get();
        //return $roles;
        $rutavolver = route('user.index');
        return view('user.view', compact('roles','user','organizacions','sucursals','puestoemps','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', [$user, ['user.edit', 'userown.edit']]);
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Usuarios']);
        $roles = Role::orderBy('name')->get();
        $organizacions = Organizacion::orderBy('NombOrga')->get();
        $puestoemps = Puesto_empleado::orderBy('NombPuEm')->get();
        $sucursals = Sucursal::orderBy('id')->get();
        //return $roles;
        $rutavolver = route('user.index');
        return view('user.edit', compact('roles','organizacions','puestoemps','sucursals','user','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'         => 'required|max:50|unique:users,email,'.$user->id,
            'TeleUser' => ['required', 'numeric'],
        ]);
        if (!empty($request->password))
        {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            //Change only password
            $user->update(['password' => Hash::make($request->password)]);
        }
        //dd($request->all());
        $alldata = $request->except('password'); // save all exceptthe password
        $user->update($alldata); // change all except password
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('user.index')->with('status_success', 'Usuario modificado con exito');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('haveaccess','user.destroy');
        $user->delete();
        return redirect()->route('user.index')->with('status_success', 'Usuario eliminado con exito');
  
    }
}
