@php
    use App\cosecha;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Resumen periódico de cosecha</h2></div>
                <div class="card-body">
                    <h3>{{ date('d/m/Y',strtotime($cosecha->fin)) }}</h3>
                    <hr>
                    <small>* En este día se recibieron los siguientes datos:</small>
                    <br>
                        @foreach($cultivos as $cultivo)
                            @php
                                $lotes = Cosecha::distinct('campo')
                                                ->where([['fin',$cosecha->fin], ['organizacion', $cosecha->organizacion], 
                                                        ['cultivo', $cultivo->cultivo]])->count();
                                $has = Cosecha::where([['fin',$cosecha->fin], ['organizacion', $cosecha->organizacion], 
                                                    ['cultivo', $cultivo->cultivo]])->sum('superficie');
                                $rinde = Cosecha::where([['fin',$cosecha->fin], ['organizacion', $cosecha->organizacion], 
                                                    ['cultivo', $cultivo->cultivo]])->sum('rendimiento');
                                if (!empty($has)) {
                                    $rindeprom = $rinde / $has;
                                } else {
                                    $rindeprom = 0;
                                }
                                $humedad = Cosecha::where([['fin',$cosecha->fin], ['organizacion', $cosecha->organizacion], 
                                                ['cultivo', $cultivo->cultivo]])->avg('humedad');

                            @endphp
                            <br>
                            @if ($lotes <> 0)
                            <div class="title-Cosecha"><h5>COSECHA</h5></div>
                            <br>
                            @if ($cultivo->cultivo <> 'NULL')
                                <h3>{{ $cultivo->cultivo }}</h3>
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5> Cant. de lotes</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ $lotes }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                    <div class="card mb-3 border-dark">
                                        <div class="card-header text-center text-white bg-dark">
                                            <h5>Hectáreas</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <h4>{{ number_format($has,1) }} Has.</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Rinde prom.</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($rindeprom,2) }} t/has.</h4>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Humedad</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($humedad,1) }} %</h4>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="card mb-3 border-dark">
                                            <div class="card-header text-center text-white bg-dark">
                                                <h5>Rinde total</h5>
                                            </div>
                                            <div class="card-body text-center">
                                                <h4>{{ number_format($rinde,2) }} t</h4>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <br>
                            
                            @endif
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

