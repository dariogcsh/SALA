@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>asistenciatipo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                            <label for="NombTiAs" class="col-md-4 col-form-label text-md-right">{{ __('NombTiAs') }}</label>

                            <div class="col-md-6">
                                <input id="NombTiAs" type="text" class="form-control" name="NombTiAs" value="{{ old('NombTiAs', $asistenciatipo->NombTiAs) }}" disabled>
                            </div>
                            </div> 


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('asistenciatipo.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','asistenciatipo.edit')
                            <a href="{{ route('asistenciatipo.edit',$asistenciatipo->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','asistenciatipo.destroy')
                            <form action="{{ route('asistenciatipo.destroy',$asistenciatipo->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                            </form>
                            @endcan
                            </div> 
                            </div> 
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection