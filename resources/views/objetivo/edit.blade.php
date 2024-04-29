@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modificar objetivo') }}</div>

                <div class="card-body">
                
                    <form method="POST" action="{{ url('/objetivo/'.$objetivo->id) }}">
                        @csrf
                        @method('patch')

                        <div class="form-group row">
                            <label for="cultivo" class="col-md-4 col-form-label text-md-right">{{ __('Cultivo') }} *</label>
                            <div class="col-md-6">
                            <select class="form-control @error('cultivo') is-invalid @enderror" name="cultivo" id="cultivo" value="{{ old('cultivo') }}" autofocus> 
                                @isset($objetivo->cultivo)
                                    <option value="{{ $objetivo->cultivo }}">{{ $objetivo->cultivo }}</option>
                                @endisset
                                <option value="Soja">Soja</option>
                                <option value="Maíz">Maiz</option>
                                <option value="Trigo">Trigo</option>
                                <option value="Girasol">Girasol</option>
                            </select>
                                @error('cultivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="objetivo" class="col-md-4 col-form-label text-md-right">{{ __('Objetivo') }} *</label>

                            <div class="col-md-6">
                                <input id="objetivo" type="number" step="0.01" class="form-control @error('objetivo') is-invalid @enderror" name="objetivo" value="{{ isset($objetivo->objetivo)?$objetivo->objetivo:old('objetivo') }}" required autocomplete="objetivo" autofocus>

                                @error('objetivo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                {{ __('Modificar') }}
                                  
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection