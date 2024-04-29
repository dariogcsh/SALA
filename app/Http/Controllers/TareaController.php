<?php

namespace App\Http\Controllers;

use App\tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\organizacion;
use App\puesto_empleado;
use App\sucursal;
use App\maquina;
use App\User;
use App\interaccion;
use App\planservicio;
use Carbon\Carbon;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','tarea.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $rutavolver = route('internoservicios');
        $select = ['tareas.id','tareas.ncor','tareas.ubicacion','tareas.descripcion','tareas.nseriemaq','tareas.estado',
                'organizacions.NombOrga','tareas.turno','tareas.prioridad'];
        $sucursales = Sucursal::orderBy('id','asc')->get();
        
        if ($request->sucursal == "Todas las sucursales") {
            $sucursal = "";
        }elseif($request->sucursal){
            $sucursal = $request->get('sucursal');
        } else {
            $sucursal = User::select('sucursals.NombSucu')
                                ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                ->where('users.id',auth()->user()->id)->first();
            $sucursal = $sucursal->NombSucu;
        }

        $preostractor = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','A presupuestar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

        $preoscosechadora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','A presupuestar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $preospulverizadora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','A presupuestar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $preossembradora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','A presupuestar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $presupuestadotractor = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','Servicio presupuestado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $presupuestadocosechadora = Tarea::select($select)
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                        ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','Servicio presupuestado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                        ->orderBy('id','desc')->get();

        $presupuestadopulverizadora = Tarea::select($select)
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                            ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','Servicio presupuestado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                            ->orderBy('id','desc')->get();

        $presupuestadosembradora = Tarea::select($select)
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                        ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','Servicio presupuestado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                        ->orderBy('id','desc')->get();

        $repuestostractor = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','Esperando repuestos'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $repuestoscosechadora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','Esperando repuestos'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $repuestospulverizadora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','Esperando repuestos'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

        $repuestossembradora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','Esperando repuestos'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

    $pendientetractor = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','Pendiente programación'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $pendientecosechadora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','Pendiente programación'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $pendientepulverizadora = Tarea::select($select)
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                    ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','Pendiente programación'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                    ->orderBy('id','desc')->get();

    $pendientesembradora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','Pendiente programación'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();
/*
    $programadotractor = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','Programado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $programadocosechadora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','Programado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $programadopulverizadora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','Programado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $programadosembradora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','Programado'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

*/
    $pendientefacttractor = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','TRACTOR'], ['tareas.estado','Pendiente de facturar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $pendientefactcosechadora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','COSECHADORA'], ['tareas.estado','Pendiente de facturar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $pendientefactpulverizadora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['tareas.estado','Pendiente de facturar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

    $pendientefactsembradora = Tarea::select($select)
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.estado','Pendiente de facturar'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('id','desc')->get();

        return view('tarea.index', compact('rutavolver','preostractor','preoscosechadora','preospulverizadora'
                                            ,'preossembradora','presupuestadotractor','presupuestadocosechadora'
                                            ,'presupuestadopulverizadora','presupuestadosembradora'
                                            ,'repuestostractor','repuestoscosechadora','repuestospulverizadora'
                                            ,'repuestossembradora','pendientetractor','pendientecosechadora'
                                            ,'pendientepulverizadora','pendientesembradora','pendientefacttractor','pendientefactcosechadora'
                                            ,'pendientefactpulverizadora','pendientefactsembradora','sucursales','sucursal'));
    }

    public function itecnicos(Request $request)
    {
        Gate::authorize('haveaccess','tarea.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $rutavolver = route('internoservicios');
        
        $sucursales = Sucursal::orderBy('id','asc')->get();

        //Evaluo el estado a filtrar
        if ($request->estado == "Todos") {
            $estado = "";
        } else{
            $estado = $request->estado;
        }

        //Evaluo la semana seleccionada para cambiar los dias
        if ($request->semana == "Semana actual") {
            $ultimodomingo = new Carbon('last sunday');
            $domingo = $ultimodomingo;
            $semini = $domingo->addDay()->format('Y-m-d');
            $semfin = $domingo->addDay(6)->format('Y-m-d');
            $semana = $semini."/".$semfin;
            $ultimodomingo = new Carbon('last sunday');
        }elseif($request->semana){
            $semana = $request->get('semana');
            $value = explode("/", $semana);
            $ultimolunes = Carbon::createFromFormat('Y-m-d', $value[0]);
            $domingo = $ultimolunes->subDay()->format('Y-m-d');
            $ultimodomingo = Carbon::createFromFormat('Y-m-d', $domingo);
        } else {
            $ultimodomingo = new Carbon('last sunday');
            $domingo = $ultimodomingo;
            $semini = $domingo->addDay()->format('Y-m-d');
            $semfin = $domingo->addDay(6)->format('Y-m-d');
            $semana = $semini."/".$semfin;
            $ultimodomingo = new Carbon('last sunday');
        }
        
        //Fechas 6 dias próximos
        for ($i=0; $i < 7 ; $i++) { 
            $hoy[$i] = $ultimodomingo->addDay()->format('Y-m-d');
        }

        //Rango de fecha de semana actual
        $datei = new Carbon('last monday');
        $datef = new Carbon('next sunday'); 
        $inicio[0] = $datei->format('Y-m-d');
        $fin[0] = $datef->format('Y-m-d');
        $semanas[0] = $inicio[0]."/".$fin[0]; 

        for ($i=1; $i < 9; $i++) { 
            $inicio[$i] = $datei->subWeek()->format('Y-m-d');
            $fin[$i] = $datef->subWeek()->format('Y-m-d');
            $semanas[$i] = $inicio[$i]."/".$fin[$i];
        }

        $puesto = Puesto_empleado::where('id',auth()->user()->CodiPuEm)->first();

        if ($puesto->NombPuEm == "Tecnico") {
            //Consulto un técnico (el logueado)
            $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->where('id',auth()->user()->id)->get();
            $sucursal = User::select('sucursals.NombSucu')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where('users.id',auth()->user()->id)->first();
            $sucursal = $sucursal->NombSucu;
        } else {
            if ($request->sucursal == "Todas las sucursales") {
                $sucursal = "";
            }elseif($request->sucursal){
                $sucursal = $request->get('sucursal');
            } else {
                $sucursal = User::select('sucursals.NombSucu')
                                    ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                    ->where('users.id',auth()->user()->id)->first();
                $sucursal = $sucursal->NombSucu;
            }

             //Consulto todos los técnicos
             $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where([['puesto_empleados.NombPuEm','Tecnico'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])->get();
        }
        
        $i = 0;

        $select = ['tareas.id','tareas.ncor','tareas.ubicacion','tareas.descripcion',
                    'tareas.nseriemaq','tareas.estado','tareas.prioridad','tareas.turno',
                    'organizacions.NombOrga','planservicios.id_user','maquinas.TipoMaq'];


        foreach ($tecnicos as $tecnico){
            $f1tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.fechaplan','<=',$hoy[0]], ['tareas.fechafplan','>=',$hoy[0]], 
                                                ['tareas.estado','LIKE','%'.$estado.'%']])
                                        ->orderBy('id','desc')->get();
            $f1cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[0]], ['tareas.fechafplan','>=',$hoy[0]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();
            $f1pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.fechaplan','<=',$hoy[0]], ['tareas.fechafplan','>=',$hoy[0]],
                                                        ['tareas.estado','LIKE','%'.$estado.'%']])
                                                ->orderBy('id','desc')->get();
            $f1sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[0]], ['tareas.fechafplan','>=',$hoy[0]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f2tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.fechaplan','<=',$hoy[1]], ['tareas.fechafplan','>=',$hoy[1]],
                                                ['tareas.estado','LIKE','%'.$estado.'%']])
                                        ->orderBy('id','desc')->get();

            $f2cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[1]], ['tareas.fechafplan','>=',$hoy[1]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f2pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.fechaplan','<=',$hoy[1]], ['tareas.fechafplan','>=',$hoy[1]],
                                                        ['tareas.estado','LIKE','%'.$estado.'%']])
                                                ->orderBy('id','desc')->get();

            $f2sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[1]], ['tareas.fechafplan','>=',$hoy[1]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f3tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.fechaplan','<=',$hoy[2]], ['tareas.fechafplan','>=',$hoy[2]],
                                                ['tareas.estado','LIKE','%'.$estado.'%']])
                                        ->orderBy('id','desc')->get();
            $f3cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[2]], ['tareas.fechafplan','>=',$hoy[2]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();
            $f3pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.fechaplan','<=',$hoy[2]], ['tareas.fechafplan','>=',$hoy[2]],
                                                        ['tareas.estado','LIKE','%'.$estado.'%']])
                                                ->orderBy('id','desc')->get();
            $f3sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[2]], ['tareas.fechafplan','>=',$hoy[2]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f4tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.fechaplan','<=',$hoy[3]], ['tareas.fechafplan','>=',$hoy[3]],
                                                ['tareas.estado','LIKE','%'.$estado.'%']])
                                        ->orderBy('id','desc')->get();
            $f4cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[3]], ['tareas.fechafplan','>=',$hoy[3]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();
            $f4pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.fechaplan','<=',$hoy[3]], ['tareas.fechafplan','>=',$hoy[3]],
                                                        ['tareas.estado','LIKE','%'.$estado.'%']])
                                                ->orderBy('id','desc')->get();
            $f4sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.fechafplan','>=',$hoy[3]],
                                                    ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[3]], ['tareas.fechafplan','>=',$hoy[3]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();


            $f5tractor[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[4]], ['tareas.fechafplan','>=',$hoy[4]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f5cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[4]], ['tareas.fechafplan','>=',$hoy[4]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();

            $f5pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.fechaplan','<=',$hoy[4]], ['tareas.fechafplan','>=',$hoy[4]],
                                                        ['tareas.estado','LIKE','%'.$estado.'%']])
                                                ->orderBy('id','desc')->get();
                                                
            $f5sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['tareas.fechafplan','>=',$hoy[4]],
                                                    ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.fechaplan','<=',$hoy[4]], ['tareas.fechafplan','>=',$hoy[4]],
                                                    ['tareas.estado','LIKE','%'.$estado.'%']])
                                            ->orderBy('id','desc')->get();
            $i++;
        }
        $repetitiva = $i;

        //Selecciono los servicios pendientes de programar
        $pendienteplanif = Tarea::select($select)
                                ->leftjoin('planservicios','tareas.id','=','planservicios.id_tarea')
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['tareas.estado','Pendiente programación'],['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orWhere([['tareas.estado','Postergado'],['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])
                                ->orderBy('tareas.id','desc')->get();

        //Vuelvo a asignar valor para el select
        if($estado == ""){
            $estado = "Todos";
        }
        //Vuelvo a asignar valor para el select
        if($sucursal == ""){
            $sucursal = "Todas las sucursales";
        }

        return view('tarea.itecnicos', compact('rutavolver','f1tractor','f1cosechadora','f1pulverizadora'
                                            ,'f1sembradora','f2tractor','f2cosechadora','f2pulverizadora'
                                            ,'f2sembradora','f3tractor','f3cosechadora','f3pulverizadora'
                                            ,'f3sembradora','f4tractor','f4cosechadora','f4pulverizadora'
                                            ,'f4sembradora','f5tractor','f5cosechadora','f5pulverizadora'
                                            ,'f5sembradora','hoy','tecnicos','repetitiva','sucursales','sucursal'
                                            ,'pendienteplanif','semana','semanas','estado'));
    }

    public function imatriz(Request $request){
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $rutavolver = route('internoservicios');
        $sucursales = Sucursal::orderBy('id','asc')->get();

        //Fechas 5 dias próximos
        $hoy[0] = Carbon::today();
        $hoy[1] = Carbon::today()->addDay();
        $hoy[2] = Carbon::today()->addDay(2);
        $hoy[3] = Carbon::today()->addDay(3);
        $hoy[4] = Carbon::today()->addDay(4);
        $hoy[5] = Carbon::today()->addDay(5);
        $hoy[6] = Carbon::today()->addDay(6);
       
        $fecha[0] = $hoy[0]->format('d/m/Y');
        $fecha[1] = $hoy[1]->format('d/m/Y');
        $fecha[2] = $hoy[2]->format('d/m/Y');
        $fecha[3] = $hoy[3]->format('d/m/Y');
        $fecha[4] = $hoy[4]->format('d/m/Y');
        $fecha[5] = $hoy[5]->format('d/m/Y');
        $fecha[6] = $hoy[6]->format('d/m/Y');

        $puesto = Puesto_empleado::where('id',auth()->user()->CodiPuEm)->first();

        if ($puesto->NombPuEm == "Tecnico") {
            //Consulto un técnico (el logueado)
            $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->where('id',auth()->user()->id)->get();
            $sucursal = User::select('sucursals.NombSucu')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where('users.id',auth()->user()->id)->first();
            $sucursal = $sucursal->NombSucu;
        } else {
            if ($request->sucursal == "Todas las sucursales") {
                $sucursal = "";
            }elseif($request->sucursal){
                $sucursal = $request->get('sucursal');
            } else {
                $sucursal = User::select('sucursals.NombSucu')
                                    ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                    ->where('users.id',auth()->user()->id)->first();
                $sucursal = $sucursal->NombSucu;
            }
            //Consulto todos los técnicos
            $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where([['puesto_empleados.NombPuEm','Tecnico'], 
                                    ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])->get();
        }
        return view('tarea.imatriz', compact('rutavolver','tecnicos','hoy','fecha','sucursales','sucursal'));
    }

        public function ihistorial(Request $request){
            Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
            $rutavolver = route('internoservicios');
            $sucursales = Sucursal::orderBy('id','asc')->get();
            $puesto = Puesto_empleado::where('id',auth()->user()->CodiPuEm)->first();
            
            $filtro="";
            $busqueda="";
            if ($puesto->NombPuEm == "Tecnico") {
                $sucursal = User::select('sucursals.NombSucu')
                                ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                ->where('users.id',auth()->user()->id)->first();
                $sucursal = $sucursal->NombSucu;
                $tareas = Planservicio::select('organizacions.NombOrga','maquinas.ModeMaq','tareas.fechaplan','tareas.ncor',
                                            'tareas.id')
                                    ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                    ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                    ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                    ->where([['planservicios.id_user',auth()->user()->id], ['tareas.estado','Servicio finalizado']])
                                    ->orderBy('tareas.updated_at','desc')
                                    ->paginate(20);
            } else {
                if ($request->sucursal == "Todas las sucursales") {
                    $sucursal = "";
                }elseif($request->sucursal){
                    $sucursal = $request->get('sucursal');
                } else {
                        if($request->buscarpor){
                            $tipo = $request->get('tipo');
                            $busqueda = $request->get('buscarpor');
                            $variablesurl=$request->all();
                            $tareas = Tarea::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
                            $filtro = "SI";
                            return view('tarea.ihistorial', compact('rutavolver','tareas','sucursales','sucursal','filtro','busqueda'));
                        } else {
                        $sucursal = User::select('sucursals.NombSucu')
                                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                            ->where('users.id',auth()->user()->id)->first();
                        $sucursal = $sucursal->NombSucu;
                        
                        }
                }
                $tareas = Tarea::select('organizacions.NombOrga','maquinas.ModeMaq','tareas.ubicacion','tareas.ncor',
                                        'tareas.id','sucursals.NombSucu','tareas.fechaplan')
                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                ->where([['sucursals.NombSucu','LIKE','%'.$sucursal.'%'], ['tareas.estado','Servicio finalizado']])
                                ->orderBy('tareas.updated_at','desc')
                                ->paginate(20);
            }

        return view('tarea.ihistorial', compact('rutavolver','tareas','sucursales','sucursal','filtro','busqueda'));
    }



    public function progreso(Request $request)
    {
        Gate::authorize('haveaccess','tarea.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $rutavolver = route('internoservicios');
        $sucursales = Sucursal::orderBy('id','asc')->get();
        $puesto = Puesto_empleado::where('id',auth()->user()->CodiPuEm)->first();

        if ($puesto->NombPuEm == "Tecnico") {
            //Consulto un técnico (el logueado)
            $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->where('id',auth()->user()->id)->get();
            $sucursal = User::select('sucursals.NombSucu')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where('users.id',auth()->user()->id)->first();
            $sucursal = $sucursal->NombSucu;
        } else {
            if ($request->sucursal == "Todas las sucursales") {
                $sucursal = "";
            }elseif($request->sucursal){
                $sucursal = $request->get('sucursal');
            } else {
                $sucursal = User::select('sucursals.NombSucu')
                                    ->join('sucursals','users.CodiSucu','=','sucursals.id')
                                    ->where('users.id',auth()->user()->id)->first();
                $sucursal = $sucursal->NombSucu;
            }
             //Consulto todos los técnicos
             $tecnicos = User::select('users.id','users.name','users.last_name')
                            ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                            ->join('sucursals','users.CodiSucu','=','sucursals.id')
                            ->where([['puesto_empleados.NombPuEm','Tecnico'], ['sucursals.NombSucu','LIKE','%'.$sucursal.'%']])->get();
        }

        $i = 0;

        $select = ['tareas.id','tareas.ncor','tareas.ubicacion','tareas.descripcion',
                    'tareas.nseriemaq','tareas.estado','tareas.prioridad','tareas.turno',
                    'organizacions.NombOrga','planservicios.id_user'];


        foreach ($tecnicos as $tecnico){
            $f1tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','Programado']])
                                        ->orderBy('id','desc')->get();
            $f1cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Programado']])
                                            ->orderBy('id','desc')->get();
            $f1pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','Programado']])
                                                ->orderBy('id','desc')->get();
            $f1sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                   ['tareas.estado','Programado']])
                                            ->orderBy('id','desc')->get();

            $f2tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','En ejecución']])
                                        ->orderBy('id','desc')->get();

            $f2cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                   ['tareas.estado','En ejecución']])
                                            ->orderBy('id','desc')->get();

            $f2pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','En ejecución']])
                                                ->orderBy('id','desc')->get();

            $f2sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','En ejecución']])
                                            ->orderBy('id','desc')->get();

            $f3tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','Pausado']])
                                        ->orderBy('id','desc')->get();
            $f3cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Pausado']])
                                            ->orderBy('id','desc')->get();
            $f3pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','Pausado']])
                                                ->orderBy('id','desc')->get();
            $f3sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Pausado']])
                                            ->orderBy('id','desc')->get();

            $f4tractor[$i] = Planservicio::select($select)
                                        ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                        ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                        ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                        ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','Esperando autorización']])
                                        ->orWhere([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','Esperando pieza']])
                                        ->orderBy('id','desc')->get();

            $f4cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                   ['tareas.estado','Esperando autorización']])
                                            ->orWhere([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Esperando pieza']])
                                            ->orderBy('id','desc')->get();

            $f4pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','Esperando autorización']])
                                                ->orWhere([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','Esperando pieza']])
                                                ->orderBy('id','desc')->get();

            $f4sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Esperando autorización']])
                                            ->orWhere([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                ['tareas.estado','Esperando pieza']])
                                            ->orderBy('id','desc')->get();


            $f5tractor[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','TRACTOR'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Pieza recibida']])
                                            ->orderBy('id','desc')->get();

            $f5cosechadora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','COSECHADORA'], ['planservicios.id_user',$tecnico->id],
                                                    ['tareas.estado','Pieza recibida']])
                                            ->orderBy('id','desc')->get();

            $f5pulverizadora[$i] = Planservicio::select($select)
                                                ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                                ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                                ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                                ->where([['maquinas.TipoMaq','PULVERIZADORA'], ['planservicios.id_user',$tecnico->id],
                                                        ['tareas.estado','Pieza recibida']])
                                                ->orderBy('id','desc')->get();
                                                
            $f5sembradora[$i] = Planservicio::select($select)
                                            ->join('tareas','planservicios.id_tarea','=','tareas.id')
                                            ->join('organizacions','tareas.id_organizacion','=','organizacions.id')
                                            ->join('maquinas','tareas.nseriemaq','=','maquinas.NumSMaq')
                                            ->where([['maquinas.TipoMaq','SEMBRADORA'], ['planservicios.id_user',$tecnico->id],
                                                     ['tareas.estado','Pieza recibida']])
                                            ->orderBy('id','desc')->get();
            $i++;
        }
        $repetitiva = $i;

        return view('tarea.progreso', compact('rutavolver','f1tractor','f1cosechadora','f1pulverizadora'
                                            ,'f1sembradora','f2tractor','f2cosechadora','f2pulverizadora'
                                            ,'f2sembradora','f3tractor','f3cosechadora','f3pulverizadora'
                                            ,'f3sembradora','f4tractor','f4cosechadora','f4pulverizadora'
                                            ,'f4sembradora','f5tractor','f5cosechadora','f5pulverizadora'
                                            ,'f5sembradora','tecnicos','repetitiva','sucursales','sucursal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','tarea.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $rutavolver = route('tarea.index');
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        return view('tarea.create',compact('rutavolver','organizaciones','sucursals'));
    }

    function selecttecnico(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        
        $organ = Organizacion::where($select, $value)->first();

        $data = User::select('users.id','users.name','users.last_name')
                    ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                    ->where([['CodiSucu',$organ->CodiSucu], ['puesto_empleados.NombPuEm','Tecnico']])->get();
        $output = '';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->name.' ' .$row->last_name.'</option>';
        }
        echo $output;

    }

    public function estado(Request $request, Tarea $tarea)
    {
        $element_id = $request->get('element_id');
        $tarea_id = $request->get('tarea');
        if($element_id == "preos"){
            $estado = "A presupuestar";
         } elseif($element_id == "presupuestado"){
            $estado = "Servicio presupuestado";
        } elseif($element_id == "repuestos"){
            $estado = "Esperando repuestos";
        } elseif($element_id == "pendiente"){
            $estado = "Pendiente programación";
        } elseif($element_id == "programado"){
            $estado = "Programado";
        } elseif($element_id == "postergado"){
            $estado = "Postergado";
        } elseif($element_id == "pendientefact"){
            $estado = "Pendiente de facturar";
        } elseif($element_id == "finalizado"){
            $estado = "Servicio finalizado";
        }
        $tarea->where('id', $tarea_id)->update(['estado' => $estado]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id_organizacion) {
            //Si selecciona una organizacion del listado
            request()->validate([
                'id_organizacion' => 'required',
                'descripcion' => 'required',
            ]);
        } else {
            //Al no seleccionar organizacion del listado se debe crear organizacion y maquina
            request()->validate([
                'NombOrga' => 'required',
                'CodiSucu' => 'required',
                'TipoMaq' => 'required',
                'MarcMaq' => 'required',
                'ModeMaq' => 'required',
                'descripcion' => 'required',
            ]); 
            $organizacion = Organizacion::create(['NombOrga' => $request->NombOrga, 'CodiSucu' => $request->CodiSucu,
                                            'MarcMaq' => $request->MarcMaq,'InscOrga' => 'NO']);
            $request->request->add(['id_organizacion' => $organizacion->id]);
        }

        if ($request->nseriemaq) {
            request()->validate([
                'nseriemaq' => 'required',
            ]);
        } else {
            $NumSMaq = mt_rand(0,999999);
            $NumSMaq = $NumSMaq."_No_valido";
            $maquina = Maquina::create(['NumSMaq' => $NumSMaq, 'TipoMaq' => $request->TipoMaq, 
                                        'MarcMaq' => $request->MarcMaq, 'ModeMaq' => $request->ModeMaq,
                                        'InscMaq' => 'NO', 'CodiOrga' => $request->id_organizacion]);
            
            $request->request->add(['nseriemaq' => $maquina->NumSMaq]);
        }
        
        if (isset($request->id_tecnico)) {
            $planservicio = $request->id_tecnico;
        }

        $request->request->add(['estado' => 'A presupuestar']);
        $tarea = Tarea::create($request->all());
        if (isset($planservicio)) {
            foreach ($planservicio as $plan) {
                $planes = new Planservicio([
                    'id_user'   =>  $plan,
                    'id_tarea'  =>  $tarea->id
                ]);
                $planes->save();
                }
        }
        
        return redirect()->route('tarea.index')->with('status_success', 'Tarea creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tarea  $tarea
     * @return \Illuminate\Http\Response
     */
    public function show(tarea $tarea)
    {
        Gate::authorize('haveaccess','tarea.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $tecnicos = Planservicio::select('users.name','users.last_name','users.id')
                                ->join('users','planservicios.id_user','=','users.id')
                                ->where('planservicios.id_tarea',$tarea->id)->get();
                                
        $rutavolver = route('tarea.ihistorial');
        return view('tarea.view', compact('tarea','rutavolver','tecnicos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tarea  $tarea
     * @return \Illuminate\Http\Response
     */
    public function edit(tarea $tarea)
    {
        Gate::authorize('haveaccess','tarea.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Planificacion de servicio']);
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $rutavolver = url()->previous();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $maquinas = Maquina::where('CodiOrga',$tarea->id_organizacion)->get();
        $sucursal = Organizacion::where('id',$tarea->id_organizacion)->first();
        $tecnicos = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->where([['users.CodiSucu',$sucursal->CodiSucu], ['puesto_empleados.NombPuEm','Tecnico']])->get();

        $planservicios = Planservicio::where('id_tarea',$tarea->id)->get();
        return view('tarea.edit',compact('rutavolver','organizaciones','tarea','maquinas','tecnicos','planservicios','sucursals'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tarea  $tarea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tarea $tarea)
    {

        if (($request->ModeMaq) AND ($request->NumSMaq <> $tarea->nseriemaq)) {
            request()->validate([
                'TipoMaq' => 'required',
                'MarcMaq' => 'required',
                'ModeMaq' => 'required',
            ]);
            $maquina = Maquina::where('NumSMaq', $tarea->nseriemaq)->first();
            $maquina->update(['NumSMaq' => $request->NumSMaq, 'TipoMaq' => $request->TipoMaq, 
                                        'MarcMaq' => $request->MarcMaq, 'ModeMaq' => $request->ModeMaq,
                                        'InscMaq' => 'NO', 'CodiOrga' => $request->id_organizacion]);
            
            $request->request->add(['nseriemaq' => $maquina->NumSMaq]);
        } else {
            request()->validate([
                'nseriemaq' => 'required',
            ]);
        }

        $planservicio = Planservicio::where('id_tarea',$tarea->id)->get();

        //Guardo los resultaados en un array en caso que se obtenga algo
        $i=0;
        foreach ($planservicio as $plans){
            $plan[$i] = $plans->id_user;
            $i++;
        }

        $planservicios = $request->id_tecnico;

        // Eliminamos y agregamos los cambios realizados en cuanto a técnicos asignados.
        if (isset($planservicios)) {
            foreach ($planservicio as $planserv){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                if (!in_array($planserv->id_user, $planservicios)) {
                    $planserv->delete();
                }
            }
            // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
            // lo REGISTRA
            foreach ($planservicios as $tecnico){
                if (!isset($plan)) {
                    $planes = Planservicio::create(['id_user' => $tecnico, 'id_tarea' => $tarea->id]);
                }else{
                    if (!in_array($tecnico, $plan)) {
                    $planes = Planservicio::create(['id_user' => $tecnico, 'id_tarea' => $tarea->id]);
                    }
                }
            }
        } elseif(isset($planservicio)) {
            foreach ($planservicio as $planserv){
                // Revisa si en el array de los id de tecnicos se encuentra el usuario guardado previamente, caso contrario 
                // lo ELIMINA
                $planserv->delete();
            }
        }
        
        $tarea->update($request->all());
        
        return redirect()->route('tarea.itecnicos')->with('status_success', 'Tarea modificada con exito');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tarea  $tarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(tarea $tarea)
    {
        //
    }
}
