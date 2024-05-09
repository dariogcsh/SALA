<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MiImportador;
use Illuminate\Support\Facades\Gate;

class CosechaController extends Controller
{
    public function importar(Request $request)
    {
        // Validar que un archivo ha sido enviado
        $request->validate([
            'archivo_excel' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        $archivo = $request->file('archivo_excel'); // Asumiendo que has recibido el archivo desde un formulario
        Excel::import(new MiImportador, $archivo);
        return redirect()->route('internosoluciones')->with('status_success', 'Datos importados correctamente');
    }

    public function create()
    {
        Gate::authorize('haveaccess','cosecha.create');
        $rutavolver = route('internosoluciones');
        return view('cosecha.create',compact('rutavolver'));
    }

}
