@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Objetivo</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">
                            <div class="form-group row">
                                <label for="OrgaMail" class="col-md-4 col-form-label text-md-right">{{ __('Organizacion') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('OrgaMail') is-invalid @enderror" data-live-search="true" name="OrgaMail" id="OrgaMail" value="{{ old('OrgaMail') }}" title="Seleccionar organizacion" disabled autofocus> 
                                        
                                        @foreach($organizaciones as $organizacion)
                                        <option value="{{ $organizacion->id }}" data-subtext="{{ $organizacion->InscOrga == 'SI' ? 'Monitoreado':'' }}"
                                            @isset($mail->organizacions->NombOrga)
                                                    @if($organizacion->NombOrga == $mail->organizacions->NombOrga)
                                                        selected
                                                    @endif
                                            @endisset
                                        >{{ $organizacion->NombOrga }} </option>
                                        @endforeach
                                       
                                </select>
                                    @error('OrgaMail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="UserMail" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('UserMail') is-invalid @enderror" data-live-search="true" name="UserMail" id="UserMail" value="{{ old('UserMail') }}" title="Seleccionar usuario" disabled autofocus> 
                                        
                                        @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}" data-subtext="{{ $usuario->NombOrga }}"
                                                @isset($mail->users->id)
                                                    @if($usuario->id == $mail->users->id)
                                                        selected
                                                    @endif
                                            @endisset
                                            >{{ $usuario->last_name }} {{ $usuario->name }} </option>
                                        @endforeach
                                       
                                </select>
                                    @error('UserMail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="TipoMail" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de objetivo') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('TipoMail') is-invalid @enderror" data-live-search="true" name="TipoMail" id="TipoMail" value="{{ old('TipoMail') }}" title="Seleccionar tipo de mail" disabled autofocus>     
                                    @isset($mail->TipoMail)
                                        @if ($mail->TipoMail == "Para")
                                            <option value="Para" selected>Para:</option> 
                                        @elseif($mail->TipoMail == "Copia")
                                            <option value="Copia" selected>CC:</option> 
                                        @elseif($mail->TipoMail == "Copia oculta") 
                                            <option value="Copia oculta" selected>CCO:</option> 
                                        @endif 
                                    @endisset  
                                        <option value="Para">Para:</option> 
                                        <option value="Copia">CC:</option> 
                                        <option value="Copia oculta">CCO:</option>
                                </select>
                                    @error('TipoMail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="TiInMail" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de objetivo') }} *</label>
                                <div class="col-md-6">
                                <select class="selectpicker form-control @error('TiInMail') is-invalid @enderror" data-live-search="true" name="TiInMail" id="TiInMail" value="{{ old('TiInMail') }}" title="Seleccionar tipo de informe" disabled autofocus>     
                                    @isset($mail->TiInMail)
                                        <option value="{{ $mail->TiInMail }}" selected>{{ $mail->TiInMail }}</option> 
                                    @endisset
                                    <option value="Eficiencia de maquina">Eficiencia de maquina</option>   
                                    <option value="Notificaciones de alertas">Notificaciones de alertas</option>  
                                    <option value="Agronomico">Agronomico</option>    
                                </select>
                                    @error('TiInMail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            <a class="btn btn-light btn-block" href="{{ route('mail.index') }}">Atras</a>
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','mail.edit')
                            <a href="{{ route('mail.edit',$mail->id) }}" class="btn btn-warning btn-block">Editar</a>
                            @endcan
                            </div>
                            <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                            @can('haveaccess','mail.destroy')
                            <form action="{{ route('mail.destroy',$mail->id) }}" method="post">
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