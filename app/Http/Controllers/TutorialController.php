<?php

namespace App\Http\Controllers;

use App\tutorial;
use App\interaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','tutorial.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contenidos']);
        $rutavolver = route('home');
        $tutorials = tutorial::orderBy('id','desc')->get();
        return view('tutorial.index', compact('tutorials','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','tutorial.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contenidos']);
        $rutavolver = route('tutorial.index');
        return view('tutorial.create',compact('rutavolver'));
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
        request()->validate([
            'titulo' => 'required|max:50|unique:tutorials,titulo',
            'url' => 'required',
        ]);
        $tutorials = tutorial::create($request->all());
        return redirect()->route('tutorial.index')->with('status_success', 'Tutorial creado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function show(tutorial $tutorial)
    {
        //
        Gate::authorize('haveaccess','tutorial.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contenidos']);
        $rutavolver = route('tutorial.index');
        return view('tutorial.view', compact('tutorial','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit(tutorial $tutorial)
    {
        //
        Gate::authorize('haveaccess','tutorial.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Contenidos']);
        $rutavolver = route('tutorial.index');
        return view('tutorial.edit', compact('tutorial','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tutorial $tutorial)
    {
        //
        Gate::authorize('haveaccess','tutorial.edit');
        $request->validate([
            'titulo'          => 'required|max:50|unique:tutorials,titulo,'.$tutorial->id,
            'url' => 'required',
        ]);

        $tutorial->update($request->all());
        return redirect()->route('tutorial.index')->with('status_success', 'Tutorial modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy(tutorial $tutorial)
    {
        //
        Gate::authorize('haveaccess','tutorial.destroy');
        $tutorial->delete();
        return redirect()->route('tutorial.index')->with('status_success', 'tutorial eliminado con exito');
    }
}
