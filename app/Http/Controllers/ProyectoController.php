<?php

namespace App\Http\Controllers;

use App\proyecto;
use App\ticket;
use App\ideaproyecto;
use App\users_proyecto;
use App\interaccion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function gestion(Request $request)
    {
       //
       Gate::authorize('haveaccess','proyecto.index');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
       $rutavolver = route('proyecto.index');

       $fecha_hoy = Carbon::today();
        $dbdate = '2021-01-01';
        $añoinicial = Carbon::createFromFormat('Y-m-d', $dbdate);
        $año_inicial = $añoinicial->format('Y');
        $hoy = $fecha_hoy->format('Y-m-d');
        $año = $fecha_hoy->format('Y');

        if (($fecha_hoy > $año."-10-31") AND ($fecha_hoy <= $año."-12-31")){
            $año = $año + 1;
            $año_pasado = $año;
        }else{
            $año = $año;
            $año_pasado = $año - 1;
        }

        $diff = $añoinicial->diffInYears($año);

        //Cantidades
       $cant_terminados = Proyecto::where('estado','100')->count();
       $cant_progreso = Proyecto::where([['estado','>','0'], ['estado','<','100']])->count();
       $cant_noiniciados = Proyecto::where('estado','0')->count();
        
        //Horas
        $hs_terminados = Proyecto::where('estado','100')->sum('horas');
        $hs_progreso = Proyecto::where([['estado','>','0'], ['estado','<','100']])->sum('horas');
        $hs_noiniciados = Proyecto::where('estado','0')->sum('horas');
        
        //Costo
        $costo_terminados = Proyecto::where('estado','100')->sum('presupuesto');
        $costo_progreso = Proyecto::where('estado','>','0')->sum('presupuesto');
        $costo_noiniciados = Proyecto::where('estado','0')->sum('presupuesto');
   
        for ($i=0; $i <= $diff ; $i++) {
            $FY[$i] = $año_inicial + $i;
            $FY_pasado[$i] = $FY[$i] - 1;

            $cant_FY[$i] = Proyecto::where([['inicio','>',$FY_pasado[$i].'-10-31 23:59:59'], ['inicio','<',$FY[$i].'-11-01']])->count();
            $hs_FY[$i] = Proyecto::where([['inicio','>',$FY_pasado[$i].'-10-31 23:59:59'], ['inicio','<',$FY[$i].'-11-01']])->sum('horas');
            $costo_FY[$i] = Proyecto::where([['inicio','>',$FY_pasado[$i].'-10-31 23:59:59'], ['inicio','<',$FY[$i].'-11-01']])->sum('presupuesto');
        }

       return view('proyecto.gestion', compact('rutavolver','cant_terminados', 'cant_progreso', 'cant_noiniciados',
                                            'cant_FY', 'hs_FY', 'costo_FY', 'hs_terminados', 'hs_progreso','hs_noiniciados',
                                            'costo_terminados', 'costo_progreso', 'costo_noiniciados', 'FY','diff'));
    }


   public function index(Request $request)
   {
       //
       Gate::authorize('haveaccess','proyecto.index');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
       $rutavolver = route('internoconfiguracion');
       $vista="";
       $vista= $request->get('soluciones');
       $variablesurl=$request->all();
                   if($vista == "Soluciones Integrales"){
                       $proyectos = Proyecto::select('proyectos.id','proyectos.descripcion','proyectos.created_at',
                                                       'proyectos.inicio','proyectos.finalizacion','proyectos.horas',
                                                       'proyectos.presupuesto','proyectos.estado','proyectos.categoria',
                                                       'titulo')
                                            ->where('proyectos.categoria','Soluciones Integrales')
                                            ->groupBy('proyectos.id')
                                            ->orderBy('proyectos.id','desc')->paginate(20);
                   } elseif(($vista == "SALA App/API") OR ($vista == "")){ 
                       $proyectos = Proyecto::select('proyectos.id','proyectos.descripcion','proyectos.created_at',
                                                       'proyectos.inicio','proyectos.finalizacion','proyectos.horas',
                                                       'proyectos.presupuesto','proyectos.estado','proyectos.categoria',
                                                       'titulo')
                                            ->where('proyectos.categoria','SALA App/API')
                                            ->groupBy('proyectos.id')
                                            ->orderBy('proyectos.id','desc')->paginate(20);
                       $vista = "SALA App/API";
                   }
       return view('proyecto.index', compact('proyectos','rutavolver','vista'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       Gate::authorize('haveaccess','proyecto.create');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
       $rutavolver = route('proyecto.index');
       $usuarios = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->where('organizacions.NombOrga','Sala Hnos')
                        ->orderBy('users.name','asc')->get();
       return view('proyecto.create',compact('rutavolver','usuarios'));
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
            'categoria' => 'required|max:255',
            'titulo' => 'required',
            'descripcion' => 'required|max:10000',
            'inicio' => 'required',
            'finalizacion' => 'required',
       ]);
 
       //Registro el proyecto
        $proyecto = proyecto::create($request->all());

       //Registro los responsables asignados al proyecto
        if (isset($request->id_responsable)) {
            $responsables = $request->id_responsable;
        }
        if (isset($responsables)) {
            foreach ($responsables as $responsable) {
               $user_proyecto = Users_proyecto::create(['id_user' => $responsable, 'id_proyecto' => $proyecto->id]);
            }
        }
        
        //Si el proyecto proviene de una propuesta, cambia el estado.
        if (isset($request->id_propuesta)) {
            $propuesta = Ideaproyecto::where('id',$request->id_propuesta)->first();
            $propuesta->update(['estado' => 'Transferido a proyectos', 'id_proyecto' => $proyecto->id]);
        }

       return redirect()->route('home')->with('status_success', 'Proyecto creado con exito');
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\proyecto  $proyecto
    * @return \Illuminate\Http\Response
    */
   public function show(proyecto $proyecto)
   {
       Gate::authorize('haveaccess','proyecto.show');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
       $rutavolver = route('proyecto.index');
       $responsables = Users_proyecto::select('users.id','users.name','users.last_name')
                                    ->join('users','users_proyectos.id_user','=','users.id')
                                    ->where('users_proyectos.id_proyecto',$proyecto->id)->get();
        $tiempo = Ticket::join('detalle_tickets','tickets.id','=','detalle_tickets.id_ticket')
                                    ->where('tickets.id_proyecto', $proyecto->id)
                                    ->orderBy('detalle_tickets.fecha_fin','DESC')
                                    ->sum('detalle_tickets.tiempo');
        $tiempo_horas = $tiempo / 60;
                if(isset($proyecto->horas) AND ($tiempo_horas > 0)){
                    $avance = $tiempo_horas / $proyecto->horas * 100;
                }else{
                    $avance = $proyecto->estado;
                }
       return view('proyecto.view', compact('proyecto','rutavolver','responsables','avance'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\proyecto  $proyecto
    * @return \Illuminate\Http\Response
    */
   public function edit(proyecto $proyecto)
   {
       Gate::authorize('haveaccess','proyecto.edit');
       Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Proyectos']);
       $rutavolver = route('proyecto.index');
       $responsables = Users_proyecto::select('users_proyectos.id_user')
                                    ->where('users_proyectos.id_proyecto',$proyecto->id)->get();

       $usuarios = User::select('users.id','users.name','users.last_name')
                                    ->join('organizacions','users.CodiOrga','=','organizacions.id')
                                    ->where('organizacions.NombOrga','Sala Hnos')
                                    ->orderBy('users.name','asc')->get();

       return view('proyecto.edit', compact('proyecto','rutavolver','responsables','usuarios'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\proyecto  $proyecto
    * @return \Illuminate\Http\Response
    */

   public function update(Request $request, proyecto $proyecto)
   {
       Gate::authorize('haveaccess','proyecto.edit');
       $request->validate([
        'titulo'          => 'required',
           'descripcion'          => 'required',
       ]);

       $sql_proyecto = Users_proyecto::where('id_proyecto',$proyecto->id)->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($sql_proyecto as $proy){
            $plan[$i] = $proy->id_user;
            $i++;
        }

       $responsable = $request->id_responsable;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($responsable)) {
            foreach ($sql_proyecto as $planserv){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($planserv->id_user, $responsable)) {
                    $planserv->delete();
                }
            }
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($responsable as $usuario){
                if (!isset($plan)) {
                    $planes = Users_proyecto::create(['id_user' => $usuario, 'id_proyecto' => $proyecto->id]);
                }else{
                    if (!in_array($usuario, $plan)) {
                    $planes = Users_proyecto::create(['id_user' => $usuario, 'id_proyecto' => $proyecto->id]);
                    }
                }
            }
        } elseif(isset($sql_proyecto)) {
            foreach ($sql_proyecto as $planserv){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                $planserv->delete();
            }
        }

       $proyecto->update($request->all());
       return redirect()->route('proyecto.index')->with('status_success', 'Propuestao modificada con exito');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\proyecto  $proyecto
    * @return \Illuminate\Http\Response
    */
   public function destroy(proyecto $proyecto)
   {
       Gate::authorize('haveaccess','proyecto.destroy');
       $proyecto->delete();
       return redirect()->route('proyecto.index')->with('status_success', 'Propuesta eliminada con exito');
   }
}