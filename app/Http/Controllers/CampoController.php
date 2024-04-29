<?php

namespace App\Http\Controllers;

use App\campo;
use App\organizacion;
use App\interaccion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class CampoController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','campo.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Campos']);
        $filtro="";
        $busqueda="";
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $campos = Campo::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            if ($organizacion->NombOrga == "Sala Hnos") {
                $campos = Campo::select('organizacions.NombOrga','campos.op_fin','organizacions.CodiOrga')
                                ->join('organizacions','campos.org_id','=','organizacions.CodiOrga')
                                ->whereIn('campos.op_fin', function ($sub) {
                                    $sub->selectRaw('max(campos.op_fin)')->from('campos')->groupBy('campos.op_fin'); // <---- la clave
                                })
                                ->distinct('campos.org_id')
                                ->orderBy('campos.op_fin','desc')->paginate(20);
            } elseif($organizacion->NombOrga == "Sala Hnos Demo"){
                $campos = Campo::select('organizacions.NombOrga','campos.op_fin','organizacions.CodiOrga')
                                ->join('organizacions','campos.org_id','=','organizacions.CodiOrga')
                                ->where('org_id','355244')
                                ->whereIn('campos.op_fin', function ($sub) {
                                    $sub->selectRaw('max(campos.op_fin)')->from('campos')->groupBy('campos.op_fin'); // <---- la clave
                                })
                                ->distinct('campos.org_id')
                                ->orderBy('campos.op_fin','desc')->paginate(20);
            }
            else{
                $campos = Campo::select('organizacions.NombOrga','campos.op_fin','organizacions.CodiOrga')
                                ->join('organizacions','campos.org_id','=','organizacions.CodiOrga')
                                ->where('org_id',$organizacion->CodiOrga)
                                ->whereIn('campos.op_fin', function ($sub) {
                                    $sub->selectRaw('max(campos.op_fin)')->from('campos')->groupBy('campos.op_fin'); // <---- la clave
                                })
                                ->distinct('campos.org_id')
                                ->orderBy('campos.op_fin','desc')->paginate(20);
            }
            
        }
        
        return view('campo.index', compact('campos','filtro','busqueda','organizacion'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function show(Campo $campo)
    {
        Gate::authorize('haveaccess','campo.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Campos']);
        $rutavolver = route('campo.index');
        //consultas SUM para cantidad de hectareas, lotes, y rinde promedio
        $trabajos = Campo::select('op_type')
                        ->where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id]])
                        ->distinct('op_type')->get();
    
        return view('campo.view', compact('campo','rutavolver','trabajos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campo $campo)
    {
        Gate::authorize('haveaccess','campo.destroy');
        $campo->delete();
        return redirect()->route('campo.index')->with('status_success', 'Informe diario eliminado con exito');
    }

}
