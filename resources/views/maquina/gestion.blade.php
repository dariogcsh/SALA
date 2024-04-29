@php
    use App\jdlink;
@endphp
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Equipos y conectividad
                </h2></div>
                <div class="card-body">
                @include('custom.message')
                
                @php
                    $rep_equipo = 0;
                    $rep_cose = 0;
                    $rep_tractor = 0;
                    $rep_pulv = 0;
                    $rep_pla = 0;
                    $total_monitoreo = 0;
                    $total_renov = 0;
                    $total_monitoreo_cosechadora = 0;
                    $total_renov_cosechadora = 0;
                @endphp
                    
                 <!--Accordion wrapper-->
                 <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headingOne">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne" aria-expanded="false"
                            aria-controls="collapseOne">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Equipos del concesionario
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Equipo</th>
                                                    <th scope="col">Marca</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Paquetes de monitoreo vigentes</th>
                                                    <th scope="col">Renovaciones {{ $año }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($equipos as $equipo)
                                                    <tr>
                                                            <th scope="row">{{ $equipo->TipoMaq }}</th>
                                                            <th scope="row">{{ $equipo->MarcMaq }}</th>
                                                            <th scope="row">{{ $equipo->cant_equipo }}</th>
                                                            @php
                                                            $conteo = 0;
                                                            // Paquetes vigentes
                                                                $paq_vigente = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                                    ->where([['maquinas.TipoMaq',$equipo->TipoMaq], ['jdlinks.vencimiento_contrato', '>=',$hoy],
                                                                                            ['maquinas.MarcMaq',$equipo->MarcMaq], ['jdlinks.monitoreo','SI']])->count();
                                                            @endphp
                                                                <th scope="row">{{ $paq_vigente }}</th>
                                                            @php
                                                            //Renovaciones de paquetes
                                                            $conteo = 0;
                                                                $paq_FY_pasado = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                                        ->where([['maquinas.TipoMaq',$equipo->TipoMaq], ['jdlinks.anofiscal',$añopasado],
                                                                                                ['maquinas.MarcMaq',$equipo->MarcMaq], ['jdlinks.monitoreo','SI']])
                                                                                        ->get();
                                                               
                                                            
                                                                if (isset($paq_FY_pasado)) {
                                                                    foreach ($paq_FY_pasado as $paq) {
                                                                        $renovacion = Jdlink::where([['NumSMaq',$paq->NumSMaq], ['anofiscal',$año],
                                                                                                    ['monitoreo','SI']])->count();
                                                                        $conteo = $conteo + $renovacion;
                                                                    }
                                                                
                                                                }
                                                               
                                                            @endphp
                                                            <th scope="row">{{ $conteo }}</th>  
                                                    </tr>
                                                    @php
                                                        $tipo[$rep_equipo] = $equipo->TipoMaq.' '.$equipo->MarcMaq;
                                                        $cantidad_tipo[$rep_equipo] = $equipo->cant_equipo;
                                                        $monitoreos[$rep_equipo] = $paq_vigente;
                                                        $renov[$rep_equipo] = $conteo;
                                                        $total_monitoreo = $total_monitoreo + count($paq_FY_pasado) - $conteo;
                                                        $total_renov = $total_renov + $renov[$rep_equipo];
                                                        $rep_equipo++;
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                    </div>    
                                </div>
                            </div>
                        </div>
                    
                        <!-- Accordion card -->
                        <div class="row">
                            <div class="col-md-4">
                                <div id="chart_equipo"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="chart_monitoreo_sala"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="chart_renovacion"></div>
                            </div>
                        </div>
                    </div>
                
                <!-- Accordion wrapper -->  

                 <!--Accordion wrapper-->
                 <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinTwo">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Cosechadoras por sucursal
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Paquetes de monitoreo vigentes</th>
                                            <th scope="col">Renovaciones {{ $año }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($cosechadoras_sucu as $cosechadora_sucu)
                                         <tr></tr>
                                            <th scope="row">{{ $cosechadora_sucu->NombSucu }}</th>
                                            <th scope="row">{{ $cosechadora_sucu->cantidad }}</th>
                                            @php
                                            
                                            // Paquetes vigentes
                                                $paq_vigente = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                    ->where([['maquinas.TipoMaq',$cosechadora_sucu->TipoMaq], ['jdlinks.vencimiento_contrato', '>=',$hoy],
                                                                            ['maquinas.MarcMaq',$cosechadora_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                            ['sucursals.NombSucu',$cosechadora_sucu->NombSucu]])->count();
                                            @endphp
                                                <th scope="row">{{ $paq_vigente }}</th>
                                            @php
                                            //Renovaciones de paquetes
                                            $conteo = 0;
                                            $cant_FY = 0;
                                                $paq_FY_pasado = Jdlink::select('jdlinks.NumSMaq')
                                                                        ->join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                        ->where([['maquinas.TipoMaq',$cosechadora_sucu->TipoMaq], ['jdlinks.anofiscal',$añopasado],
                                                                                ['maquinas.MarcMaq',$cosechadora_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                                ['sucursals.NombSucu',$cosechadora_sucu->NombSucu]])
                                                                        ->get();
                                               
                                            
                                                if (isset($paq_FY_pasado)) {
                                                    foreach ($paq_FY_pasado as $paq) {
                                                        $renovacion = Jdlink::where([['NumSMaq',$paq->NumSMaq], ['anofiscal',$año], ['jdlinks.monitoreo','SI']])->count();
                                                        $conteo = $conteo + $renovacion;
                                                        $cant_FY++;
                                                    }
                                                }
                                            
                                            @endphp
                                            <th scope="row">{{ $conteo }}</th>  
                                            </tr>
                                            @php
                                                $cant_c[$rep_cose] = $cosechadora_sucu->cantidad;
                                                $nomb_sucu_c[$rep_cose] = $cosechadora_sucu->NombSucu;
                                                $monitoreo_vigente_c[$rep_cose] = $paq_vigente;
                                                $monitoreo_renov_c[$rep_cose] = $conteo;
                                                $cant_FY_cosechadora[$rep_cose] = $cant_FY;
                                                $rep_cose++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-4">
                            <div id="chart_cosechadora_sucu"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_monitoreo_cosechadora"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_renovacion_cosechadora"></div>
                        </div>
                    </div>
                    
                </div>
                <!-- Accordion wrapper -->  

                  <!--Accordion wrapper-->
                  <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinThree">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree" aria-expanded="false"
                            aria-controls="collapseThree">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Tractores por sucursal
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Paquetes de monitoreo vigentes</th>
                                            <th scope="col">Renovaciones {{ $año }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($tractores_sucu as $tractor_sucu)
                                         <tr></tr>
                                            <th scope="row">{{ $tractor_sucu->NombSucu }}</th>
                                            <th scope="row">{{ $tractor_sucu->cantidad }}</th>
                                            @php
                                            // Paquetes vigentes
                                                $paq_vigente = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                    ->where([['maquinas.TipoMaq',$tractor_sucu->TipoMaq], ['jdlinks.vencimiento_contrato', '>=',$hoy],
                                                                            ['maquinas.MarcMaq',$tractor_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                            ['sucursals.NombSucu',$tractor_sucu->NombSucu]])->count();
                                            @endphp
                                                <th scope="row">{{ $paq_vigente }}</th>
                                            @php
                                            //Renovaciones de paquetes
                                            $conteo = 0;
                                            $cant_FY = 0;
                                                $paq_FY_pasado = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                        ->where([['maquinas.TipoMaq',$tractor_sucu->TipoMaq], ['jdlinks.vencimiento_contrato', '<',$hoy], ['jdlinks.anofiscal',$añopasado],
                                                                                ['maquinas.MarcMaq',$tractor_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                                ['sucursals.NombSucu',$tractor_sucu->NombSucu]])
                                                                        ->get();
                                               
                                            
                                                if (isset($paq_FY_pasado)) {
                                                    foreach ($paq_FY_pasado as $paq) {
                                                        $renovacion = Jdlink::where([['NumSMaq',$paq->NumSMaq], ['anofiscal',$año]])->count();
                                                        $conteo = $conteo + $renovacion;
                                                        $cant_FY++;
                                                    }
                                                }
                                            @endphp
                                            <th scope="row">{{ $conteo }}</th>  
                                            </tr>
                                            @php
                                                $nomb_sucu_t[$rep_tractor] = $tractor_sucu->NombSucu;
                                                $cant_t[$rep_tractor] = $tractor_sucu->cantidad;
                                                //dd($cant_t[$rep_tractor + 1]);
                                                $monitoreo_vigente_t[$rep_tractor] = $paq_vigente;
                                                $monitoreo_renov_t[$rep_tractor] = $conteo;
                                                $cant_FY_tractor[$rep_tractor] = $cant_FY;
                                                $rep_tractor++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-4">
                            <div id="chart_tractor_sucu"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_monitoreo_tractor"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_renovacion_tractor"></div>
                        </div>
                    </div>
                </div>
                <!-- Accordion wrapper -->  

                  <!--Accordion wrapper-->
                  <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinFour">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFour" aria-expanded="false"
                            aria-controls="collapseFour">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Pulverizadoras JD por sucursal
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">Sucursal</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Paquetes de monitoreo vigentes</th>
                                            <th scope="col">Renovaciones {{ $año }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($pulverizadoras_sucu as $pulverizadora_sucu)
                                         <tr></tr>
                                            <th scope="row">{{ $pulverizadora_sucu->NombSucu }}</th>
                                            <th scope="row">{{ $pulverizadora_sucu->cantidad }}</th>
                                            @php
                                            // Paquetes vigentes
                                                $paq_vigente = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                    ->where([['maquinas.TipoMaq',$pulverizadora_sucu->TipoMaq], ['jdlinks.vencimiento_contrato', '>=',$hoy],
                                                                            ['maquinas.MarcMaq',$pulverizadora_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                            ['sucursals.NombSucu',$pulverizadora_sucu->NombSucu]])->count();
                                            @endphp
                                                <th scope="row">{{ $paq_vigente }}</th>
                                            @php
                                            //Renovaciones de paquetes
                                            $conteo = 0;
                                            $cant_FY = 0;
                                                $paq_FY_pasado = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                        ->where([['maquinas.TipoMaq',$pulverizadora_sucu->TipoMaq], ['jdlinks.vencimiento_contrato', '<',$hoy], ['jdlinks.anofiscal',$añopasado],
                                                                                ['maquinas.MarcMaq',$pulverizadora_sucu->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                                ['sucursals.NombSucu',$pulverizadora_sucu->NombSucu]])
                                                                        ->get();
                                               
                                            
                                                if (isset($paq_FY_pasado)) {
                                                    foreach ($paq_FY_pasado as $paq) {
                                                        $renovacion = Jdlink::where([['NumSMaq',$paq->NumSMaq], ['anofiscal',$año]])->count();
                                                        $conteo = $conteo + $renovacion;
                                                        $cant_FY++;
                                                    }
                                                }
                                            @endphp
                                            <th scope="row">{{ $conteo }}</th>  
                                            </tr>
                                            @php
                                                $nomb_sucu_p[$rep_pulv] = $pulverizadora_sucu->NombSucu;
                                                $cant_p[$rep_pulv] = $pulverizadora_sucu->cantidad;
                                                //dd($cant_t[$rep_tractor + 1]);
                                                $monitoreo_vigente_p[$rep_pulv] = $paq_vigente;
                                                $monitoreo_renov_p[$rep_pulv] = $conteo;
                                                $cant_FY_pulverizadora[$rep_pulv] = $cant_FY;
                                                $rep_pulv++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-4">
                            <div id="chart_pulverizadora_sucu"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_monitoreo_pulverizadora"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_renovacion_pulverizadora"></div>
                        </div>
                    </div>
                </div>
                <!-- Accordion wrapper -->  


                  <!--Accordion wrapper-->
                  <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinFive">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseFive" aria-expanded="false"
                            aria-controls="collapseFive">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Pulverizadoras PLA por sucursal
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingFive"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sucursal</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Paquetes de monitoreo vigentes</th>
                                                <th scope="col">Renovaciones {{ $año }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($pulverizadoras_pla as $pulverizadora_pla)
                                         <tr></tr>
                                            <th scope="row">{{ $pulverizadora_pla->NombSucu }}</th>
                                            <th scope="row">{{ $pulverizadora_pla->cantidad }}</th>
                                            
                                            @php
                                            // Paquetes vigentes
                                                $paq_vigente = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                    ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                    ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                    ->where([['maquinas.TipoMaq',$pulverizadora_pla->TipoMaq], ['jdlinks.vencimiento_contrato', '>=',$hoy],
                                                                            ['maquinas.MarcMaq',$pulverizadora_pla->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                            ['sucursals.NombSucu',$pulverizadora_pla->NombSucu]])->count();
                                            @endphp
                                                <th scope="row">{{ $paq_vigente }}</th>
                                            @php
                                            //Renovaciones de paquetes
                                            $conteo = 0;
                                            $cant_FY = 0;
                                                $paq_FY_pasado = Jdlink::join('maquinas','jdlinks.NumSMaq','=','maquinas.NumSMaq')
                                                                        ->join('organizacions','maquinas.CodiOrga','=','organizacions.id')
                                                                        ->join('sucursals','organizacions.CodiSucu','=','sucursals.id')
                                                                        ->where([['maquinas.TipoMaq',$pulverizadora_pla->TipoMaq], ['jdlinks.vencimiento_contrato', '<',$hoy], ['jdlinks.anofiscal',$añopasado],
                                                                                ['maquinas.MarcMaq',$pulverizadora_pla->MarcMaq], ['jdlinks.monitoreo','SI'],
                                                                                ['sucursals.NombSucu',$pulverizadora_pla->NombSucu]])
                                                                        ->get();
                                               
                                            
                                                if (isset($paq_FY_pasado)) {
                                                    foreach ($paq_FY_pasado as $paq) {
                                                        $renovacion = Jdlink::where([['NumSMaq',$paq->NumSMaq], ['anofiscal',$año]])->count();
                                                        $conteo = $conteo + $renovacion;
                                                        $cant_FY++;
                                                    }
                                                }
                                            @endphp
                                            <th scope="row">{{ $conteo }}</th>  
                                            </tr>
                                            @php
                                                $nomb_sucu_pp[$rep_pla] = $pulverizadora_pla->NombSucu;
                                                $cant_pp[$rep_pla] = $pulverizadora_pla->cantidad;
                                                //dd($cant_t[$rep_tractor + 1]);
                                                $monitoreo_vigente_pp[$rep_pla] = $paq_vigente;
                                                $monitoreo_renov_pp[$rep_pla] = $conteo;
                                                $cant_FY_pulvepla[$rep_pla] = $cant_FY;
                                                $rep_pla++;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-4">
                            <div id="chart_pulvepla_sucu"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_monitoreo_pulvepla"></div>
                        </div>
                        <div class="col-md-4">
                            <div id="chart_renovacion_pulvepla"></div>
                        </div>
                    </div>
                </div>
                <!-- Accordion wrapper -->  

                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinNine">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseNine" aria-expanded="false"
                            aria-controls="collapseNine">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Servicios de monitoreos de cosechadoras suscriptos (%)
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseNine" class="collapse" role="tabpanel" aria-labelledby="headingNine"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">FY y Servicio monitoreo</th>
                                            <th scope="col">Porcentaje de servicio suscripto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @for($i = 0; $i <= $diff; $i++)
                                            @for($x = 0; $x < 8; $x++)
                                                <tr>
                                                    <th scope="row">{{ $año_FY[$i] }} {{ $servicio[$x] }}</th>
                                                    <th scope="row">{{ number_format($cantidad_serv[$i][$x],0) }} %</th>
                                                </tr>
                                            @endfor
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chart_servicios_monitoreo"></div>
                        </div>
                    </div>
                </div>
                <!-- Accordion wrapper --> 

                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                    <!-- Accordion card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header" role="tab" id="headinTen">
                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseTen" aria-expanded="false"
                            aria-controls="collapseTen">
                            <h4 class="mb-0">
                                <i class="fas fa-angle-down rotate-icon"></i> Servicios de monitoreos de cosechadoras suscriptos (USD)
                            </h4>
                            </a>
                        </div>
                        <!-- Card body -->
                        <div id="collapseTen" class="collapse" role="tabpanel" aria-labelledby="headingTen"
                            data-parent="#accordionEx1">
                            <div class="card-body">
                                <div class="table-responsive-md">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                            <th scope="col">FY y Servicio monitoreo</th>
                                            <th scope="col">USD de servicio suscripto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @for($i = 0; $i <= $diff; $i++)
                                            @for($x = 0; $x < 8; $x++)
                                                <tr>
                                                    <th scope="row">{{ $año_FY[$i] }} {{ $servicio[$x] }}</th>
                                                    <th scope="row">{{ number_format($serv_usd[$i][$x],0) }} USD</th>
                                                </tr>
                                            @endfor
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Accordion card -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chart_serv_usd"></div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(window).resize(function(){
    drawChart();
    });

      google.charts.load("current", {packages:['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          /////////------ GRAFICO TIPO MAQUINA SALA-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_equipo; $i++)
                ['{{ $tipo[$i] }}', {{ number_format($cantidad_tipo[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#C0392B","#212F3D","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#8E44AD"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_equipo'));
          chart.draw(data, options);


          // GRAFICO MONITOREOS SALA
        var data = google.visualization.arrayToDataTable([
          ['Month','Monitoreado ', 'Total '],
          @for ($i=0; $i < $rep_equipo; $i++)
            [' {{$tipo[$i]}} ', {{ $monitoreos[$i] }},  {{$cantidad_tipo[$i]}} ],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

                var options = {
                backgroundColor: { fill:'transparent' },
                height:'300',
                chartArea:{top:20,bottom:40,width:"93%",height:"100%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#C0392B","#212F3D"],
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_monitoreo_sala'));
                chart.draw(view, options);



          /////////------ GRAFICO RENOVACION MONITOREO-------////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
                ['Renovación', {{ $total_renov }}],
                ['Sin renovar', {{ $total_monitoreo }}],
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#C0392B","#212F3D","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#8E44AD"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_renovacion'));
          chart.draw(data, options);



////////////////////////////////   COSECHADORA    ///////////////////////////////////////////////////



        ///////// ------ GRAFICO CANTIDAD DE COSECHADORAS POR SUCURSAL------- //////////
          var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_cose; $i++)
                ['{{ $nomb_sucu_c[$i] }}', {{ number_format($cant_c[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_cosechadora_sucu'));
          chart.draw(data, options);


           // GRAFICO MONITOREOS VIGENTES COSECHADORA
        var data = google.visualization.arrayToDataTable([
          ['Month','Monitoreado ', 'Total '],
          @for ($i=0; $i < $rep_cose; $i++)
            [' {{$nomb_sucu_c[$i]}} ', {{ number_format($monitoreo_vigente_c[$i],0) }},  {{number_format($cant_c[$i],0)}} ],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

        var options = {
                backgroundColor: { fill:'transparent' },
                height:'300',
                chartArea:{top:20,bottom:40,width:"93%",height:"100%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#C0392B","#212F3D"],
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_monitoreo_cosechadora'));
                chart.draw(view, options);


                // GRAFICO RENOVACION COSECHADORA
                var data = google.visualization.arrayToDataTable([
                        ['Month','Renovacion FY {{$año}}', 'Monitoreo FY {{$añopasado}}'],
                        @for ($i=0; $i < $rep_cose; $i++)
                            [' {{$nomb_sucu_c[$i]}} ', {{ number_format($monitoreo_renov_c[$i],0) }},  {{number_format($cant_FY_cosechadora[$i],0)}} ],
                        @endfor
                        ]);

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2,
                        { calc: "stringify",
                        sourceColumn: 2,
                        type: "string",
                        role: "annotation" }
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_renovacion_cosechadora'));
                chart.draw(view, options);
        



            ////////////////////////////////   TRACTORES    ///////////////////////////////////////////////////



        ///////// ------ GRAFICO CANTIDAD DE TRACTORES POR SUCURSAL------- //////////
        var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_tractor; $i++)
                ['{{ $nomb_sucu_t[$i] }}', {{ number_format($cant_t[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_tractor_sucu'));
          chart.draw(data, options);


        // GRAFICO MONITOREOS VIGENTES TRACTORES
        var data = google.visualization.arrayToDataTable([
          ['Month','Monitoreado ', 'Total '],
          @for ($i=0; $i < $rep_tractor; $i++)
            [' {{$nomb_sucu_t[$i]}} ', {{ number_format($monitoreo_vigente_t[$i],0) }},  {{number_format($cant_t[$i],0)}} ],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

        var options = {
                backgroundColor: { fill:'transparent' },
                height:'300',
                chartArea:{top:20,bottom:40,width:"93%",height:"100%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#C0392B","#212F3D"],
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_monitoreo_tractor'));
                chart.draw(view, options);


                // GRAFICO RENOVACION TRACTORES
                var data = google.visualization.arrayToDataTable([
                    ['Month','Renovacion FY {{$año}}', 'Monitoreo FY {{$añopasado}}'],
                        @for ($i=0; $i < $rep_tractor; $i++)
                            [' {{$nomb_sucu_t[$i]}} ', {{ number_format($monitoreo_renov_t[$i],0) }},  {{number_format($cant_FY_tractor[$i],0)}} ],
                        @endfor
                        ]);

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2,
                        { calc: "stringify",
                        sourceColumn: 2,
                        type: "string",
                        role: "annotation" }
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_renovacion_tractor'));
                chart.draw(view, options);






       

          

        ////////////////////////////////   PULVERIZADORA   ///////////////////////////////////////////////////



        ///////// ------ GRAFICO CANTIDAD DE PULVERIZADORA POR SUCURSAL------- //////////
        var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_pulv; $i++)
                ['{{ $nomb_sucu_p[$i] }}', {{ number_format($cant_p[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_pulverizadora_sucu'));
          chart.draw(data, options);


           // GRAFICO MONITOREOS VIGENTESPULVERIZADORA
        var data = google.visualization.arrayToDataTable([
          ['Month','Monitoreado ', 'Total '],
          @for ($i=0; $i < $rep_pulv; $i++)
            [' {{$nomb_sucu_p[$i]}} ', {{ number_format($monitoreo_vigente_p[$i],0) }},  {{number_format($cant_p[$i],0)}} ],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

        var options = {
                backgroundColor: { fill:'transparent' },
                height:'300',
                chartArea:{top:20,bottom:40,width:"93%",height:"100%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#C0392B","#212F3D"],
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_monitoreo_pulverizadora'));
                chart.draw(view, options);


                // GRAFICO RENOVACIONPULVERIZADORA
                var data = google.visualization.arrayToDataTable([
                    ['Month','Renovacion FY {{$año}}', 'Monitoreo FY {{$añopasado}}'],
                        @for ($i=0; $i < $rep_pulv; $i++)
                            [' {{$nomb_sucu_p[$i]}} ', {{ number_format($monitoreo_renov_p[$i],0) }},  {{number_format($cant_FY_pulverizadora[$i],0)}} ],
                        @endfor
                        ]);

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2,
                        { calc: "stringify",
                        sourceColumn: 2,
                        type: "string",
                        role: "annotation" }
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_renovacion_pulverizadora'));
                chart.draw(view, options);
        





           ////////////////////////////////   PULVERIZADORA PLA  ///////////////////////////////////////////////////



        ///////// ------ GRAFICO CANTIDAD DE PULVERIZADORA PLA POR SUCURSAL------- //////////
        var data = new google.visualization.arrayToDataTable([
            ['Estado', 'Horas'],
            @for ($i=0; $i < $rep_pla; $i++)
                ['{{ $nomb_sucu_pp[$i] }}', {{ number_format($cant_pp[$i],0) }}],
            @endfor
            ]);

          var options = {
          legend: { position: 'bottom', maxLines: 3},
          backgroundColor: { fill:'transparent' },
          pieHole:0,
          colors: ["#F39C12", "#D35400","#7F8C8D","#212F3D","#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F"],
          height:'300',
          chartArea:{top:10,bottom:50,width:"90%",height:"100%"},
          selectionMode: 'multiple',
          tooltip: {trigger: 'selection'},
          aggregationTarget: 'category',
          };

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_pulvepla_sucu'));
          chart.draw(data, options);


           // GRAFICO MONITOREOS VIGENTESPULVERIZADORA PLA
        var data = google.visualization.arrayToDataTable([
          ['Month','Monitoreado ', 'Total '],
          @for ($i=0; $i < $rep_pla; $i++)
            [' {{$nomb_sucu_pp[$i]}} ', {{ number_format($monitoreo_vigente_pp[$i],0) }},  {{number_format($cant_pp[$i],0)}} ],
          @endfor
        ]);

        var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2,
                { calc: "stringify",
                  sourceColumn: 2,
                  type: "string",
                  role: "annotation" }
                ]);

        var options = {
                backgroundColor: { fill:'transparent' },
                height:'300',
                chartArea:{top:20,bottom:40,width:"93%",height:"100%"},
                legend: {position: 'top', maxLines: 3},
                hAxis: {
                  minValue: 0
                },
                seriesType: 'bars',
                colors: ["#C0392B","#212F3D"],
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_monitoreo_pulvepla'));
                chart.draw(view, options);


                // GRAFICO RENOVACION PULVERIZADORA PLA
                var data = google.visualization.arrayToDataTable([
                    ['Month','Renovacion FY {{$año}}', 'Monitoreo FY {{$añopasado}}'],
                        @for ($i=0; $i < $rep_pla; $i++)
                            [' {{$nomb_sucu_pp[$i]}} ', {{ number_format($monitoreo_renov_pp[$i],0) }},  {{number_format($cant_FY_pulvepla[$i],0)}} ],
                        @endfor
                        ]);

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                        2,
                        { calc: "stringify",
                        sourceColumn: 2,
                        type: "string",
                        role: "annotation" }
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_renovacion_pulvepla'));
                chart.draw(view, options);


                //GRAFICO DE SERVICIOS DE PAQUETE DE MONITOREO
                var data = google.visualization.arrayToDataTable([
                  ['Year',
                @for ($i=0; $i <= $diff; $i++)
                        '{{$año_FY[$i]}}',
                @endfor
                    ],
                  @for ($i=0; $i < 8; $i++)
                    ['{{$servicio[$i]}}',
                    @for ($x=0; $x <= $diff; $x++)
                        {{ number_format($cantidad_serv[$x][$i],0) }},
                    @endfor
                    ],
                  @endfor
                ]);

                var options = {
                legend: { position: 'bottom', maxLines: 3},
                  backgroundColor: { fill:'transparent' },
                  height:'300',
                  chartArea:{top:20,bottom:50,width:"93%",height:"80%"},
                  legend: {position: 'top', maxLines: 3},
                  colors: ["#C0392B","#8E44AD","#2980B9","#16A085","#27AE60","#F1C40F","#F39C12", "#D35400","#7F8C8D","#212F3D"],
                  selectionMode: 'multiple',
                  tooltip: {trigger: 'selection'},
                  aggregationTarget: 'category',
                };

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 
                        @for ($i=1; $i <= $diff + 1; $i++)
                        {{$i}}, 
                            { calc: "stringify",
                            sourceColumn: {{$i}},
                            type: "string",
                            role: "annotation" },
                        @endfor
                     
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_servicios_monitoreo'));
                chart.draw(view, options);


                //GRAFICO DE SERVICIOS DE PAQUETE DE MONITOREO USD
                var data = google.visualization.arrayToDataTable([
                  ['Year',
                @for ($i=0; $i <= $diff; $i++)
                        '{{$año_FY[$i]}}',
                @endfor
                    ],
                  @for ($i=0; $i < 8; $i++)
                    ['{{$servicio[$i]}}',
                    @for ($x=0; $x <= $diff; $x++)
                        {{ $serv_usd[$x][$i] }},
                    @endfor
                    ],
                  @endfor
                ]);

                var view = new google.visualization.DataView(data);
                        view.setColumns([0, 
                        @for ($i=1; $i <= $diff + 1; $i++)
                        {{$i}}, 
                            { calc: "stringify",
                            sourceColumn: {{$i}},
                            type: "string",
                            role: "annotation" },
                        @endfor
                     
                        ]);

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_serv_usd'));
                chart.draw(view, options);
        

        }

</script>

@endsection