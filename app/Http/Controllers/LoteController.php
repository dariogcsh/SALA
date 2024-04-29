<?php

namespace App\Http\Controllers;

use App\lote;
use App\granja;
use App\cliente;
use App\interaccion;
use App\organizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule; 

class LoteController extends Controller
{
    public function menu()
    {
        return view('lote.menu');
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','lote.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Lotes']);
        $rutavolver = route('internoconfiguracion');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        if ($organizacion->NombOrga == "Sala Hnos"){
            $lotes = Lote::select('organizacions.NombOrga','lotes.id','lotes.name', 'lotes.client', 'lotes.farm')
                        ->join('organizacions','lotes.org_id','=','organizacions.CodiOrga')
                        ->orderBy('lotes.name','desc')->paginate(20);
        }else{
            $lotes = Lote::select('organizacions.NombOrga','lotes.id','lotes.name', 'lotes.client', 'lotes.farm')
            ->join('organizacions','lotes.org_id','=','organizacions.CodiOrga')
            ->where('organizacions.id',$organizacion->id)
            ->orderBy('lotes.name','desc')->paginate(20);

        }
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        return view('lote.index', compact('lotes','rutavolver','organizacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','lote.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Lotes']);
        $rutavolver = route('lote.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        return view('lote.create',compact('rutavolver','organizacion','organizaciones'));
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
        $org_id = $request->get('org_id');
        $cliente = $request->get('client');
        $granja = $request->get('farm');
        request()->validate([
            'name' => ['required',Rule::unique('lotes')->where(function ($query) use($granja, $cliente, $org_id) {
                return $query->where([['farm', $granja], ['client', $cliente], ['org_id', $org_id]]);
                })
            ],
        ]);
        $lotes = Lote::create($request->all());
        return redirect()->route('lote.index')->with('status_success', 'Lote creado con exito');
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $data = Lote::where($select, $value)->get();
        
        $output = '<option value="">Seleccionar</option>';
        foreach ($data as $row)
        {
            $output .='<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        echo $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(lote $lote)
    {
        //
        Gate::authorize('haveaccess','lote.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Lotes']);
        $rutavolver = route('lote.index');
        $organizacionshow = Organizacion::where('id',$lote->org_id)->first();
        return view('lote.view', compact('lote','rutavolver','organizacionshow','cliente','granja'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit(lote $lote)
    {
        //
        Gate::authorize('haveaccess','lote.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Lotes']);
        $rutavolver = route('lote.index');
        $organizacion = Organizacion::where('id',auth()->user()->CodiOrga)->first();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $organizacionshow = Organizacion::where('id',$lote->org_id)->first();
        return view('lote.edit', compact('lote','rutavolver','organizacion','organizaciones','organizacionshow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lote $lote)
    {
        //
        Gate::authorize('haveaccess','lote.edit');
        $org_id = $request->get('org_id');
        $cliente = $request->get('client');
        $granja = $request->get('farm');
        request()->validate([
            'name' => ['required',Rule::unique('lotes')->where(function ($query) use($granja, $cliente, $org_id) {
                return $query->where([['farm', $granja], ['client', $cliente], ['org_id', $org_id]]);
                })->ignore($lote->id)
            ],
        ]);
        $lote->update($request->all());
        return redirect()->route('lote.index')->with('status_success', 'Lote modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy(lote $lote)
    {
        Gate::authorize('haveaccess','lote.destroy');
        $lote->delete();
        return redirect()->route('lote.index')->with('status_success', 'Lote eliminado con exito');
    }
}
