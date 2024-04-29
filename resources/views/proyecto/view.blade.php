@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Proyecto</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row" hidden>
                                <label for="ideaproyecto" class="col-md-4 col-form-label text-md-right">{{ __('ID de propuesta de proyecto') }}</label>
    
                                <div class="col-md-6">
                                    <input id="ideaproyecto" type="text" class="form-control-textarea @error('ideaproyecto') is-invalid @enderror" name="NombAnte" value="{{ isset($ideaproyecto->id)?$ideaproyecto->id:old('id') }}" autocomplete="ideaproyecto" disabled autofocus>
    
                                    @error('ideaproyecto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="categoria" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('categoria') is-invalid @enderror" name="categoria" required autocomplete="categoria" disabled autofocus>
                                    @isset($proyecto->categoria)
                                        <option value="{{ $proyecto->categoria }}">{{ $proyecto->categoria }}</option>
                                    @else
                                        <option value="">Seleccionar categoria</option>
                                    @endisset
                                        <option value="Soluciones Integrales">Soluciones Integrales</option>
                                        <option value="App Sala Hnos">App Sala Hnos</option>
                                </select>
    
                                    @error('categoria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Descripción del proyecto') }} *</label>
    
                                <div class="col-md-6">
                                    <textarea id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="6" name="descripcion" required autocomplete="descripcion" disabled autofocus>{{ isset($proyecto->descripcion)?$proyecto->descripcion:old('descripcion') }}</textarea>
    
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="inicio" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio de proyecto') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="inicio" type="date" class="form-control @error('inicio') is-invalid @enderror" name="inicio" value="{{ isset($proyecto->inicio)?$proyecto->inicio:old('inicio') }}" disabled autofocus>
                            
                                    @error('inicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="finalizacion" class="col-md-4 col-form-label text-md-right">{{ __('Fecha estimada de finalización de proyecto') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="finalizacion" type="date" class="form-control @error('finalizacion') is-invalid @enderror" name="finalizacion" value="{{ isset($proyecto->finalizacion)?$proyecto->finalizacion:old('finalizacion') }}" disabled autofocus>
                            
                                    @error('finalizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="horas" class="col-md-4 col-form-label text-md-right">{{ __('FHoras estimadas') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="horas" type="text" class="form-control @error('horas') is-invalid @enderror" name="horas" value="{{ isset($proyecto->horas)?$proyecto->horas:old('horas') }}" disabled autofocus>
                            
                                    @error('horas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="id_responsable" class="col-md-4 col-form-label text-md-right">{{ __('Responsables') }} *</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_responsable') is-invalid @enderror" multiple id="id_responsable" name="id_responsable[]" disabled autofocus>
                                        @isset($responsables)
                                            @foreach($responsables as $responsable)
                                                    <option value="{{ $responsable->id }}" selected>{{ $responsable->name }} {{ $responsable->last_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                    @error('id_responsable')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="presupuesto" class="col-md-4 col-form-label text-md-right">{{ __('Presupuesto (US$)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="presupuesto" type="number" class="form-control @error('presupuesto') is-invalid @enderror" value="{{ isset($proyecto->presupuesto)?$proyecto->presupuesto:old('presupuesto') }}" name="presupuesto" disabled autocomplete="presupuesto" autofocus>
    
                                    @error('presupuesto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Avance (%)') }}</label>
    
                                <div class="col-md-6">
                                    <input id="estado" type="number" class="form-control @error('estado') is-invalid @enderror" value="{{ isset($proyecto->estado)?$proyecto->estado:old('estado') }}" name="estado" autocomplete="estado" disabled autofocus>
    
                                    @error('estado')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('proyecto.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','proyecto.edit')
                            <a href="{{ route('proyecto.edit',$proyecto->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','proyecto.destroy')
                            <form action="{{ route('proyecto.destroy',$proyecto->id) }}" method="post">
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