<?php

namespace App\Http\Controllers;

use App\imgusado;
use App\usado;
use App\User;
use App\sucursal;
use Illuminate\Http\Request;

class ImgusadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_usado = $request->get('id_usado');
        $imagenes = Imgusado::where('id_usado',$id_usado)->get();
        $i=1;
        foreach ($imagenes as $imagen) {
            $imgprev[$i] = $imagen->ruta;
            $idprev[$i] = $imagen->id;
            $i++;
        }
        if($request->hasFile("img1")){
            $imagen = $request->file('img1');
            if(isset($imgprev[1])){
                $nombre = $imgprev[1];
                $imgstore1 = Imgusado::where('id',$idprev[1])->first();
                $imgstore1->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'1'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore1 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img1->move($destino, $nombre);
        }

        if($request->hasFile("img2")){
            $imagen = $request->file('img2');
            if(isset($imgprev[2])){
                $nombre = $imgprev[2];
                $imgstore2 = Imgusado::where('id',$idprev[2])->first();
                $imgstore2->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'2'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore2 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img2->move($destino, $nombre);
        }

        if($request->hasFile("img3")){
            $imagen = $request->file('img3');
            if(isset($imgprev[3])){
                $nombre = $imgprev[3];
                $imgstore3 = Imgusado::where('id',$idprev[3])->first();
                $imgstore3->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'3'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore3 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img3->move($destino, $nombre);
        }

        if($request->hasFile("img4")){
            $imagen = $request->file('img4');
            if(isset($imgprev[4])){
                $nombre = $imgprev[4];
                $imgstore4 = Imgusado::where('id',$idprev[4])->first();
                $imgstore4->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'4'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore4 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img4->move($destino, $nombre);
        }

        if($request->hasFile("img5")){
            $imagen = $request->file('img5');
            if(isset($imgprev[5])){
                $nombre = $imgprev[5];
                $imgstore5 = Imgusado::where('id',$idprev[5])->first();
                $imgstore5->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'5'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore5 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img5->move($destino, $nombre);
        }

        if($request->hasFile("img6")){
            $imagen = $request->file('img6');
            if(isset($imgprev[6])){
                $nombre = $imgprev[6];
                $imgstore6 = Imgusado::where('id',$idprev[6])->first();
                $imgstore6->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'6'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore6 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img6->move($destino, $nombre);
        }

        if($request->hasFile("img7")){
            $imagen = $request->file('img7');
            if(isset($imgprev[7])){
                $nombre = $imgprev[7];
                $imgstore7 = Imgusado::where('id',$idprev[7])->first();
                $imgstore7->update(['ruta' => $nombre]);
            } else {
                $nombre = time().'7'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore7 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img7->move($destino, $nombre);
        }

        if($request->hasFile("img8")){
            $imagen = $request->file('img8');
            if(isset($imgprev[8])){
                $nombre = $imgprev[8];
                $imgstore8 = Imgusado::where('id',$idprev[8])->first();
                $imgstore8->update(['ruta' => $nombre]);    
            } else {
                $nombre = time().'8'.rand().'.'.$imagen->getClientOriginalExtension();
                $imgstore8 = Imgusado::create(['id_usado' => $id_usado,'ruta' => $nombre]);
            }
            $destino = public_path('img/usados/');
            $request->img8->move($destino, $nombre);
        }

        if(isset( $imgprev[1])){
            $paso = 5;
            $usado = Usado::where('id',$id_usado)->first();

            $sucursales = Sucursal::get();
            $vendedores = User::select('users.id', 'users.name', 'users.last_name')
                                ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                                ->where('puesto_empleados.NombPuEm','Vendedor')
                                ->orWhere('puesto_empleados.NombPuEm','Gerente comercial')
                                ->orWhere('puesto_empleados.NombPuEm','Gerente de usados')
                                ->orderBy('users.last_name')
                                ->get();
       
            $formimage = "paso5";
 
            return view('usado.edit', compact('usado','paso','imagenes','sucursales','vendedores','formimage'));
        } else {
            return redirect()->route('usado.createUpdate', $id_usado);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\imgusado  $imgusado
     * @return \Illuminate\Http\Response
     */
    public function show(imgusado $imgusado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\imgusado  $imgusado
     * @return \Illuminate\Http\Response
     */
    public function edit(imgusado $imgusado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\imgusado  $imgusado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, imgusado $imgusado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\imgusado  $imgusado
     * @return \Illuminate\Http\Response
     */
    public function destroy(imgusado $imgusado)
    {
        //
    }
}
