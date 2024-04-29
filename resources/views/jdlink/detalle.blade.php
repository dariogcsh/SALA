@php
    use App\jdlink;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Paquetes de soporte y monitoreo</h2></div>

                <div class="card-body">
                    <div class="container">
                        @if($monitoreo =="NO")
                            <h5>No se ha encontrado ningun paquete de soporte de monitoreo vigente.</h5>
                            Ver paquetes de soporte y monitoreo <a href="{{ route('solucion.index') }}">AQUÍ</a>
                        @endif
                        @if($monitoreo=="SI")
                            <h3><b>Servicios suscriptos al plan de Soporte y Monitoreo</b></h3>
                            <br>
                            <h4><u>Plan Standard</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Se realizará un seguimiento periódico de la correcta carga de información y mapeo enviado vía remota por el tractor al Centro de Operaciones.
                            Se brindará soporte telefónico para maquinistas, asesores agronómicos, encargados, etc sobre configuraciones de pantallas, fallas, alertas,
                            utilización de tecnologías de maquinaria, utilización de herramientas del Centro de Operaciones, informes, etc.
                            Se brindará acceso total a todas las herramientas de la App de Sala Hnos para visualizar informes agronómicos, informes de ef iciencia de uso del tractor, puede solicitar asistencia a través de la misma y beneficiarse de bonificaciones que se cargar a lo largo del año para clientes conectados. También a través de este medio se le informará qué acción tomo la concesionaria ante la aparición de alguna alerta de gravedad en la unidad monitoreada.
                            Se cargará en la herramienta JDLink un plan de mantenimiento correspondiente al equipo según manual de mantenimiento y recomendaciones de técnicos especialistas. Esta herramienta informará 50 hs antes de llegar a un plan, cuales son las tareas correspondientes a realizar sobre el equipo, a través de una notificación de la App de JDLink y App de Sala Hnos.
                            Habrá control de alertas de gravedad que pudiera arrojar el equipo. Ante dicho acontecimiento el concesionario tomará acciones para comunicar dichas alertas y a qué refieren, si se puede seguir trabajando es necesario realizar algún servicio, etc. Esta acción realizada por el concesionario será informada a través de la App de Sala Hnos. para su conocimiento. También se gestionarán las alertas predictivas (Expert Alert) que permiten anticiparnos a una posible falla y realizar el servicio necesario en tiempo y forma evitando tiempos de máquina parada.
                            Corresponde a la generación de informes agronómicos semanales con indicadores de avances de siembra. También se generará un informe de eficiencia de uso del tractor cada 50 hs de motor y se notificará la generación y disponibilidad del mismo a través de la App de Sala Hnos. para su análisis.
                            Para el caso de tener que hacerse un diagnóstico sobre el equipo por alguna falla, este diagnóstico se puede realizar via remota a distancia gracias a la telemetría JDLink, permitiendo ahorrar tiempos y costos de traslados para su realización.
                            Prevención de fallas futuras con Expert Alerts.
                            <hr>
                        @endif
                        @if($soporte_siembra=="SI")
                            <h4><u>Soporte en siembra</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Refiere a la ambientación de los lotes desde el Centro de Soluciones Conectadas mediante la combinación y análisis de diferentes capas de mapas de rendimiento e imágenes satelitales de alta calidad. La ambientación se validará conjuntamente con el cliente y/o asesor agronómico considerando historial del lote, rotaciones de cultivos, etc y definiendo tipos de insumos y dosis para la prescripción.
                            Se importará el archivo de prescripción al monitor y posterior conversión del archivo Shapefile para que sea ejecutado correctamente.
                            Se controlará que el tractor y sembradora estén ejecutando de manera correcta lo que se indica en la prescripción correspondiente.
                            Corresponde a un viaje a campo para controlar la calidad de siembra (espaciado entre semillas y profundidad de siembra).
                            También se podrá controlar alguna ocurrencia o anomalía que pudiera ocurrir en el lote, a través de una API vinculada al Centro
                            de Operaciones que brinda imágenes de NDVI periódicamente.
                            <hr>
                        @endif

                        @if($capacitacion_op=="SI")
                            <h4><u>Capacitación a operarios</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Capacitación para 2 operarios en concesionaria sobre: Uso y funcionamiento de cosechador, mantenimiento de cosechadora y automatización de cosechadora según corresponda.
                            <hr>
                        @endif

                        @if($capacitacion_asesor=="SI")
                            <h4><u>Capacitación a asesor agronómico</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Capacitación para el asesor agronómico de la organización será en 4 módulos de utilización de herramientas del Centro de Operaciones, para visualización de mapeo con sus
                            capas en cada una de sus labores, gestión de líneas de guiados y marcadores, ordenamiento de los datos agronómicos,
                            API's vinculadas para la generación de prescripciones y para visualización de imágenes NDV en el Centro de Operaciones.
                            <hr>
                        @endif

                        @if($ordenamiento_agro=="SI")
                            <h4><u>Ordenamiento de datos agronómicos</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Corresponde al ordenamiento de todos los datos agronómicos que se encuentran cargados en 
                            el Centro de Operaciones, combinación de mapas, generación de límites, líneas de guiado, edición 
                            de Cliente, Granja y Campos. Una vez terminado el ordenamiento se generará un archivo de 
                            configuración para ser cargada en las maquinarias.
                            <hr>
                        @endif

                        @if($visita_inicial=="SI")
                            <h4><u>Visita inicial</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Incluye viaje a campo, configuración de parámetros de documentación, capacitación de uso de la cosechadora, capacitación de limpieza y capacitación de ajustes de cosechadora y plataforma.
                            <hr>
                        @endif

                        @if($check_list=="SI")
                            <h4><u>Check list</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Incluye viaje a campo a final de campaña para realizar una inspección técnica de puntos de mantenimiento e inspección técnica de piezas de desgaste.
                            <hr>
                        @endif

                        @if($limpieza_inyectores=="SI")
                            <h4><u>Limpieza de inyectores</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Incluye viaje a campo para servicio de limpieza de inyectores, incluye consumibles. (No incluye filtro de combustible del equipo).
                            <hr>
                        @endif

                        @if($apivinculada=="SI")
                            <h4><u>API vinculada</u></h4>
                            @foreach($maquinas as $maquina)
                                @php
                                    $jdlinks = Jdlink::where([['NumSMaq',$maquina->NumSMaq],['vencimiento_contrato','>=',$hoy]])
                                                    ->orderBy('vencimiento_contrato','DESC')->get();
                                @endphp
                                    @foreach($jdlinks as $jdlink)
                                    <img class="img img-responsive" src="{{ '/imagenes/'.$maquina->TipoMaq.'.png' }}" height="30px"> {{ $maquina->ModeMaq }} //  
                                    @endforeach
                            @endforeach
                            <br>
                            Refiere  a la vinculación entre el Centro de Operaciones y otra Aplicación con la que se puede trabajar e intercambiar información entre ellas.
                            <hr>
                        @endif
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection