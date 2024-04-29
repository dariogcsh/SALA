@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>ideaproyecto</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="descripción" class="col-md-4 col-form-label text-md-right">{{ __('Descripcion') }} </label>
    
                                <div class="col-md-6">
                                    <textarea id="descripción" class="form-control-textarea @error('descripción') is-invalid @enderror" name="descripción" disabled autocomplete="descripción" autofocus>{{ isset($ideaproyecto->descripcion)?$ideaproyecto->descripcion:old('descripcion') }}</textarea>
    
                                    @error('descripción')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                <a class="btn btn-light btn-block" href="{{ route('ideaproyecto.index') }}">Atras</a>
                                </div>
                                <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                @can('haveaccess','ideaproyecto.edit')
                                <a href="{{ route('ideaproyecto.edit',$ideaproyecto->id) }}" class="btn btn-warning btn-block">Editar</a>
                                @endcan
                                </div>
                                <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                @can('haveaccess','ideaproyecto.destroy')
                                <form action="{{ route('ideaproyecto.destroy',$ideaproyecto->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-dark btn-block" onclick="return confirm('¿Seguro que desea eliminar el registro?');">Eliminar</button>
                                </form>
                                @endcan
                                </div> 
                                <div class="col-xs-12 col-md-3" style="margin-bottom:5px;">
                                    @can('haveaccess','ideaproyecto.edit')
                                        <a href="{{ route('ideaproyecto.pasarProyecto',$ideaproyecto->id) }}" class="btn btn-warning ">Pasar a proyecto</a>
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