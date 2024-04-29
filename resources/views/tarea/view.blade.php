@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Antena</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">

                            <div class="form-group row">
                                <label for="NombOrga" class="col-md-4 col-form-label text-md-right">{{ __('Organización') }}</label>

                                <div class="col-md-6">
                                    <input id="NombOrga" type="text" class="form-control @error('NombOrga') is-invalid @enderror" name="NombOrga" value="{{ isset($tarea->organizacions->NombOrga)?$tarea->organizacions->NombOrga:old('NombOrga') }}" disabled autofocus>

                                    @error('NombOrga')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                                
                            <div class="form-group row">
                                <label for="NumSMaq" class="col-md-4 col-form-label text-md-right">{{ __('NumSMaq') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="NumSMaq" type="text" class="form-control @error('nseriemaq') is-invalid @enderror" name="NumSMaq" value="{{ isset($tarea->nseriemaq)?$tarea->nseriemaq:old('nseriemaq') }}" disabled autofocus>
    
                                    @error('NumSMaq')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                             
                            
    
                            <div class="form-group row">
                                <label for="ncor" class="col-md-4 col-form-label text-md-right">{{ __('N° COR') }}</label>
    
                                <div class="col-md-6">
                                    <input id="ncor" type="number" class="form-control @error('ncor') is-invalid @enderror" name="ncor" value="{{ isset($tarea->ncor)?$tarea->ncor:old('ncor') }}" disabled autofocus>
    
                                    @error('ncor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="descripcion" class="col-md-4 col-form-label text-md-right">{{ __('Tareas') }} *</label>
    
                                <div class="col-md-6">
                                    <textarea id="descripcion" rows="5" class="form-control-textarea @error('descripcion') is-invalid @enderror" name="descripcion" disabled autofocus>{{ isset($tarea->descripcion)?$tarea->descripcion:old('descripcion') }}</textarea>
    
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label for="id_tecnico" class="col-md-4 col-form-label text-md-right">{{ __('Técnico') }}</label>
    
                                <div class="col-md-6">
                                    <select class="form-control @error('id_tecnico') is-invalid @enderror" multiple id="id_tecnico" name="id_tecnico[]" disabled autofocus>
                                            @isset($tecnicos)
                                                @foreach($tecnicos as $tecnico)
                                                    <option value="{{ $tecnico->id }}">{{ $tecnico->name }} {{ $tecnico->last_name }}</option>
                                                @endforeach
                                            @endisset
                                    </select>
                                    @error('id_tecnico')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="ubicacion" class="col-md-4 col-form-label text-md-right">{{ __('Ubicación') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="ubicacion" type="text" class="form-control @error('ubicacion') is-invalid @enderror" name="ubicacion" value="{{ isset($tarea->ubicacion)?$tarea->ubicacion:old('ubicacion') }}" disabled autofocus>
    
                                    @error('ubicacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="prioridad" class="col-md-4 col-form-label text-md-right">{{ __('Prioridad') }}</label>
                                
                                <div class="col-md-6">
                                    <input id="prioridad" type="text" class="form-control @error('prioridad') is-invalid @enderror" name="prioridad" value="{{ isset($tarea->prioridad)?$tarea->prioridad:old('prioridad') }}" disabled autofocus>
    
                                    @error('prioridad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="fechaplan" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de inicio tarea') }}</label>
                            
                                <div class="col-md-6">
                                    <input id="fechaplan" type="date" class="form-control @error('fechaplan') is-invalid @enderror" name="fechaplan" value="{{ isset($tarea->fechaplan)?$tarea->fechaplan:old('fechaplan') }}" disabled autofocus>
                            
                                    @error('fechaplan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="turno" class="col-md-4 col-form-label text-md-right">{{ __('Turno') }}</label>
                                
                                <div class="col-md-6">
                                    <select class="form-control @error('turno') is-invalid @enderror" id="turno" name="turno" value="{{ old('turno') }}" disabled autofocus> 
                                        @isset($tarea->turno)
                                            <option value="{{ $tarea->turno }}">{{ $tarea->turno }}</option>
                                        @endisset
                                    </select>
                                    @error('turno')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <br>
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('tarea.ihistorial') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','tarea.edit')
                            <a href="{{ route('tarea.edit',$tarea->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','tarea.destroy')
                            <form action="{{ route('tarea.destroy',$tarea->id) }}" method="post">
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