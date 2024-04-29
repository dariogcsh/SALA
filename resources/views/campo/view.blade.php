@php
    use App\campo;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Resumen periódico</h2></div>
                <div class="card-body">
                    <h3>{{ date('d/m/Y',strtotime($campo->op_fin)) }}</h3>
                    <hr>
                    <small>* En este día se recibieron los siguientes datos:</small>
                    <br>
                    @foreach($trabajos as $trabajo)
                    
                        @php
                            $cultivos = Campo::where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id], ['op_type',$trabajo->op_type]])->get();
                        //dd($cultivos);
                        @endphp
                        @foreach($cultivos as $cultivo)
                            @php
                                $lotes = Campo::distinct('field_id')
                                                ->where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id], 
                                                        ['op_type',$trabajo->op_type],['op_crop',$cultivo->op_crop]])->count();
                                $has = Campo::where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id], 
                                                    ['op_type',$trabajo->op_type],['op_crop',$cultivo->op_crop]])->sum('op_ha');
                                $rinde = Campo::where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id], 
                                                    ['op_type',$trabajo->op_type],['op_crop',$cultivo->op_crop]])->sum('op_rinde');
                                if (!empty($has)) {
                                    $rindeprom = $rinde / $has;
                                } else {
                                    $rindeprom = 0;
                                }
                                $humedad = Campo::where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id],
                                                        ['op_type',$trabajo->op_type],['op_crop',$cultivo->op_crop]])->avg('op_hum');


                               /* $sqllotes = Campo::distinct('field_id')
                                                ->where([['op_fin',$campo->op_fin], ['org_id', $campo->org_id], 
                                                        ['op_type',$trabajo->op_type],['op_crop',$cultivo->op_crop]])->get();
                                */
                                // Traduccion de trabajos y cultivos
                                if ($trabajo->op_type == "harvest") {
                                   $trabajo->op_type = "Cosecha";
                                } elseif ($trabajo->op_type == "seeding"){
                                    $trabajo->op_type = "Siembra";
                                } elseif ($trabajo->op_type == "application"){
                                    $trabajo->op_type = "Aplicacion";
                                } elseif ($trabajo->op_type == "tillage"){
                                    $trabajo->op_type = "Laboreo"; 
                                }
                                if(stripos($cultivo->op_crop, "CORN") !== false){
                                    $cultivo->op_crop = "Maíz";
                                }elseif(stripos($cultivo->op_crop, "SOYBEANS") !== false){
                                    $cultivo->op_crop = "Soja";
                                }elseif(stripos($cultivo->op_crop, "WHEAT") !== false){
                                    $cultivo->op_crop = "Trigo";
                                }elseif(stripos($cultivo->op_crop, "RYE") !== false){
                                    $cultivo->op_crop = "Centeno";
                                }elseif(stripos($cultivo->op_crop, "BARLEY") !== false){
                                    $cultivo->op_crop = "Cebada";
                                }elseif(stripos($cultivo->op_crop, "SORGHUM") !== false){
                                    $cultivo->op_crop = "Sorgo";
                                }elseif(stripos($cultivo->op_crop, "SUNFLOWER") !== false){
                                    $cultivo->op_crop = "Girasol";
                                }elseif(stripos($cultivo->op_crop, "OATS") !== false){
                                    $cultivo->op_crop = "Avena";
                                }

                            @endphp
                            <br>
                            @if ($lotes <> 0)
                            <div class="title-{{ $trabajo->op_type }}"><h5>{{ $trabajo->op_type }}</h5></div>
                            <br>
                            @if ($cultivo->op_crop <> 'NULL')
                                <h3>{{ $cultivo->op_crop }}</h3>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5> Cant. de lotes</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ $lotes }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Hectáreas</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($has,1) }} Has.</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    @if($trabajo->op_type == "Cosecha")
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Rinde prom.</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($rindeprom,2) }} t/has.</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-3">
                                    @if($trabajo->op_type == "Cosecha")
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Humedad</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($humedad,1) }} %</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                         
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    @if($trabajo->op_type == "Cosecha")
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Rinde total</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($rinde,2) }} t</h4>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <br>
                            
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

