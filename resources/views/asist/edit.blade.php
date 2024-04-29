@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Cambiar estado a la asistencia</h2></div>

                    <div class="card-body">
                        <form action="{{ url('/asist/'.$asist->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <div class="container">
                                @include('custom.message')
                                    <div class="form-group row">
                                        <label for="ResuAsis" class="col-md-4 col-form-label text-md-right">Estado</label>

                                        <div class="col-md-6">
                                        <select class="form-control @error('ResuAsis') is-invalid @enderror" name="ResuAsis" id="ResuAsis" onchange="mostrarMotivo();" required autofocus>
                                                <option value="EN GESTION - MAQUINA PARADA">EN GESTION - MAQUINA PARADA</option> 
                                                <option value="EN GESTION - MAQUINA FUNCIONANDO">EN GESTION - MAQUINA FUNCIONANDO</option>    
                                                <option value="SI">FINALIZADO Y SOLUCIONADO</option>
                                                <option value="NO">FINALIZADO NO SOLUCIONADO</option>
                                                <option value="PRESUPUESTADO">PRESUPUESTADO</option>
                                                <option value="DERIVACION A CAMPO">DERIVACIÓN A CAMPO</option>
                                                <option value="DERIVACION A TALLER">DERIVACION A TALLER</option>
                                                <option value="ASISTENCIA RECHAZADA">ASISTENCIA RECHAZADA</option>
                                        </select>
                                            @error('ResuAsis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="motivoRechazo" style="display: none;">
                                        <div class="form-group row">
                                            <label for="MotiAsis" class="col-md-4 col-form-label text-md-right">Motivo</label>

                                            <div class="col-md-6">
                                            <select class="form-control" name="MotiAsis" id="MotiAsis" autofocus>
                                                    <option value="">Seleccionar</option>  
                                                    <option value="Por presupuesto">Por presupuesto</option>    
                                                    <option value="Por el turno asignado">Por el turno asignado</option>
                                                    <option value="Asistencia no releelevante">Asistencia no releelevante</option>
                                                    <option value="Otro">Otro (detallar el motivo en Comentario)</option>
                                            </select>
                                                @error('MotiAsis')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div id="necesitodtac" style="display: none;">
                                        <div class="form-group row">
                                            <label for="dtac" class="col-md-4 col-form-label text-md-right">Se necesito realizar caso D-TAC</label>

                                            <div class="col-md-6">
                                            <select class="form-control" name="dtac" id="dtac" autofocus>
                                                    <option value="">Seleccionar</option>  
                                                    <option value="SI">SI</option>    
                                                    <option value="NO">NO</option>
                                            </select>
                                                @error('dtac')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="ndtac" class="col-md-4 col-form-label text-md-right">{{ __('N° de caso D-TAC') }}</label>
    
                                            <div class="col-md-6">
                                                <input id="ndtac" class="form-control @error('ndtac') is-invalid @enderror" name="ndtac" value="{{ old('ndtac') }}"  autofocus>
                                                @error('ndtac')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="CMinAsis" class="col-md-4 col-form-label text-md-right">{{ __('CMinAsis') }}</label>

                                        <div class="col-md-6">
                                            <input id="CMinAsis" type="number" class="form-control @error('CMinAsis') is-invalid @enderror" name="CMinAsis" value="{{ old('CMinAsis') }}"  placeholder="Ej: 15" autofocus>
                                            @error('CMinAsis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <textarea id="DeReAsis" class="form-control-textarea @error('DeReAsis') is-invalid @enderror" name="DeReAsis" value="{{ old('DeReAsis') }}" placeholder="Comentario (opcional)" rows="6" autofocus></textarea>
                                            @error('DeReAsis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                            <a class="btn btn-light btn-block" href="{{ route('asist.index') }}">Cancelar</a>
                                        </div>
                                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                        </div>
                                        <div class="col-xs-12 col-md-4" style="margin-bottom:5px;">
                                            <button type="submit" class="btn btn-success btn-block">Cambiar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function mostrarMotivo() {
        motivo = document.getElementById("motivoRechazo");
        dtac = document.getElementById("necesitodtac");
        var estado = $('#ResuAsis').val();
        if (estado == "ASISTENCIA RECHAZADA"){
            motivo.style.display='block';
        } else {
            if ((estado == "SI") || (estado == "NO")){
                dtac.style.display='block';
            } else {
            dtac.style.display='none';
            motivo.style.display='none';
            }
        }
    }

</script>
@endsection