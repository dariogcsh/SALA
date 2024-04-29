@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cargar archivo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/calendario/subir') }}" enctype="multipart/form-data">
                        @csrf
                        <h4 class="text-center">Cargar Archivos</h4>
                        <input type="text" hidden value="{{ $id }}" id="id_calendario" name="id_calendario">
                        <div class="form-group row">
                            <label for="externos" class="col-md-2 col-form-label text-md-right">Fotos</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple="">
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-success">Cargar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
