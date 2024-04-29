@php
    use App\capacitacion_user;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Detalle de capacitación por colaborador</h2></div>
                <div class="card-body">
                @include('custom.message')
                <input id="id_capacitacion" type="text" hidden name="id_capacitacion" value="{{ $id_capacitacion }}">
                <div class="form-group row float-right">
                    <label for="finalizar" class="col-md-7">{{ __('Finalizar todos') }}</label>

                    <div class="col-md-2">
                        <label class="switch">
                            <input type="checkbox" class="warning" name="finalizar" id="finalizarclass">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                @can('haveaccess','contacto.show')
                <button id="guardarcambios" class="btn btn-success float-left" disabled><b>Guardar cambios</b></button>
                @endcan   
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Capacitación</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Modalidad</th>
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha fin</th>
                            <th scope="col">Horas</th>
                            <th scope="col">Costo</th>
                            <th scope="col">Colaborador</th>
                            <th scope="col">Finalizado</th>
                            <th colspan=3></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($capacitaciones as $capacitacion)                   
                            <tr>
                            <th scope="row">{{ $capacitacion->codigo }}</th>
                            <th scope="row">{{ $capacitacion->nombre }}</th>
                            <th scope="row">{{ $capacitacion->tipo }}</th>
                            <th scope="row">{{ $capacitacion->modalidad }}</th>
                            <th scope="row">{{  date('d/m/Y',strtotime($capacitacion->fechainicio)) }}</th>
                            <th scope="row">{{  date('d/m/Y',strtotime($capacitacion->fechafin)) }}</th>
                            <th scope="row">{{ $capacitacion->horas }}</th>
                            <th scope="row">US$ {{ $capacitacion->costo }}</th>
                            <th scope="row">{{ $capacitacion->name }} {{ $capacitacion->last_name }}</th>
                            <th scope="row" onclick="javascript:cambiocheck({{ $capacitacion->id_user }});">
                                <div class="col-md-2">
                                    <label class="switch">
                                        <input type="checkbox" class="finalizarclass warning" id="{{ 'chk'.$capacitacion->id_user }}" name="{{ $capacitacion->id_user }}"
                                        @if($capacitacion->estado == "Finalizado")
                                            checked
                                        @endif
                                        >
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </th>
                            @can('haveaccess','capacitacion.show')
                                <th><a href="{{ route('capacitacion.show',$capacitacion->id) }}" title="Detalle"><img src="{{ asset('/imagenes/config.png') }}"  height="20"></a> </th>
                            @endcan
                            </tr>
                        @endforeach
                        </tbody>
                        </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {!! $capacitaciones->links() !!}
                        </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">

function cambiocheck(check){
    chkbox = document.getElementById('chk'+check);
    $('#guardarcambios').attr('disabled', false);
    if (chkbox.checked) {
        chkbox.checked='';
    }
    else {
        chkbox.checked='true';
    }
}

$(document).ready(function(){
    $('#finalizarclass').change(function(){
        chkid = $(this).attr('id');
        $('#guardarcambios').attr('disabled', false);
        chkboxlider = document.getElementById(chkid);
        chkbox = document.getElementsByClassName(chkid);
        totalchk = chkbox.length;
        for (let i = 0; i < chkbox.length; i++) {
            if (chkboxlider.checked) {
                chkbox[i].checked='true';
            }
            else {
                chkbox[i].checked='';
            }
        }
    });

    $('#guardarcambios').click(function(){
        chkid = 'finalizarclass';
        chkboxlider = document.getElementById(chkid);
        chkbox = document.getElementsByClassName(chkid);
        totalchk = chkbox.length;
        var _token = $('input[name="_token"]').val();
        var id_capacitacion = $('#id_capacitacion').val();
        var id_usuario = new Array();
        var estado = new Array();

        this.disabled = true;

        for (let i = 0; i < totalchk; i++) {
             id_usuario[i] = chkbox[i].name;
            if (chkbox[i].checked) {
                estado[i] = 'Finalizado';
            }
            else {
                estado[i] = 'Inscripto';
            }
        }
        /*
            $.ajax({
                url:"{{ route('capacitacion.editestado') }}",
                method:"POST",
                data:{_token:_token,estado:estado, id_usuario:id_usuario, id_capacitacion:id_capacitacion},
                error:function()
                {
                    alert("Ha ocurrido un error, intentelo más tarde");
                    this.disabled = false;
                },
                success:function(data)
                {

                }
                
            })
            */

            $.ajax({
                url:"{{ route('capacitacion.editestado') }}",
                method:"POST",
                data:{_token:_token,'estado': JSON.stringify(estado), id_capacitacion:id_capacitacion,cantidad:totalchk,'id_usuario': JSON.stringify(id_usuario)},
                error:function()
                {
                    alert("Ha ocurrido un error, intentelo más tarde");
                    this.disabled = false;
                },
                success:function(data)
                {
                    alert('Se ha modificado con éxito el estado de finalización');
                    window.location = data.url
                    //alert(data);
                }
                
            })
    });
});
</script>
@endsection
