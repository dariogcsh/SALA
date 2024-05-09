@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Subir trabajos de cosecha') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/importar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="archivo_excel" class="col-md-4 col-form-label text-md-right">{{ __('Archivo Excel') }} *</label>
                    
                            <div class="col-md-6">
                                <input id="archivo_excel" type="file" class="form-control-file" name="archivo_excel" autofocus required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">Importar Excel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection