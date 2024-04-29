<?php

namespace App\Http\Controllers;

use App\noticia;
use App\interaccion;
use App\img_noticia;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationsService;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{

    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Gate::authorize('haveaccess','noticia.index');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Noticias']);
        $rutavolver = route('home');
        $noticias = Noticia::orderBy('id','desc')->paginate(20);
        return view('noticia.index', compact('noticias','rutavolver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','noticia.create');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Noticias']);
        $rutavolver = route('noticia.index');
        return view('noticia.create',compact('rutavolver'));
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
            'titulo' => 'required',
        ]);

        $noticias = Noticia::create($request->all());

        foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
        {
            //Validamos que el archivo exista
            if($_FILES["archivo"]["name"][$key]) {
                $filename = time().'1'.rand().$_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo + random
                $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                
                $directorio = public_path('img/noticias/'); //Declaramos un  variable con la ruta donde guardaremos los archivos
                
                //Validamos si la ruta de destino existe, en caso de no existir la creamos
                if(!file_exists($directorio)){
                    mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                }
                
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                if(move_uploaded_file($source, $target_path)) {	
                }
                closedir($dir); //Cerramos el directorio de destino

                //Guardamos la ruta de los archivos en la tabla calendario_archivos
                $archivo = Img_noticia::create(['id_noticia'=>$noticias->id, 'nombre'=>$filename]);

            }
        }

        $notificationData = [
            'title' => 'SALA - Noticias',
            'body' => ''.$noticias->titulo.'',
            'path' => '/noticia',
        ];
        $this->notificationsService->sendToUser('3', $notificationData);

        return redirect()->route('noticia.index')->with('status_success', 'Noticia creada con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(noticia $noticia)
    {
        //
        Gate::authorize('haveaccess','noticia.show');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Noticias']);
        $rutavolver = route('noticia.index');
        return view('noticia.view', compact('noticia','rutavolver'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        Gate::authorize('haveaccess','noticia.edit');
        Interaccion::create(['id_user' => auth()->id(), 'enlace' => $_SERVER["REQUEST_URI"], 'modulo' => 'Noticias']);
        $rutavolver = route('noticia.index');
        $noticia = Noticia::where('id',$id)->first();
        return view('noticia.edit', compact('noticia','rutavolver'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
      
        Gate::authorize('haveaccess','noticia.edit');
        request()->validate([
            'titulo' => 'required',
        ]);

        $noticia = Noticia::where('id',$id)->first();

        $noticia->update($request->all());

        return redirect()->route('noticia.index')->with('status_success', 'Noticia modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Gate::authorize('haveaccess','noticia.destroy');
        $noticia = Noticia::where('id',$id)->first();
        $imagenes = Img_noticia::where('id_noticia',$noticia->id)->get();
        foreach ($imagenes as $imagen) {
            $imagen->delete();
        }
        $noticia->delete();
        return redirect()->route('noticia.index')->with('status_success', 'Noticia eliminada con exito');
    }
}
