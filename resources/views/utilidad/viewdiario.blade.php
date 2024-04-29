@php
    use App\utilidad;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><h2>Resumen periódico</h2></div>
                <div class="card-body">
                    <h3>{{ date('d/m/Y',strtotime($fecha)) }} - {{ $organizacion->NombOrga }}</h3>
                    <hr>
                    <small>* Datos pertenecientes al día <b>{{ date('d/m/Y',strtotime($fecha)) }}</b>: </small>
                    <br>
                 
                    @foreach($maquinas as $maquina)
                            @php
                            $totalhs = 0;
                            $combustibleconsumido = 0;
                                //Calculo horas
                                $ralentihs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha],
                                                            ['SeriUtil','Ralentí'], ['UOMUtil','hr']])->sum('ValoUtil');
                                $trabajohs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha],
                                                            ['SeriUtil','Trabajando'], ['UOMUtil','hr']])->sum('ValoUtil');
                                $transportehs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha],
                                                            ['SeriUtil','Transporte'], ['UOMUtil','hr']])->sum('ValoUtil');
                                $virajeshs = Utilidad::where([['NumsMaq',$maquina->NumSMaq],['FecIUtil',$fecha],
                                                            ['SeriUtil','Separador de virajes en cabecero engranado'],
                                                            ['UOMUtil', 'hr']])->sum('ValoUtil');
                                
                                $totalhs = $ralentihs + $trabajohs + $transportehs;
                              
                                //Calculo porcentajes
                                if (!empty($totalhs)) {
                                    $ralentip = ($ralentihs / $totalhs) * 100;
                                    $trabajop = ($trabajohs / $totalhs) * 100;
                                    $transportep = ($transportehs / $totalhs) * 100;
                                    $virajesp = ($virajeshs / $totalhs) * 100;
                                }

                                //Calculo litros
                                $ralentil = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['SeriUtil','Ralentí'], ['UOMUtil','l']])->sum('ValoUtil');
                                $trabajol = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['SeriUtil','Trabajando'], ['UOMUtil','l']])->sum('ValoUtil');
                                $transportel = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['SeriUtil','Transporte'], ['UOMUtil','l']])->sum('ValoUtil');
                                $virajesl = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['SeriUtil','Separador de virajes en cabecero engranado'],
                                                            ['UOMUtil','l']])->sum('ValoUtil');

                                $combustibleconsumido = $ralentil + $trabajol + $transportel;

                                //Calculo de velocidad y factor de carga de motor
                                $velocidad = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha], 
                                                            ['SeriUtil','Trabajando'], ['UOMUtil', 'km/hr']])->avg('ValoUtil');
                                $factorcarga = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha], 
                                                                ['SeriUtil','Trabajando'],['UOMUtil', '%']])->avg('ValoUtil');

                                //Utilizacion de la tecnologia
                                if ($maquina->TipoMaq == "COSECHADORA") {
                                    //Harvest Smart
                                    $harvest_total = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Harvest Smart%'], ['UOMUtil','hr']])->sum('ValoUtil');
                                    $harvest = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Harvest Smart%'], ['SeriUtil','Enc'], 
                                                            ['UOMUtil','hr']])->sum('ValoUtil');
                                    if (!empty($harvest_total)) {
                                        $porc_harvest = $harvest / $harvest_total *100;
                                    } else {
                                        $porc_harvest = 0;
                                    }

                                    //Auto Mantain
                                    $mantenerauto_total = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Mantener automáticamente%'], ['UOMUtil','hr']])->sum('ValoUtil');
                                    $mantenerauto = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Mantener automáticamente%'], ['SeriUtil','Enc'], 
                                                            ['UOMUtil','hr']])->sum('ValoUtil');
                                    if (!empty($mantenerauto_total)) {
                                        $porc_mantenerauto = $mantenerauto / $mantenerauto_total *100;
                                    } else {
                                        $porc_mantenerauto = 0;
                                    }

                                    //ATA
                                    $ATA_total = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Active Terrain Adjustment%'], ['UOMUtil','hr']])->sum('ValoUtil');
                                    $ATA = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Active Terrain Adjustment%'], ['SeriUtil','Enc'], 
                                                            ['UOMUtil','hr']])->sum('ValoUtil');
                                    if (!empty($ATA_total)) {
                                        $porc_ATA = $ATA / $ATA_total *100;
                                    } else {
                                        $porc_ATA = 0;
                                    }

                                    //Active Yield
                                    $activeyield_total = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Active Yield%'], ['UOMUtil','hr']])->sum('ValoUtil');
                                    $activeyield = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','%Active Yield%'], ['SeriUtil','Enc'], 
                                                            ['UOMUtil','hr']])->sum('ValoUtil');
                                    if (!empty($activeyield_total)) {
                                        $porc_activeyield = $activeyield / $activeyield_total *100;
                                    } else {
                                        $porc_activeyield = 0;
                                    }

                                    //Autotrac
                                    $autotrac_total = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','AutoTrac%'], ['UOMUtil','hr']])->sum('ValoUtil');
                                    $autotrac = Utilidad::where([['utilidads.NumsMaq',$maquina->NumSMaq],['utilidads.FecIUtil',$fecha],
                                                            ['CateUtil','LIKE','AutoTrac%'], ['SeriUtil','Enc'], 
                                                            ['UOMUtil','hr']])->sum('ValoUtil');
                              
                                    if (!empty($autotrac_total)) {
                                        $porc_autotrac = $autotrac / $autotrac_total *100;
                                    } else {
                                        $porc_autotrac = 0;
                                    }
                                    
                                }

                            @endphp
                            <br>
                            @if ($totalhs <> 0)
                            <div class="title-{{ $maquina->TipoMaq }}"><h5>{{ $maquina->TipoMaq }}</h5></div>
                            <br>
                            @if ($maquina->ModeMaq <> 'NULL')
                                <h3><i>{{ $maquina->ModeMaq }}</h3><h5>{{ $maquina->nombre }} - <small>{{ $maquina->NumSMaq }}</small></i></h5>
                            @endif
                            <br>
                            <h4 style="text-align: center;">Funcionamiento del equipo</h4>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Trabajando</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($trabajop,0) }} <small>%</small> | {{ number_format($trabajohs,1) }} <small>hs</small> | {{ number_format($trabajol,0) }} <small>lts</small></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Transporte</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($transportep,0) }} <small>%</small> | {{ number_format($transportehs,1) }} <small>hs</small> | {{ number_format($transportel,0) }} <small>lts</small></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Ralenti</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($ralentip,0) }} <small>%</small> | {{ number_format($ralentihs,1) }} <small>hs</small> | {{ number_format($ralentil,0) }} <small>lts</small></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Separador de virajes en cabecero engranado</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($virajesp,1) }} <small>%</small> | {{ number_format($virajeshs,1) }} <small>hs</small> | {{ number_format($virajesl,0) }} <small>lts</small></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Velocidad</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($velocidad,1) }} <small>km/hs</small></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Factor de carga de motor</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($factorcarga,0) }} <small>%</small></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h4 style="text-align: center;">Utilización de tecnología</h4>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-success">
                                        <div class="card-header text-center text-white bg-success">
                                            <h5>Auto Mantain</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>@isset ($porc_mantenerauto) {{ number_format($porc_mantenerauto,0) }} <small>%</small> | {{ number_format($mantenerauto,1) }} <small>hs</small>@endisset</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-success">
                                        <div class="card-header text-center text-white bg-success">
                                            <h5>Harvest Smart</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>@isset ($porc_harvest) {{ number_format($porc_harvest,0) }} <small>%</small> | {{ number_format($harvest,1) }} <small>hs</small>@endisset</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-success">
                                        <div class="card-header text-center text-white bg-success">
                                            <h5>ATA</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>@isset ($porc_ATA) {{ number_format($porc_ATA,0) }}<small>%</small> | {{ number_format($ATA,1) }} <small>hs</small>@endisset</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-success">
                                        <div class="card-header text-center text-white bg-success">
                                            <h5>Active Yield</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>@isset ($porc_activeyield) {{ number_format($porc_activeyield,0) }} <small>%</small> | {{ number_format($activeyield,1) }} <small>hs</small>@endisset</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="card mb-3 border-success">
                                        <div class="card-header text-center text-white bg-success">
                                            <h5>AutoTrac</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>@isset ($porc_autotrac) {{ number_format($porc_autotrac,0) }} <small>%</small> | {{ number_format($autotrac,1) }} <small>hs</small>@endisset</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2">
                                </div>
                            </div>
                            
                            <br>
                            <div class="row">
                                <h4><u><small>Combustible consumido total:</small></u> {{ $combustibleconsumido }} <small>lts.</small></h4>
                            </div>
                            <hr>
                            <br>
                            @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

