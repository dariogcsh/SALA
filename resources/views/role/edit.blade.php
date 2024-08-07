@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>Editar Rol</h2></div>

                <div class="card-body">
                @include('custom.message')
                    
                    <form action="{{ route('role.update', $role->id) }}" method="post">
                    @csrf
                    @method('put')

                        <div class="container">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder="Nombre" name="name" value="{{ old('name', $role->name) }}">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug" value="{{ old('slug', $role->slug) }}">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control-textarea" id="description" rows="3" placeholder="Descripcion" name="description"  value="Descripcion">{{old('description', $role->description)}}</textarea>
                            </div>
                            <hr>
                            <h3>Acceso Completo</h3>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="full-access" id="fullaccessyes" value="yes"
                                @if ($role['full-access']=="yes")
                                    checked 
                                @elseif (old('full-access')=="yes")
                                    checked 
                                @endif
                                >
                                <label class="form-check-label" for="fullaccessyes">SI</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="full-access" id="fullaccessno" value="no" 
                                @if ($role['full-access']=="no")
                                    checked 
                                @elseif (old('full-access')=="no")
                                    checked 
                                @endif
                                
                                >
                                <label class="form-check-label" for="fullaccessno">NO</label>
                            </div>
                            <hr>
                            <h3>Permisos</h3>
                            <br>
                            <h5><u>Visualizar</u></h5>
                            @foreach($permissionsver as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role ))
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
                            <br>

                            <h5><u>Crear</u></h5>
                            @foreach($permissionscrear as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role ))
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
                            <br>

                            <h5><u>Editar</u></h5>
                            @foreach($permissionseditar as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role ))
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
                            <br>

                            <h5><u>Vista detallada</u></h5>
                            @foreach($permissionsdetalle as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role ))
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
                            <br>

                            <h5><u>Eliminar</u></h5>
                            @foreach($permissionseliminar as $permission)
                            <div class="form-check form-check">
                                <input class="form-check-input" type="checkbox" id="permission_{{ $permission->id }}" value="{{ $permission->id }}" name="permission[]"
                                @if(is_array(old('permission')) && in_array("$permission->id", old('permission') ))
                                    checked
                                @elseif(is_array($permission_role) && in_array("$permission->id", $permission_role ))
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
                            <br>

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