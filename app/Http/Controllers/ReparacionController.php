<?php

namespace App\Http\Controllers;

use App\reparacion;
use App\repuesto_faltante;
use App\taller_reparacion;
use App\campo_reparacion;
use App\tarea_reparacion;
use App\sucursal;
use App\pantalla;
use App\antena;
use App\observaciones_reparacion;
use App\User;
use App\tecnicos_reparacions;
use App\tecnicos_campo_reparacions;
use App\tecnicos_taller_reparacions;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','reparacion.solicitud');
        $rutavolver = route('reparacion.solicitudes');
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $usuario_adm = User::where('id',auth()->user()->id)->first();
        $pantallas = Pantalla::orderBy('id','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        return view('reparacion.solicitud', compact('rutavolver', 'sucursals','usuario_adm','pantallas','antenas','tecnicos'));
    }

    public function menu()
    {
        Gate::authorize('haveaccess','reparacion.menu');
        $rutavolver = route('internoservicios');
        return view('reparacion.menu', compact('rutavolver'));
    }

    public function solicitudes()
    {
        Gate::authorize('haveaccess','reparacion.menu_solicitudes');
        $rutavolver = route('reparacion.menu');
        return view('reparacion.menu_solicitudes', compact('rutavolver'));
    }

    public function solicitudes_pendiente_de_presupuestar()
    {
        Gate::authorize('haveaccess','reparacion.pendientes_de_presupuestar');
        $solicitudes = Reparacion::where('pendiente_de_presupuestar', 0)->where('pendiente_de_aprobar', 0)->orderBy('created_at')->paginate(10);
        $rutavolver = route('reparacion.solicitudes');
        return view('reparacion.pendientes_de_presupuestar', compact('solicitudes', 'rutavolver'));
    }

    public function solicitudes_pendiente_de_aprobar()
    {
        Gate::authorize('haveaccess','reparacion.pendientes_de_aprobar');
        $solicitudes = Reparacion::where('pendiente_de_presupuestar', 1)->where('pendiente_de_aprobar', 0)->orderBy('created_at')->paginate(10);
        $rutavolver = route('reparacion.solicitudes');
        return view('reparacion.pendientes_de_aprobar', compact('solicitudes', 'rutavolver'));
    }

    public function solicitud_pendiente_de_presupuestar($id)
    {
        Gate::authorize('haveaccess','reparacion.pendiente_de_presupuestar');
        $solicitud = Reparacion::find($id);
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $rutavolver = route('reparacion.pendientes_de_presupuestar');
        return view('reparacion.pendiente_de_presupuestar', compact('solicitud', 'tecnicos', 'rutavolver'));
    }

    public function solicitud_pendiente_de_aprobar($id)
    {
        Gate::authorize('haveaccess','reparacion.pendiente_de_aprobar');
        $solicitud = Reparacion::find($id);
        $repuestos_faltantes = Repuesto_faltante::where('CodiReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_reparacions = Tecnicos_reparacions::where('id_reparacions', $id)->orderBy('created_at')->get();
        $tecnicos = User::whereIn('id', $tecnicos_reparacions)->select('name', 'last_name')->get();
        $rutavolver = route('reparacion.pendientes_de_aprobar');
        return view('reparacion.pendiente_de_aprobar', compact('solicitud', 'repuestos_faltantes', 'tecnicos', 'rutavolver'));
    }

    public function solicitar_reparacion(Request $request)
    {
        $reparacion = Reparacion::create($request->all());
        return redirect()->route('reparacion.solicitudes')->with('status_success', 'Solicitud enviada con éxito');
    }

    public function presupuestar(Request $request)
    {
        $cant_repuestos = $request->get('cant_repuestos');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $cantidad_respuestos = []; 
        $codigo_respuestos = []; 
        $reemplazo_respuestos = []; 
        $disponibilidad_respuestos = []; 
        $tecnicos = null; 

        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_reparacions = Tecnicos_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_reparacions' => $request->get('id'),
            ]);
        }

        for ($i = 1; $i <= $cant_repuestos; $i++) {
            $cantidad_respuestos[$i] = $request->get('cantidad_respuesto'. $i);
            $codigo_respuestos[$i] = $request->get('codigo_respuesto'. $i);
            $reemplazo_respuestos[$i] = $request->get('reemplazo_respuesto'. $i);
            $disponibilidad = "";
            $dispobilidad_repuesto = $request->get('disponibilidad_respuesto'. $i);
            for($j = 0; $j < count($dispobilidad_repuesto); $j++){
                $disponibilidad = $disponibilidad . array_values($dispobilidad_repuesto)[$j] . ",";
            }
            $disponibilidad = substr_replace($disponibilidad ,"",-1);
            $disponibilidad_respuestos[$i] = $disponibilidad;
        }

        $reparacion = Reparacion::find($request->get('id'));
        $reparacion->trabajo_a_presupuestar = $request->get('trabajo_a_presupuestar');
        $reparacion->horas_a_presupuestar = $request->get('horas_a_presupuestar');
        $reparacion->pendiente_de_presupuestar = 1;
        $reparacion->update();

        for ($i = 1; $i <= $cant_repuestos; $i++) {
            $repuesto_faltante = Repuesto_faltante::create([
                'cantidad' => $cantidad_respuestos[$i], 
                'codigo' => $codigo_respuestos[$i], 
                'reemplazo' => $reemplazo_respuestos[$i],
                'disponibilidad' => $disponibilidad_respuestos[$i]
            ]);
            $repuesto_faltante->reparacions()->associate($reparacion);
            $repuesto_faltante->save();
        }

        return redirect()->route('reparacion.solicitudes')->with('status_success', 'Solicitud presupuestada con éxito');
    }

    public function aprobar(Request $request)
    {
        request()->validate([
            'firma' => 'required',
        ],
        [
            'firma.required' => 'Debe firmar la solicitud!',
        ]);
        
        $reparacion = Reparacion::find($request->get('id'));
        $reparacion->pmp_pendientes = $request->get('pmp_pendientes');
        $reparacion->tiene_powergard = $request->get('tiene_powergard');
        $reparacion->numero_cpres = $request->get('numero_cpres');
        $reparacion->aprobado = $request->get('aprobado');
        $reparacion->observaciones = $request->get('observaciones');
        $reparacion->fecha = $request->get('fecha');
        $reparacion->cor = $request->get('cor');
        $reparacion->firma = $request->get('firma');
        $reparacion->pendiente_de_aprobar = 1;
        $reparacion->update();

        return redirect()->route('reparacion.solicitudes')->with('status_success', 'Solicitud presupuestada con éxito');
    }

    public function menu_tareas_de_reparacion()
    {
        Gate::authorize('haveaccess','reparacion.tareas.menu_tareas');
        $rutavolver = route('reparacion.menu');
   
        return view('reparacion.tareas.menu_tareas', compact('rutavolver'));
    }

    public function tareas_de_reparacion_campo()
    {
        Gate::authorize('haveaccess','reparacion.tareas.tareas_en_campo');
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $rutavolver = route('reparacion.tareas_de_reparacion');
   
        return view('reparacion.tareas.tareas_en_campo', compact('rutavolver', 'tecnicos','sucursals'));
    }

    public function tareas_de_reparacion_taller()
    {
        Gate::authorize('haveaccess','reparacion.tareas.tareas_en_taller');
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $rutavolver = route('reparacion.tareas_de_reparacion');
   
        return view('reparacion.tareas.tareas_en_taller', compact('rutavolver', 'tecnicos','sucursals'));
    }

    public function crear_tarea_reparacion_taller(Request $request)
    {
        request()->validate([
            'firma_tecnico' => 'required',
            'firma_cliente' => 'required',
        ],
        [
            'firma_tecnico.required' => 'El tecnico debe firmar la tarea en taller!',
            'firma_cliente.required' => 'El jefe de taller debe firmar la tarea!',
        ]);

        $cant_tareas = $request->get('cant_tareas');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $fecha_tareas = []; 
        $description_tareas = []; 
        $horas_tareas = [];
        $tecnicos = null; 

        for ($i = 1; $i <= $cant_tareas; $i++) {
            $fecha_tareas[$i] = $request->get('fecha_tarea'. $i);
            $description_tareas[$i] = $request->get('description_tarea'. $i);
            $horas_tareas[$i] = $request->get('horas_tarea'. $i);
        }

        $taller_reparacion = Taller_reparacion::create([
            'cor' => $request->get('cor'),
            'cliente' => $request->get('cliente'),
            'id_sucursal' => $request->get('id_sucursal'),
            'garantia' => $request->get('garantia'),
            'numero_chasis' => $request->get('numero_chasis'),
            'horas_de_motor' => $request->get('horas_de_motor'),
            'horas_de_trilla' => $request->get('horas_de_trilla'),
            'fecha_ingreso' => $request->get('fecha_ingreso'),
            'fecha_salida' => $request->get('fecha_salida'),
            'vendido_sala' => $request->get('vendido_sala'),
            'firma_tecnico' => $request->get('firma_tecnico'),
            'firma_cliente' => $request->get('firma_cliente'),
        ]);

        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_taller_reparacions' => $taller_reparacion->id,
            ]);
        }

        for ($i = 1; $i <= $cant_tareas; $i++) {
            $tareas_reparacion = Tarea_reparacion::create([
                'fecha' => $fecha_tareas[$i], 
                'descripcion' => $description_tareas[$i], 
                'horas' => $horas_tareas[$i],
            ]);
            $tareas_reparacion->taller_reparacions()->associate($taller_reparacion);
            $tareas_reparacion->save();
        }

        return redirect()->route('reparacion.tareas_de_reparacion')->with('status_success', 'Tarea en taller creada con éxito');
    }

    public function crear_tarea_reparacion_campo(Request $request)
    {
        request()->validate([
            'firma_tecnico' => 'required',
            'firma_cliente' => 'required',
        ],
        [
            'firma_tecnico.required' => 'El tecnico debe firmar la tarea en taller!',
            'firma_cliente.required' => 'El cliente debe firmar la tarea en taller!',
        ]);

        $cant_tareas = $request->get('cant_tareas');
        $cant_reclamos = $request->get('cant_reclamos');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $fecha_tareas = []; 
        $description_tareas = []; 
        $horas_tareas = [];
        $fecha_reclamos = []; 
        $description_reclamos = []; 
        $tecnicos = null; 

        for ($i = 1; $i <= $cant_tareas; $i++) {
            $fecha_tareas[$i] = $request->get('fecha_tarea'. $i);
            $description_tareas[$i] = $request->get('description_tarea'. $i);
            $horas_tareas[$i] = $request->get('horas_tarea'. $i);
        }

        for ($i = 1; $i <= $cant_reclamos; $i++) {
            $fecha_reclamos[$i] = $request->get('fecha_reclamo'. $i);
            $description_reclamos[$i] = $request->get('description_reclamo'. $i);
        }

        $campo_reparacion = Campo_reparacion::create([
            'cor' => $request->get('cor'),
            'cliente' => $request->get('cliente'),
            'id_sucursal' => $request->get('id_sucursal'),
            'garantia' => $request->get('garantia'),
            'numero_chasis' => $request->get('numero_chasis'),
            'horas_de_motor' => $request->get('horas_de_motor'),
            'fecha_ingreso' => $request->get('fecha_ingreso'),
            'horario_salida_agencia' => $request->get('horario_salida_agencia'),
            'horario_llegada_campo' => $request->get('horario_llegada_campo'),
            'horario_salida_campo' => $request->get('horario_salida_campo'),
            'horario_llegada_agencia' => $request->get('horario_llegada_agencia'),
            'firma_tecnico' => $request->get('firma_tecnico'),
            'firma_cliente' => $request->get('firma_cliente'),
        ]);

        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_campo_reparacions' => $campo_reparacion->id,
            ]);
        }

        for ($i = 1; $i <= $cant_tareas; $i++) {
            $tareas_reparacion = Tarea_reparacion::create([
                'fecha' => $fecha_tareas[$i], 
                'descripcion' => $description_tareas[$i], 
                'horas' => $horas_tareas[$i],
            ]);
            $tareas_reparacion->campo_reparacions()->associate($campo_reparacion);
            $tareas_reparacion->save();
        }

        for ($i = 1; $i <= $cant_reclamos; $i++) {
            $observaciones_reparacion = Observaciones_reparacion::create([
                'fecha' => $fecha_reclamos[$i], 
                'descripcion' => $description_reclamos[$i], 
            ]);
            $observaciones_reparacion->campo_obs_reparacions()->associate($campo_reparacion);
            $observaciones_reparacion->save();
        }

        return redirect()->route('reparacion.tareas_de_reparacion')->with('status_success', 'Tarea en campo creada con éxito');
    }

    public function administrar()
    {
        Gate::authorize('haveaccess','reparacion.administracion.menu_administracion');
        $rutavolver = route('reparacion.solicitudes');
   
        return view('reparacion.administracion.menu_administracion', compact('rutavolver'));
    }

    public function administrar_solicitudes()
    {
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_solicitudes');
        $solicitudes = Reparacion::select('reparacions.id','reparacions.razon_social', 'reparacions.telefono_cliente',
                                        'reparacions.responsable_relevamiento', 'reparacions.created_at','sucursals.NombSucu')
                                ->leftjoin('sucursals','reparacions.id_sucursal','=','sucursals.id')->paginate(20);
        $rutavolver = route('reparacion.solicitudes');
        return view('reparacion.administracion.administracion_de_solicitudes', compact('solicitudes', 'rutavolver'));
    }

    public function administrar_tareas_campo()
    {                                                           
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_tareas_campo');
        $reparacions = Campo_reparacion::paginate(10);
        $rutavolver = route('reparacion.tareas_de_reparacion');
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        return view('reparacion.administracion.administracion_de_tareas_campo', compact('reparacions', 'rutavolver','sucursals'));
    }

    public function administrar_tareas_taller()
    {                                                           
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_tareas_taller');
        $reparacions = Taller_reparacion::paginate(10);
        $rutavolver = route('reparacion.tareas_de_reparacion');
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        return view('reparacion.administracion.administracion_de_tareas_taller', compact('reparacions', 'rutavolver','sucursals'));
    }

    public function administrar_solicitud($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_solicitud');
        $solicitud = Reparacion::find($id);
        $repuestos_faltantes = Repuesto_faltante::where('CodiReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_reparacions = Tecnicos_reparacions::where('id_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $rutavolver = route('reparacion.administrar_solicitudes');
   
        return view('reparacion.administracion.administracion_de_solicitud', compact('solicitud', 'repuestos_faltantes', 'tecnicos', 'rutavolver','sucursals'));
    }

    public function administrar_tarea_campo($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_tarea_campo');
        $reparacion = Campo_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiCampoReparacions', $id)->orderBy('created_at')->get();
        $observaciones_reparacion = Observaciones_reparacion::where('CodiCampoObsReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::where('id_campo_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_campo_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        $rutavolver = route('reparacion.administrar_tareas_campo');
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        return view('reparacion.administracion.administracion_de_tarea_campo', compact('reparacion', 'observaciones_reparacion', 'tareas_reparacion', 'tecnicos', 'rutavolver','sucursals'));
    }

    public function administrar_tarea_taller($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.administracion_de_tarea_taller');
        $reparacion = Taller_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiTallerReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::where('id_taller_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_taller_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        $rutavolver = route('reparacion.administrar_tareas_taller');
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        return view('reparacion.administracion.administracion_de_tarea_taller', compact('reparacion', 'tareas_reparacion', 'tecnicos', 'rutavolver','sucursals'));
    }

    public function administrar_solicitud_editar($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.edicion_de_solicitud');
        $solicitud = Reparacion::find($id);
        $repuestos_faltantes = Repuesto_faltante::where('CodiReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_reparacions = Tecnicos_reparacions::where('id_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos_selected = User::whereIn('id', $id_users)->select('id', 'name', 'last_name')->get();
        $all_tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $pantallas = Pantalla::orderBy('id','asc')->get();
        $antenas = Antena::orderBy('id','asc')->get();
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $rutavolver = route('reparacion.administrar_solicitud',$id);
   
        return view('reparacion.administracion.edicion_de_solicitud', compact('solicitud', 'repuestos_faltantes', 'tecnicos_selected', 'all_tecnicos', 'rutavolver','sucursals','pantallas','antenas','tecnicos'));
    }

    public function administrar_tarea_de_campo_editar($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.edicion_de_tarea_de_campo');
        $reparacion = Campo_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiCampoReparacions', $id)->orderBy('created_at')->get();
        $observaciones_reparacion = Observaciones_reparacion::where('CodiCampoObsReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::where('id_campo_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_campo_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos_selected = User::whereIn('id', $id_users)->select('id', 'name', 'last_name')->get();
        $all_tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $rutavolver = route('reparacion.administrar_tarea_campo',$id);
   
        return view('reparacion.administracion.edicion_de_tarea_de_campo', compact('reparacion', 'tareas_reparacion', 'observaciones_reparacion', 'tecnicos_selected', 'all_tecnicos', 'rutavolver','sucursals'));
    }

    public function administrar_tarea_de_taller_editar($id)
    {
        Gate::authorize('haveaccess','reparacion.administracion.edicion_de_tarea_de_taller');
        $reparacion = Taller_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiTallerReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::where('id_taller_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_taller_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos_selected = User::whereIn('id', $id_users)->select('id', 'name', 'last_name')->get();
        $all_tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        $sucursals = Sucursal::orderBy('NombSucu','asc')->get();
        $rutavolver = route('reparacion.administrar_tarea_taller',$id);
   
        return view('reparacion.administracion.edicion_de_tarea_de_taller', compact('reparacion', 'tareas_reparacion', 'tecnicos_selected', 'all_tecnicos', 'rutavolver','sucursals'));
    }

    public function editar_solicitud(Request $request)
    {
        request()->validate([
            'firma' => 'required',
        ],
        [
            'firma.required' => 'Debe firmar la solicitud!',
        ]);

        $id = $request->get('id');
        $cant_repuestos_a_crear = $request->get('cant_repuestos_a_crear');
        $cant_repuestos_a_editar = $request->get('cant_repuestos_a_editar');
        $cant_repuestos_a_eliminar = $request->get('cant_repuestos_a_eliminar');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $ids_repuestos_a_eliminar = $request->get('ids_repuestos_a_eliminar');
        $ids_repuestos_a_editar = $request->get('ids_repuestos_a_editar');
        
        Tecnicos_reparacions::where('id_reparacions', $id)->delete();
        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_reparacions = Tecnicos_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_reparacions' => $id,
            ]);
        }

        $reparacion = Reparacion::where('id', $id)->update([
            'razon_social' => $request->get('razon_social'),
            'contacto_cliente' => $request->get('contacto_cliente'),
            'telefono_cliente' => $request->get('telefono_cliente'),
            'id_sucursal' => $request->get('id_sucursal'),
            'horas_de_motor' => $request->get('horas_de_motor'),
            'modelo' => $request->get('modelo'),
            'responsable_relevamiento' => $request->get('responsable_relevamiento'),
            'maquina_parada' => $request->get('maquina_parada'),
            'descripcion_falla' => $request->get('descripcion_falla'),
            'codigo_diagnostico' => $request->get('codigo_diagnostico'),
            'condiciones_de_ocurrencia' => $request->get('condiciones_de_ocurrencia'),
            'tarea_que_estaba_realizando' => $request->get('tarea_que_estaba_realizando'),
            'tipo_falla' => $request->get('tipo_falla'),
            'primera_ocurrencia' => $request->get('primera_ocurrencia'),
            'prueba_realizada' => $request->get('prueba_realizada'),
            'visita_a_campo' => $request->get('visita_a_campo'),
            'donde_se_encuentra' => $request->get('donde_se_encuentra'),
            'tiene_instalaciones' => $request->get('tiene_instalaciones'),
            'paquete_monitoreo' => $request->get('paquete_monitoreo'),
            'ultimo_service_hecho' => $request->get('ultimo_service_hecho'),
            'modelo_pantalla' => $request->get('modelo_pantalla'),
            'modelo_pantalla_actualizado' => $request->get('modelo_pantalla_actualizado'),
            'modelo_antena' => $request->get('modelo_antena'),
            'modelo_antena_actualizado' => $request->get('modelo_antena_actualizado'),
            'tipo_piloto' => $request->get('tipo_piloto'),
            'garantia' => $request->get('garantia'),
            'otra_maquina_JD' => $request->get('otra_maquina_JD'),
            'trabajo_a_presupuestar' => $request->get('trabajo_a_presupuestar'),
            'horas_a_presupuestar' => $request->get('horas_a_presupuestar'),
            'pmp_pendientes' => $request->get('pmp_pendientes'),
            'tiene_powergard' => $request->get('tiene_powergard'),
            'numero_cpres' => $request->get('numero_cpres'),
            'aprobado' => $request->get('aprobado'),
            'observaciones' => $request->get('observaciones'),
            'fecha' => $request->get('fecha'),
            'cor' => $request->get('cor'),
            'firma' => $request->get('firma'),
        ]);

        for ($i = 1; $i <= $cant_repuestos_a_crear; $i++) {
            $disponibilidad = "";
            $dispobilidad_repuesto = $request->get('dispo_respuesto'. $i);
            for($j = 0; $j < count($dispobilidad_repuesto); $j++){
                $disponibilidad = $disponibilidad . array_values($dispobilidad_repuesto)[$j] . ",";
            }
            $disponibilidad = substr_replace($disponibilidad ,"",-1);
            $disponibilidad_respuestos[$i] = $disponibilidad;
            $repuesto_faltante = Repuesto_faltante::create([
                'cantidad' => $request->get('cant_respuesto' . $i), 
                'codigo' => $request->get('cod_respuesto' . $i), 
                'reemplazo' => $request->get('ree_respuesto' . $i),
                'disponibilidad' => $disponibilidad,
                'CodiReparacions' => $id,
            ]);
        }

        for ($i = 0; $i < $cant_repuestos_a_editar; $i++) {
            $id_repuesto_a_editar = strtok($ids_repuestos_a_editar, ',');
            $disponibilidad = "";
            $dispobilidad_repuesto = $request->get('disponibilidad_respuesto'. $id_repuesto_a_editar);
            for($j = 0; $j < count($dispobilidad_repuesto); $j++){
                $disponibilidad = $disponibilidad . array_values($dispobilidad_repuesto)[$j] . ",";
            }
            $disponibilidad = substr_replace($disponibilidad ,"",-1);
            $disponibilidad_respuestos[$i] = $disponibilidad;
            $repuesto_faltante = Repuesto_faltante::where('id', $id_repuesto_a_editar)->update([
                'cantidad' => $request->get('cantidad_respuesto' . $id_repuesto_a_editar),
                'codigo' => $request->get('codigo_respuesto' . $id_repuesto_a_editar),
                'reemplazo' => $request->get('reemplazo_respuesto' . $id_repuesto_a_editar),
                'disponibilidad' => $disponibilidad,
            ]);
            $ids_repuestos_a_editar = strstr($ids_repuestos_a_editar, ",");
            $ids_repuestos_a_editar = substr($ids_repuestos_a_editar, 1);
        }

        for ($i = 0; $i < $cant_repuestos_a_eliminar; $i++) {
            $id_repuesto_a_eliminar = strtok($ids_repuestos_a_eliminar, ',');
            $repuesto_faltante = Repuesto_faltante::find($id_repuesto_a_eliminar);
            $repuesto_faltante->delete();
            $ids_repuestos_a_eliminar = strstr($ids_repuestos_a_eliminar, ",");
            $ids_repuestos_a_eliminar = substr($ids_repuestos_a_eliminar, 1);
        }
   
        return redirect()->route('reparacion.administrar_solicitud',$id)->with('status_success', 'Solicitud editada con éxito');
    }

    public function editar_tarea_taller(Request $request)
    {
        request()->validate([
            'firma_tecnico' => 'required',
            'firma_cliente' => 'required',
        ],
        [
            'firma_tecnico.required' => 'El tecnico debe firmar la tarea en taller!',
            'firma_cliente.required' => 'El jefe de taller debe firmar la tarea!',
        ]);

        $id = $request->get('id');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $cant_tareas_a_crear = $request->get('cant_tareas_a_crear');
        $cant_tareas_a_editar = $request->get('cant_tareas_a_editar');
        $cant_tareas_a_eliminar = $request->get('cant_tareas_a_eliminar');
        $ids_tareas_a_eliminar = $request->get('ids_tareas_a_eliminar');
        $ids_tareas_a_editar = $request->get('ids_tareas_a_editar');
        $tecnicos = null; 
        
        Tecnicos_taller_reparacions::where('id_taller_reparacions', $id)->delete();
        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_taller_reparacions' => $id,
            ]);
        }

        $taller_reparacion = Taller_reparacion::where('id', $id)->update([
            'cor' => $request->get('cor'),
            'cliente' => $request->get('cliente'),
            'id_sucursal' => $request->get('id_sucursal'),
            'fecha_ingreso' => $request->get('fecha_ingreso'),
            'fecha_salida' => $request->get('fecha_salida'),
            'numero_chasis' => $request->get('numero_chasis'),
            'horas_de_motor' => $request->get('horas_de_motor'),
            'horas_de_trilla' => $request->get('horas_de_trilla'),
            'vendido_sala' => $request->get('vendido_sala'),
            'firma_tecnico' => $request->get('firma_tecnico'),
            'firma_cliente' => $request->get('firma_cliente'),
        ]);

        for ($i = 1; $i <= $cant_tareas_a_crear; $i++) {
            $tarea_reparacion = Tarea_reparacion::create([
                'fecha' => $request->get('fech_tarea' . $i), 
                'descripcion' => $request->get('descr_tarea' . $i), 
                'horas' => $request->get('hrs_tarea' . $i),
                'CodiTallerReparacions' => $id,
            ]);
        }

        for ($i = 0; $i < $cant_tareas_a_editar; $i++) {
            $id_tarea_a_editar = strtok($ids_tareas_a_editar, ',');
            $tarea_reparacion = Tarea_reparacion::where('id', $id_tarea_a_editar)->update([
                'fecha' => $request->get('fecha_tarea' . $id_tarea_a_editar),
                'descripcion' => $request->get('descripcion_tarea' . $id_tarea_a_editar),
                'horas' => $request->get('horas_tarea' . $id_tarea_a_editar),
            ]);
            $ids_tareas_a_editar = strstr($ids_tareas_a_editar, ",");
            $ids_tareas_a_editar = substr($ids_tareas_a_editar, 1);
        }

        for ($i = 0; $i < $cant_tareas_a_eliminar; $i++) {
            $id_tarea_a_eliminar = strtok($ids_tareas_a_eliminar, ',');
            $tarea_reparacion = Tarea_reparacion::find($id_tarea_a_eliminar);
            $tarea_reparacion->delete();
            $ids_tareas_a_eliminar = strstr($ids_tareas_a_eliminar, ",");
            $ids_tareas_a_eliminar = substr($ids_tareas_a_eliminar, 1);
        }
   
        return redirect()->route('reparacion.administrar_tarea_taller',$id)->with('status_success', 'Tareas de taller editada con éxito');
    }

    public function editar_tarea_campo(Request $request)
    {
        request()->validate([
            'firma_tecnico' => 'required',
            'firma_cliente' => 'required',
        ],
        [
            'firma_tecnico.required' => 'El tecnico debe firmar la tarea en taller!',
            'firma_cliente.required' => 'El cliente debe firmar la tarea en taller!',
        ]);

        $id = $request->get('id');
        $cant_tecnicos = $request->get('cant_tecnicos');
        $cant_tareas_a_crear = $request->get('cant_tareas_a_crear');
        $cant_tareas_a_editar = $request->get('cant_tareas_a_editar');
        $cant_tareas_a_eliminar = $request->get('cant_tareas_a_eliminar');
        $ids_tareas_a_eliminar = $request->get('ids_tareas_a_eliminar');
        $ids_tareas_a_editar = $request->get('ids_tareas_a_editar');

        $cant_reclamos_a_crear = $request->get('cant_reclamos_a_crear');
        $cant_reclamos_a_editar = $request->get('cant_reclamos_a_editar');
        $cant_reclamos_a_eliminar = $request->get('cant_reclamos_a_eliminar');
        $ids_reclamos_a_eliminar = $request->get('ids_reclamos_a_eliminar');
        $ids_reclamos_a_editar = $request->get('ids_reclamos_a_editar');

        Tecnicos_campo_reparacions::where('id_campo_reparacions', $id)->delete();
        for ($i = 1; $i <= $cant_tecnicos; $i++) {
            $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::create([
                'id_user' => $request->get('tecnico'. $i),
                'id_campo_reparacions' => $id,
            ]);
        }

        $campo_reparacion = Campo_reparacion::where('id', $id)->update([
            'cor' => $request->get('cor'),
            'cliente' => $request->get('cliente'),
            'id_sucursal' => $request->get('id_sucursal'),
            'numero_chasis' => $request->get('numero_chasis'),
            'fecha_ingreso' => $request->get('fecha_ingreso'),
            'horas_de_motor' => $request->get('horas_de_motor'),
            'horario_salida_agencia' => $request->get('horario_salida_agencia'),
            'horario_llegada_campo' => $request->get('horario_llegada_campo'),
            'horario_salida_campo' => $request->get('horario_salida_campo'),
            'horario_llegada_agencia' => $request->get('horario_llegada_agencia'),
            'firma_tecnico' => $request->get('firma_tecnico'),
            'firma_cliente' => $request->get('firma_cliente'),
        ]);


        for ($i = 1; $i <= $cant_tareas_a_crear; $i++) {
            $tarea_reparacion = Tarea_reparacion::create([
                'fecha' => $request->get('fech_tarea' . $i), 
                'descripcion' => $request->get('descr_tarea' . $i), 
                'horas' => $request->get('hrs_tarea' . $i),
                'CodiCampoReparacions' => $id,
            ]);
        }

        for ($i = 0; $i < $cant_tareas_a_editar; $i++) {
            $id_tarea_a_editar = strtok($ids_tareas_a_editar, ',');
            $tarea_reparacion = Tarea_reparacion::where('id', $id_tarea_a_editar)->update([
                'fecha' => $request->get('fecha_tarea' . $id_tarea_a_editar),
                'descripcion' => $request->get('descripcion_tarea' . $id_tarea_a_editar),
                'horas' => $request->get('horas_tarea' . $id_tarea_a_editar),
            ]);
            $ids_tareas_a_editar = strstr($ids_tareas_a_editar, ",");
            $ids_tareas_a_editar = substr($ids_tareas_a_editar, 1);
        }

        for ($i = 0; $i < $cant_tareas_a_eliminar; $i++) {
            $id_tarea_a_eliminar = strtok($ids_tareas_a_eliminar, ',');
            $tarea_reparacion = Tarea_reparacion::find($id_tarea_a_eliminar);
            $tarea_reparacion->delete();
            $ids_tareas_a_eliminar = strstr($ids_tareas_a_eliminar, ",");
            $ids_tareas_a_eliminar = substr($ids_tareas_a_eliminar, 1);
        }

        for ($i = 1; $i <= $cant_reclamos_a_crear; $i++) {
            $observaciones_reparacion = Observaciones_reparacion::create([
                'fecha' => $request->get('fech_reclamo' . $i), 
                'descripcion' => $request->get('descr_reclamo' . $i), 
                'CodiCampoObsReparacions' => $id,
            ]);
        }

        for ($i = 0; $i < $cant_reclamos_a_editar; $i++) {
            $id_reclamo_a_editar = strtok($ids_reclamos_a_editar, ',');
            $observaciones_reparacion = Observaciones_reparacion::where('id', $id_reclamo_a_editar)->update([
                'fecha' => $request->get('fecha_reclamo' . $id_reclamo_a_editar),
                'descripcion' => $request->get('descripcion_reclamo' . $id_reclamo_a_editar),
            ]);
            $ids_reclamos_a_editar = strstr($ids_reclamos_a_editar, ",");
            $ids_reclamos_a_editar = substr($ids_reclamos_a_editar, 1);
        }

        for ($i = 0; $i < $cant_reclamos_a_eliminar; $i++) {
            $id_reclamo_a_eliminar = strtok($ids_reclamos_a_eliminar, ',');
            $observaciones_reparacion = Observaciones_reparacion::find($id_reclamo_a_eliminar);
            $observaciones_reparacion->delete();
            $ids_reclamos_a_eliminar = strstr($ids_reclamos_a_eliminar, ",");
            $ids_reclamos_a_eliminar = substr($ids_reclamos_a_eliminar, 1);
        }
   
        return redirect()->route('reparacion.administrar_tarea_campo',$id)->with('status_success', 'Tarea de campo editada con éxito');
    }

    public function borrar_solicitud($id)
    {
        $solicitud = Reparacion::find($id);
        $repuesto_faltantes = Repuesto_faltante::where('CodiReparacions', $id)->get();
        foreach($repuesto_faltantes as $repuesto){
            $repuesto->delete();
        }
        $solicitud->delete();

        return redirect()->route('reparacion.administrar_solicitudes')->with('status_success', 'Solicitud eliminada con éxito');
    }

    public function borrar_tarea_campo($id)
    {
        $reparacion = Campo_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiCampoReparacions', $id)->get();
        $observaciones_reparacion = Observaciones_reparacion::where('CodiCampoObsReparacions', $id)->get();
        
        foreach($tareas_reparacion as $tarea){
            $tarea->delete();
        }

        foreach($observaciones_reparacion as $observacion){
            $observacion->delete();
        }

        $reparacion->delete();

        return redirect()->route('reparacion.administrar_tareas_campo')->with('status_success', 'Tarea de campo eliminada con éxito');
    }

    public function borrar_tarea_taller($id)
    {
        $reparacion = Taller_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiTallerReparacions', $id)->get();
        
        foreach($tareas_reparacion as $tarea){
            $tarea->delete();
        }

        $reparacion->delete();
        
        return redirect()->route('reparacion.administrar_tareas_taller')->with('status_success', 'Tarea de taller eliminada con éxito');
    }

    public function tecnicos()
    {
        $tecnicos = User::select('id', 'name', 'last_name')->where('CodiPuEm', 9)->orderBy('name')->get();
        return response()->json($tecnicos);
    }

    public function crear_tarea_reparacion_taller_mobile(Request $request)
    {
        $stringRequest = $request->getContent();
        $jsonRequest = json_decode($stringRequest);

        $user_doble_check = User::where('email', $jsonRequest->email)->select('doble_check')->get();
        if($user_doble_check[0]->doble_check != $jsonRequest->token){
            return response('Token erroneo', 401);
        } 

        $taller_reparacion = Taller_reparacion::create([
            'cor' => $jsonRequest->cor,
            'cliente' => $jsonRequest->cliente,
            'garantia' => $jsonRequest->garantia,
            'numero_chasis' => $jsonRequest->numero_chasis,
            'horas_de_motor' => $jsonRequest->horas_de_motor,
            'horas_de_trilla' => $jsonRequest->horas_de_trilla,
            'fecha_ingreso' => $jsonRequest->fecha_ingreso,
            'fecha_salida' => $jsonRequest->fecha_salida,
            'vendido_sala' => $jsonRequest->vendido_sala,
            'firma_tecnico' => $jsonRequest->firma_tecnico,
            'firma_cliente' => $jsonRequest->firma_cliente
        ]);

        $tecnicos = $jsonRequest->tecnicos;
        foreach ($tecnicos as $tecnico) {
            $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::create([
                'id_user' => $tecnico,
                'id_taller_reparacions' => $taller_reparacion->id,
            ]);
        }

        $tareas = $jsonRequest->tareas;
        foreach ($tareas as $tarea) {
            $tareas_reparacion = Tarea_reparacion::create([
                'fecha' => $tarea->fecha, 
                'descripcion' => $tarea->descripcion, 
                'horas' => $tarea->horas,
            ]);
            $tareas_reparacion->taller_reparacions()->associate($taller_reparacion);
            $tareas_reparacion->save();
        }
        
        return;
    }

    public function crear_tarea_reparacion_campo_mobile(Request $request)
    {
        $stringRequest = $request->getContent();
        $jsonRequest = json_decode($stringRequest);

        $user_doble_check = User::where('email', $jsonRequest->email)->select('doble_check')->get();
        if($user_doble_check[0]->doble_check != $jsonRequest->token){
            return response('Token erroneo', 401);
        }

        $campo_reparacion = Campo_reparacion::create([
            'cor' => $jsonRequest->cor,
            'cliente' => $jsonRequest->cliente,
            'garantia' => $jsonRequest->garantia,
            'numero_chasis' => $jsonRequest->numero_chasis,
            'horas_de_motor' => $jsonRequest->horas_de_motor,
            'fecha_ingreso' => $jsonRequest->fecha_ingreso,
            'horario_salida_agencia' => $jsonRequest->garantia,
            'horario_llegada_campo' => $jsonRequest->numero_chasis,
            'horario_salida_campo' => $jsonRequest->horas_de_motor,
            'horario_llegada_agencia' => $jsonRequest->fecha_ingreso,
            'firma_tecnico' => $jsonRequest->firma_tecnico,
            'firma_cliente' => $jsonRequest->firma_cliente
        ]);

        $tecnicos = $jsonRequest->tecnicos;
        foreach ($tecnicos as $tecnico) {
            $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::create([
                'id_user' => $tecnico,
                'id_campo_reparacions' => $campo_reparacion->id,
            ]);
        }

        $tareas = $jsonRequest->tareas;
        foreach ($tareas as $tarea) {
            $tareas_reparacion = Tarea_reparacion::create([
                'fecha' => $tarea->fecha, 
                'descripcion' => $tarea->descripcion, 
                'horas' => $tarea->horas,
            ]);
            $tareas_reparacion->campo_reparacions()->associate($campo_reparacion);
            $tareas_reparacion->save();
        }

        $reclamos = $jsonRequest->reclamos;
        foreach ($reclamos as $reclamo) {
            $observaciones_reparacion = Observaciones_reparacion::create([
                'fecha' => $reclamo->fecha, 
                'descripcion' => $reclamo->descripcion, 
            ]);
            $observaciones_reparacion->campo_obs_reparacions()->associate($campo_reparacion);
            $observaciones_reparacion->save();
        }

        return;
    }

    public function solicitar_reparacion_mobile(Request $request)
    {
        $stringRequest = $request->getContent();
        $jsonRequest = json_decode($stringRequest);

        $user_doble_check = User::where('email', $jsonRequest->email)->select('doble_check')->get();
        if($user_doble_check[0]->doble_check != $jsonRequest->token){
            return response('Token erroneo', 401);
        } 

        $reparacion = Reparacion::create([
            'razon_social' => $jsonRequest->razon_social,
            'contacto_cliente' => $jsonRequest->contacto_cliente,
            'telefono_cliente' => $jsonRequest->telefono_cliente,
            'horas_de_motor' => $jsonRequest->horas_de_motor,
            'modelo' => $jsonRequest->modelo,
            'responsable_relevamiento' => $jsonRequest->responsable_relevamiento,
            'maquina_parada' => $jsonRequest->maquina_parada,
            'descripcion_falla' => $jsonRequest->descripcion_falla,
            'codigo_diagnostico' => $jsonRequest->codigo_diagnostico,
            'condiciones_de_ocurrencia' => $jsonRequest->condiciones_de_ocurrencia,
            'tarea_que_estaba_realizando' => $jsonRequest->tarea_que_estaba_realizando,
            'tipo_falla' => $jsonRequest->tipo_falla,
            'primera_ocurrencia' => $jsonRequest->primera_ocurrencia,
            'prueba_realizada' => $jsonRequest->prueba_realizada,
            'visita_a_campo' => $jsonRequest->visita_a_campo,
            'donde_se_encuentra' => $jsonRequest->donde_se_encuentra,
            'tiene_instalaciones' => $jsonRequest->tiene_instalaciones,
            'paquete_monitoreo' => $jsonRequest->paquete_monitoreo,
            'ultimo_service_hecho' => $jsonRequest->ultimo_service_hecho,
            'modelo_pantalla' => $jsonRequest->modelo_pantalla,
            'modelo_pantalla_actualizado' => $jsonRequest->modelo_pantalla_actualizado,
            'modelo_antena' => $jsonRequest->modelo_antena,
            'modelo_antena_actualizado' => $jsonRequest->modelo_antena_actualizado,
            'tipo_piloto' => $jsonRequest->tipo_piloto,
            'otra_maquina_JD' => $jsonRequest->otra_maquina_JD,
        ]);
        return;
    }

    public function solicitudes_pdf($id)
    {
        $solicitud = Reparacion::find($id);
        $repuestos_faltantes = Repuesto_faltante::where('CodiReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_reparacions = Tecnicos_reparacions::where('id_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        
        $maquina_parada = "Si";
        $tipo_falla = "Intermitente";
        $visita_a_campo = "Campo";
        $tiene_instalaciones = "Si";
        $paquete_monitoreo = "Si";
        $ultimo_service_hecho = "Si";
        $modelo_pantalla_actualizado = "Si";
        $modelo_antena_actualizado = "Si";
        $tipo_piloto = "Integrado";
        $otra_maquina_JD = "Si";
        $pmp_pendientes = "Si";
        $tiene_powergard = "Si";
        $aprobado = "Si";
        if($solicitud->maquina_parada == "0"){
            $maquina_parada = "No";
        }
        if($solicitud->tipo_falla == "Permanente"){
            $tipo_falla = "Permanente";
        }
        if($solicitud->visita_a_campo == "0"){
            $visita_a_campo = "Taller";
        }
        if($solicitud->tiene_instalaciones == "0"){
            $tiene_instalaciones = "No";
        }
        if($solicitud->paquete_monitoreo == "0"){
            $paquete_monitoreo = "No";
        }
        if($solicitud->ultimo_service_hecho == "0"){
            $ultimo_service_hecho = "No";
        }
        if($solicitud->modelo_pantalla_actualizado == "0"){
            $modelo_pantalla_actualizado = "No";
        }
        if($solicitud->modelo_antena_actualizado == "0"){
            $modelo_antena_actualizado = "No";
        }
        if($solicitud->tipo_piloto == "Universal"){
            $tipo_piloto = "Universal";
        }
        if($solicitud->otra_maquina_JD == "0"){
            $otra_maquina_JD = "No";
        }
        if($solicitud->pmp_pendientes == "0"){
            $pmp_pendientes = "No";
        }
        if($solicitud->tiene_powergard == "0"){
            $tiene_powergard = "No";
        }
        if($solicitud->aprobado == "0"){
            $aprobado = "No";
        }

        $data = [
            'razon_social' => $solicitud->razon_social,
            'contacto_cliente' => $solicitud->contacto_cliente,
            'telefono_cliente' => $solicitud->telefono_cliente,
            'horas_de_motor' => $solicitud->horas_de_motor,
            'modelo' => $solicitud->modelo,
            'responsable_relevamiento' => $solicitud->responsable_relevamiento,
            'maquina_parada' => $maquina_parada,
            'descripcion_falla' => $solicitud->descripcion_falla,
            'codigo_diagnostico' => $solicitud->codigo_diagnostico,
            'condiciones_de_ocurrencia' => $solicitud->condiciones_de_ocurrencia,
            'tarea_que_estaba_realizando' => $solicitud->tarea_que_estaba_realizando,
            'tipo_falla' => $tipo_falla,
            'primera_ocurrencia' => $solicitud->primera_ocurrencia,
            'prueba_realizada' => $solicitud->prueba_realizada,
            'visita_a_campo' => $visita_a_campo,
            'donde_se_encuentra' => $solicitud->donde_se_encuentra,
            'tiene_instalaciones' => $tiene_instalaciones,
            'paquete_monitoreo' => $paquete_monitoreo,
            'ultimo_service_hecho' => $ultimo_service_hecho,
            'modelo_pantalla' => $solicitud->modelo_pantalla,
            'modelo_pantalla_actualizado' => $modelo_pantalla_actualizado,
            'modelo_antena' => $solicitud->modelo_antena,
            'modelo_antena_actualizado' => $modelo_antena_actualizado,
            'tipo_piloto' => $tipo_piloto,
            'otra_maquina_JD' => $otra_maquina_JD,
            'trabajo_a_presupuestar' => $solicitud->trabajo_a_presupuestar,
            'horas_a_presupuestar' => $solicitud->horas_a_presupuestar,
            'pmp_pendientes' => $pmp_pendientes,
            'tiene_powergard' => $tiene_powergard,
            'numero_cpres' => $solicitud->numero_cpres,
            'aprobado' => $aprobado,
            'observaciones' => $solicitud->observaciones,     
            'fecha' => $solicitud->fecha,         
            'cor' => $solicitud->cor,
            'firma' => $solicitud->firma,
            'cant_tecnicos' => count($tecnicos),
            'cant_repuestos' => count($repuestos_faltantes),
        ];

        for ($i = 1; $i <= count($tecnicos); $i++) { 
            $data['tecnico' . $i] = $tecnicos[$i - 1]->name . " " . $tecnicos[$i - 1]->last_name;
        }

        for ($i = 1; $i <= count($repuestos_faltantes); $i++) { 
            $data['repuesto' . $i] = $repuestos_faltantes[$i - 1];
        }
        
        $pdf = PDF::loadView('pdf_plantillas/solicitud', $data);
    
        $nombre_pdf = 'solicitud' . $id . '.pdf';
        return $pdf->download($nombre_pdf);
    }

    public function tarea_taller_pdf($id)
    {
        $reparacion = Taller_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiTallerReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_taller_reparacions = Tecnicos_taller_reparacions::where('id_taller_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_taller_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        
        $garantia = "Si";
        $vendido_sala = "Si";
        if($reparacion->garantia == "0"){
            $garantia = "No";
        }
        if($reparacion->vendido_sala == "0"){
            $vendido_sala = "No";
        }

        $data = [
            'cor' => $reparacion->cor,
            'cliente' => $reparacion->cliente,
            'vendido_sala' => $vendido_sala,
            'garantia' => $garantia,
            'fecha_ingreso' => $reparacion->fecha_ingreso,
            'fecha_salida' => $reparacion->fecha_salida,
            'numero_chasis' => $reparacion->numero_chasis,
            'horas_de_motor' => $reparacion->horas_de_motor,
            'horas_de_trilla' => $reparacion->horas_de_trilla,
            'firma_tecnico' => $reparacion->firma_tecnico,
            'firma_cliente' => $reparacion->firma_cliente,
            'cant_tecnicos' => count($tecnicos),
            'cant_tareas' => count($tareas_reparacion)
        ];

        for ($i = 1; $i <= count($tecnicos); $i++) { 
            $data['tecnico' . $i] = $tecnicos[$i - 1]->name . " " . $tecnicos[$i - 1]->last_name;
        }

        for ($i = 1; $i <= count($tareas_reparacion); $i++) { 
            $data['tarea' . $i] = $tareas_reparacion[$i - 1];
        }

        $pdf = PDF::loadView('pdf_plantillas/tarea_taller', $data);
    
        $nombre_pdf = 'tarea_taller' . $id . '.pdf';
        return $pdf->download($nombre_pdf);
    }

    public function tarea_campo_pdf($id)
    {
        $reparacion = Campo_reparacion::find($id);
        $tareas_reparacion = Tarea_reparacion::where('CodiCampoReparacions', $id)->orderBy('created_at')->get();
        $observaciones_reparacion = Observaciones_reparacion::where('CodiCampoObsReparacions', $id)->orderBy('created_at')->get();
        $tecnicos_campo_reparacions = Tecnicos_campo_reparacions::where('id_campo_reparacions', $id)->orderBy('created_at')->get();
        $id_users = [];
        foreach ($tecnicos_campo_reparacions as $tecnico) {
            array_push($id_users ,$tecnico->id_user);
        }
        $tecnicos = User::whereIn('id', $id_users)->select('name', 'last_name')->get();
        
        $garantia = "Si";
        if($reparacion->garantia == "0"){
            $garantia = "No";
        }

        $data = [
            'cor' => $reparacion->cor,
            'cliente' => $reparacion->cliente,
            'garantia' => $garantia,
            'numero_chasis' => $reparacion->numero_chasis,
            'fecha_ingreso' => $reparacion->fecha_ingreso,
            'horas_de_motor' => $reparacion->horas_de_motor,
            'horario_salida_agencia' => $reparacion->horario_salida_agencia,
            'horario_llegada_campo' => $reparacion->horario_llegada_campo,
            'horario_salida_campo' => $reparacion->horario_salida_campo,
            'horario_llegada_agencia' => $reparacion->horario_llegada_agencia,
            'firma_tecnico' => $reparacion->firma_tecnico,
            'firma_cliente' => $reparacion->firma_cliente,
            'cant_tecnicos' => count($tecnicos),
            'cant_tareas' => count($tareas_reparacion),
            'cant_observaciones' => count($observaciones_reparacion)
        ];

        for ($i = 1; $i <= count($tecnicos); $i++) { 
            $data['tecnico' . $i] = $tecnicos[$i - 1]->name . " " . $tecnicos[$i - 1]->last_name;
        }

        for ($i = 1; $i <= count($tareas_reparacion); $i++) { 
            $data['tarea' . $i] = $tareas_reparacion[$i - 1];
        }

        for ($i = 1; $i <= count($observaciones_reparacion); $i++) { 
            $data['reclamo' . $i] = $observaciones_reparacion[$i - 1];
        }
        
        $pdf = PDF::loadView('pdf_plantillas/tarea_campo', $data);
    
        $nombre_pdf = 'tarea_campo' . $id . '.pdf';
        return $pdf->download($nombre_pdf);
    }
}