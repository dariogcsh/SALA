@extends('layouts.app')
 <!-- Se usara la variable para detectar si es un movil o no -->
@php 
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    use App\planservicio; 
@endphp
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Lista de tareas 
                @can('haveaccess','tarea.create')
                    <a href="{{ route('tarea.create') }}" class="btn btn-success float-right"><b>+</b></a>
                @endcan
                </h2></div>
                <div class="card-body">
                    @include('custom.message')
                    <div class="row">
                        <div class="form-group col-md-2">
                            <h5><u>Sucursal</u></h5>
                            <form name="formulario1">
                                <select name="sucursal" id="sucursal" class="form-control" onchange="javascript:enviar_formulario1()">
                                    <option value="Todas las sucursales">Todas las sucursales</option>
                                    @isset ($sucursal)
                                        <option value="{{ $sucursal }}" selected>{{ $sucursal }}</option>
                                    @else
                                        @php
                                            $sucursal="";
                                        @endphp
                                    @endisset
                                    @foreach($sucursales as $sucu)
                                        @if($sucu->NombSucu <> $sucursal)
                                            <option value="{{ $sucu->NombSucu }}">{{ $sucu->NombSucu }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <a href="{{ route('tarea.imatriz') }}" class="btn btn-dark btn-block"><b>Vista matriz</b></a>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-2">
                            <a href="{{ route('tarea.index') }}" class="btn btn-warning btn-block"><b>T1 Aministrativo</b></a>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-2">
                            <a href="{{ route('tarea.progreso') }}" class="btn btn-warning btn-block"><b>T2 Técnicos</b></a>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-2">
                            <a href="{{ route('tarea.ihistorial') }}" class="btn btn-success btn-block"><b>T3 Finalizados</b></a>
                        </div>
                    </div>
                    <br>
                    <br>
                    @if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                        <!-- Slides -->                       
                        <div class="swiper-slide">
                                
                            <div class="col-md-2">
                                @php 
                                    $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                                    $dia = $dias[(date('N', strtotime($hoy[0]))) - 1];
                                @endphp
                                @if($dia <> "Domingo")
                                    <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[0])) }}</h5></b></div>
                                        
                                    @foreach ($tecnicos as $tecnico)
                                    <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>
                                    
                                        @for($i = 0; $i < $repetitiva; $i++)
                                            @foreach ($f1tractor[$i] as $tarea)
                                                @include('tarea.fortractor')
                                            @endforeach
                                        
                                            @foreach ($f1cosechadora[$i] as $tarea)
                                                @include('tarea.forcosechadora')
                                            @endforeach
                                        
                                            @foreach ($f1pulverizadora[$i] as $tarea)
                                                @include('tarea.forpulverizadora')
                                            @endforeach
                                            
                                            @foreach ($f1sembradora[$i] as $tarea)
                                                @include('tarea.forsembradora')
                                            @endforeach
                                        @endfor
                                    @endforeach
                                @endif
                            </div>
                        </div>
                   
                        <div class="swiper-slide">
                            <div class="col-md-2">   
                            @php 
                                $dia = $dias[(date('N', strtotime($hoy[1]))) - 1];
                            @endphp
                            @if($dia <> "Domingo")
                            <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[1])) }}</h5></b></div>
                                @foreach ($tecnicos as $tecnico)
                                <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>
                                    @for($i = 0; $i < $repetitiva; $i++)
                                        @foreach ($f2tractor[$i] as $tarea)
                                            @include('tarea.fortractor')
                                        @endforeach
                                    
                                        @foreach ($f2cosechadora[$i] as $tarea)
                                            @include('tarea.forcosechadora')
                                        @endforeach
                                    
                                        @foreach ($f2pulverizadora[$i] as $tarea)
                                            @include('tarea.forpulverizadora')
                                        @endforeach
                                        
                                        @foreach ($f2sembradora[$i] as $tarea)
                                            @include('tarea.forsembradora')
                                        @endforeach
                                    @endfor
                                @endforeach
                            @endif
                            </div>
                        </div>
                  
                        <div class="swiper-slide">
                            <div class="col-md-2">
                            @php 
                                $dia = $dias[(date('N', strtotime($hoy[2]))) - 1];
                            @endphp
                            @if($dia <> "Domingo")
                            <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[2])) }}</h5></b></div>
                                @foreach ($tecnicos as $tecnico)  
                                <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>                        
                                    @for($i = 0; $i < $repetitiva; $i++)
                                        @foreach ($f3tractor[$i] as $tarea)
                                            @include('tarea.fortractor')
                                        @endforeach
                                    
                                        @foreach ($f3cosechadora[$i] as $tarea)
                                            @include('tarea.forcosechadora')
                                        @endforeach
                                    
                                        @foreach ($f3pulverizadora[$i] as $tarea)
                                            @include('tarea.forpulverizadora')
                                        @endforeach
                                        
                                        @foreach ($f3sembradora[$i] as $tarea)
                                            @include('tarea.forsembradora')
                                        @endforeach
                                    @endfor
                                @endforeach
                            @endif
                            </div>
                        </div>
                  
                        <div class="swiper-slide">
                            <div class="col-md-2">
                            @php 
                                $dia = $dias[(date('N', strtotime($hoy[3]))) - 1];
                            @endphp
                            @if($dia <> "Domingo")
                            <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[3])) }}</h5></b></div>
                               
                                @foreach ($tecnicos as $tecnico)
                                <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>
                                    @for($i = 0; $i < $repetitiva; $i++)
                                        @foreach ($f4tractor[$i] as $tarea)
                                            @include('tarea.fortractor')
                                        @endforeach
                                    
                                        @foreach ($f4cosechadora[$i] as $tarea)
                                            @include('tarea.forcosechadora')
                                        @endforeach
                                    
                                        @foreach ($f4pulverizadora[$i] as $tarea)
                                            @include('tarea.forpulverizadora')
                                        @endforeach
                                        
                                        @foreach ($f4sembradora[$i] as $tarea)
                                            @include('tarea.forsembradora')
                                        @endforeach
                                    @endfor
                                @endforeach
                            @endif
                            </div>
                        </div>
                   
                        <div class="swiper-slide">
                            <div class="col-md-2"> 
                            @php 
                                $dia = $dias[(date('N', strtotime($hoy[4]))) - 1];
                            @endphp
                            @if($dia <> "Domingo")
                            <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[4])) }}</h5></b></div>
                               
                                @foreach ($tecnicos as $tecnico)   
                                <div class="card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>                      
                                    @for($i = 0; $i < $repetitiva; $i++)
                                        @foreach ($f5tractor[$i] as $tarea)
                                            @include('tarea.fortractor')
                                        @endforeach
                                    
                                        @foreach ($f5cosechadora[$i] as $tarea)
                                            @include('tarea.forcosechadora')
                                        @endforeach
                                    
                                        @foreach ($f5pulverizadora[$i] as $tarea)
                                            @include('tarea.forpulverizadora')
                                        @endforeach
                                        
                                        @foreach ($f5sembradora[$i] as $tarea)
                                            @include('tarea.forsembradora')
                                        @endforeach
                                    @endfor
                                @endforeach
                            @endif
                            </div>
                        </div>
                    
                        
                        </div>
                        <!-- If we need pagination 
                        <div class="swiper-pagination"></div>
                        -->
                        <!-- If we need navigation buttons
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                        -->
                        <!-- If we need scrollbar -->
                        <div class="swiper-scrollbar"></div>
                    </div>
                    @else
                    @php 
                        $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
                    @endphp
                    <div class="row align-items-center">
                        <div class="col-md-2"><div height="100%" class="card-header bg-light"><b><h5 align="center">Tecnicos</h5></b></div></div>
                        @for($i = 0; $i < 5; $i++)
                            @php 
                                $dia = $dias[(date('N', strtotime($hoy[$i]))) - 1];
                            @endphp
                            @if($dia <> "Domingo")
                                <div class="col-md-2"><div height="100%" class="card-header border-dark bg-light"><b><h5 align="center">{{ $dia }} {{ date('d', strtotime($hoy[$i])) }}</h5></b></div></div>
                            @else
                                @php
                                $domingo = $i;  
                                @endphp
                            @endif
                        @endfor
                    </div>
                        @php 
                        //detectar si el numero es par o impar para poner un fondo de distinto color
                        $num = 0;
                        @endphp
                      
                        <div class="row align-items-center">
                        @foreach ($tecnicos as $tecnico)
                            <div class="col-md-2">
                                @if (($num % 2) == 0) 
                                    <div class="card-header-top card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>
                                @else
                                    <div class="card-header-top card-header border-dark bg-light"><b><h5 align="center">{{ $tecnico->name }} {{ $tecnico->last_name }}</h5></b></div>
                                @endif
                            </div>
            
                            <div class="col-md-2">
                                @for($i = 0; $i < $repetitiva; $i++)
                                    @foreach ($f1tractor[$i] as $tarea)
                                        @include('tarea.fortractor')
                                    @endforeach
                                    
                                    @foreach ($f1cosechadora[$i] as $tarea)
                                        @include('tarea.forcosechadora')
                                    @endforeach
                                
                                    @foreach ($f1pulverizadora[$i] as $tarea)
                                        @include('tarea.forpulverizadora')
                                    @endforeach
                                    
                                    @foreach ($f1sembradora[$i] as $tarea)
                                        @include('tarea.forsembradora')
                                    @endforeach
                                @endfor
                            </div>
 
                        <div class="col-md-2">  
                            @for($i = 0; $i < $repetitiva; $i++)
                                @foreach ($f2tractor[$i] as $tarea)
                                    @include('tarea.fortractor')
                                @endforeach
                                
                                @foreach ($f2cosechadora[$i] as $tarea)
                                    @include('tarea.forcosechadora')
                                @endforeach
                            
                                @foreach ($f2pulverizadora[$i] as $tarea)
                                    @include('tarea.forpulverizadora')
                                @endforeach
                                
                                @foreach ($f2sembradora[$i] as $tarea)
                                    @include('tarea.forsembradora')
                                @endforeach
                           @endfor
                        </div>
    
                        <div class="col-md-2">  
                            @for($i = 0; $i < $repetitiva; $i++)
                                @foreach ($f3tractor[$i] as $tarea)
                                    @include('tarea.fortractor')
                                @endforeach
                                
                                @foreach ($f3cosechadora[$i] as $tarea)
                                    @include('tarea.forcosechadora')
                                @endforeach
                            
                                @foreach ($f3pulverizadora[$i] as $tarea)
                                    @include('tarea.forpulverizadora')
                                @endforeach
                                
                                @foreach ($f3sembradora[$i] as $tarea)
                                    @include('tarea.forsembradora')
                                @endforeach
                            @endfor
                        </div>
    
                        <div class="col-md-2">
                            @for($i = 0; $i < $repetitiva; $i++)
                                @foreach ($f4tractor[$i] as $tarea)
                                    @include('tarea.fortractor')
                                @endforeach
                                
                                @foreach ($f4cosechadora[$i] as $tarea)
                                    @include('tarea.forcosechadora')
                                @endforeach
                            
                                @foreach ($f4pulverizadora[$i] as $tarea)
                                    @include('tarea.forpulverizadora')
                                @endforeach
                                
                                @foreach ($f4sembradora[$i] as $tarea)
                                    @include('tarea.forsembradora')
                                @endforeach
                            @endfor
                        </div>
     
                        <div class="col-md-2">
                            @for($i = 0; $i < $repetitiva; $i++)
                                @foreach ($f5tractor[$i] as $tarea)
                                    @include('tarea.fortractor')
                                @endforeach
                                
                                @foreach ($f5cosechadora[$i] as $tarea)
                                    @include('tarea.forcosechadora')
                                @endforeach
                            
                                @foreach ($f5pulverizadora[$i] as $tarea)
                                    @include('tarea.forpulverizadora')
                                @endforeach
                                
                                @foreach ($f5sembradora[$i] as $tarea)
                                    @include('tarea.forsembradora')
                                @endforeach
                            @endfor
                        </div>
                        @php 
                        $num++;
                        @endphp
                        <div class="col-md-12"><hr></div>
                        @endforeach
                        
                        </div>
                        
                        @endif
                        
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="application/javascript">
function enviar_formulario1(){
            document.formulario1.submit()
        }
$(document).ready(function() {
    $('.clestado').click(function(){   
        var element_id = $(this).attr('name');  
        var tarea = $(this).attr('id');    
        var _token = $('input[name="_token"]').val(); 
        $.ajax({
            url:"{{ route('tarea.estado') }}",
            method:"POST",
            data:{element_id:element_id,tarea:tarea, _token:_token},
            success:function(result)
            {
                location.reload();
            },
            error:function(){
                alert("Ha ocurrido un error, intentelo más tarde");
            }
        })
    });
 
    $('.buttonc').click(function() {
        var id_ocultar = $(this).attr("name");
        if ($("#display"+id_ocultar).is (':hidden'))
            $("#display"+id_ocultar).show();
        else
            $("#display"+id_ocultar).hide();
    });

    const swiper = new Swiper('.swiper', {

    // If we need pagination
    pagination: {
        el: '.swiper-pagination',
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    scrollbar: {
        el: '.swiper-scrollbar',
    },
    });
  
   
  
});
</script>
@endsection
