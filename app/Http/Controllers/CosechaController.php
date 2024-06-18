<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MiImportador;
use Illuminate\Support\Facades\Gate;
use App\cosecha;
use App\organizacion;
use App\interaccion;
use Carbon\Carbon;

class CosechaController extends Controller
{
    public function importar(Request $request)
    {
        // Validar que un archivo ha sido enviado
        $request->validate([
            'archivo_excel' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        $archivo = $request->file('archivo_excel'); // Asumiendo que has recibido el archivo desde un formulario
        //Es necesario vaciar la tabla para incorporar los datos ya que no se puede evaluar si un registro ya existe 
        //debido a que no disponemos de ningun ID en esta información y los datos pueden cambiar entre una carga y otra
        //En este caso no se vacia por completo sino lo del ultimo año, para conservar los datos de años anteriores.
        $fecha_hoy = Carbon::today();
        $año = $fecha_hoy->format('Y');
        Cosecha::where([['fin','>=',$año.'-01-01'],['fin','<=',$año.'-12-31']])->delete();
        Excel::import(new MiImportador, $archivo);
        return redirect()->route('internosoluciones')->with('status_success', 'Datos importados correctamente');
    }

    public function create()
    {
        Gate::authorize('haveaccess','cosecha.create');
        $rutavolver = route('internosoluciones');
        return view('cosecha.create',compact('rutavolver'));
    }

    public function index(Request $request)
    {
        Gate::authorize('haveaccess','cosecha.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Agronomico']);
        $filtro="";
        $busqueda="";
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if($request->buscarpor){
            $tipo = $request->get('tipo');
            $busqueda = $request->get('buscarpor');
            $variablesurl=$request->all();
            $cosechas = Cosecha::Buscar($tipo, $busqueda)->paginate(20)->appends($variablesurl);
            $filtro = "SI";
        } else{
            if ($organizacion->NombOrga == "Sala Hnos") {
                $cosechas = Cosecha::select('organizacion','fin')
                                ->whereIn('cosechas.fin', function ($sub) {
                                    $sub->selectRaw('max(cosechas.fin)')->from('cosechas')->groupBy('cosechas.fin'); // <---- la clave
                                })
                                ->distinct('cosechas.organizacion')
                                ->orderBy('cosechas.fin','desc')->paginate(20);
            } elseif($organizacion->NombOrga == "Sala Hnos Demo"){
                $cosechas = Cosecha::select('organizacion','fin')
                                ->where('organizacion','Sala Hnos Demo')
                                ->whereIn('cosechas.fin', function ($sub) {
                                    $sub->selectRaw('max(cosechas.fin)')->from('cosechas')->groupBy('cosechas.fin'); // <---- la clave
                                })
                                ->distinct('cosechas.organizacion')
                                ->orderBy('cosechas.fin','desc')->paginate(20);
            }
            else{
                $cosechas = Cosecha::select('organizacion','fin')
                                ->where('organizacion',$organizacion->NombOrga)
                                ->whereIn('cosechas.fin', function ($sub) {
                                    $sub->selectRaw('max(cosechas.fin)')->from('cosechas')->groupBy('cosechas.fin'); // <---- la clave
                                })
                                ->distinct('cosechas.organizacion')
                                ->orderBy('cosechas.fin','desc')->paginate(20);
            }
            
        }
        
        return view('cosecha.index', compact('cosechas','filtro','busqueda','organizacion'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cosecha  $cosecha
     * @return \Illuminate\Http\Response
     */
    public function show(Cosecha $cosecha)
    {
        Gate::authorize('haveaccess','cosecha.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Agronomico']);
        $rutavolver = route('cosecha.index');
        //consultas SUM para cantidad de hectareas, lotes, y rinde promedio
        $cultivos = Cosecha::where([['fin',$cosecha->fin], ['organizacion', $cosecha->organizacion]])
                            ->groupBy('cultivo')
                            ->get();

        return view('cosecha.view', compact('cosecha','rutavolver','cultivos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cosecha  $cosecha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cosecha $cosecha)
    {
        Gate::authorize('haveaccess','cosecha.destroy');
        $cosecha->delete();
        return redirect()->route('cosecha.index')->with('status_success', 'Informe diario eliminado con exito');
    }

}
