@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Añadir Rol</h2></div>

                <div class="card-body">
                @include('custom.message')
                    
                    <form action="{{ route('role.store') }}" method="post">
                    @csrf

                        <div class="container">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Nombre" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{ old('slug') }}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control-textarea" id="description" rows="3" placeholder="Descripcion" name="description"  value="Descripcion">{{ old('description') }}</textarea>
                            </div>
                            <hr>
                            <h3>Acceso Completo</h3>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="full-access" id="fullaccessyes" value="yes"
                                @if (old('full-access')=="yes")
                                    checked 
                                @endif
                                >
                                <label class="form-check-label" for="fullaccessyes">SI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="full-access" id="fullaccessno" value="no" 
                                @if (old('full-access')=="no")
                                    checked 
                                @endif
                                @if (old('full-access')===null)
                                    checked 
                                @endif
                                >
                                <label class="form-check-label" for="fullaccessno">NO</label>
                            </div>
                            <hr>
                            <h3>Permisos</h3>

                            @foreach($permissions as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @endif
                                >
                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                {{ $permission->id }}
                                -
                                {{ $permission->name }}
                                <em>[ {{ $permission->description }} ]</em>
                                
                                </label>
                            </div>
                            @endforeach
                            <hr>
                            <input type="submit" class="btn btn-success" value="Guardar">
                        </div>

                    </form>
 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection