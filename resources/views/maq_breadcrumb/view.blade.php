@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>Ubicación</h2></div>

                <div class="card-body">
                <form action="" method="post">
                    @csrf
                        <div class="container">
                            @isset($maq_breadcrumb->lat)
                                @isset($maq_breadcrumb->lon)
                                            <iframe class="iframe" src="https://maps.google.com/?q={{ $maq_breadcrumb->lat }},{{ $maq_breadcrumb->lon }}&z=14&t=k&output=embed" height="450" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                                @endisset
                            @endisset
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection