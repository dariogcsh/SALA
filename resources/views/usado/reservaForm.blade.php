@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reservar') }}</div>
                <div class="card-body">
                    <form action="{{ route('usado.reservado') }}" method="post">
                        @csrf
                        <input type="text" hidden value="{{ $id_usado }}" id="id_usado" name="id_usado">
                            <div class="form-group row">
                                <label for="fechahasta" class="col-md-4 col-form-label text-md-right">{{ __('Reservar hasta') }} *</label>
    
                                <div class="col-md-6">
                                    <input id="fechahasta" type="date" class="form-control @error('fechahasta') is-invalid @enderror" name="fechahasta" value="{{ isset($usado->fechahasta)?$usado->fechahasta:old('fechahasta') }}" autofocus>
    
                                    @error('fechahasta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <input type="text" hidden value="{{ auth()->user()->id }}" id="id_vreserva" name="id_vreserva">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">Reservar</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection