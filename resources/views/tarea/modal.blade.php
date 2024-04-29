    @php
    use App\tarea;
    use App\sucursal;
    use App\organizacion;
    use App\maquina;
    use App\User;
    use App\planservicio;

        $tarea = Tarea::where('id',$tareas)->first();
        $sucursals = Sucursal::orderBy('id','asc')->get();
        $organizaciones = Organizacion::orderBy('NombOrga','asc')->get();
        $maquinas = Maquina::where('CodiOrga',$tarea->id_organizacion)->get();
        $sucursal = Organizacion::where('id',$tarea->id_organizacion)->first();
        $tecnicos = User::select('users.id','users.name','users.last_name')
                        ->join('organizacions','users.CodiOrga','=','organizacions.id')
                        ->join('puesto_empleados','users.CodiPuEm','=','puesto_empleados.id')
                        ->where([['users.CodiSucu',$sucursal->CodiSucu], ['puesto_empleados.NombPuEm','Tecnico']])->get();

        $planservicios = Planservicio::where('id_tarea',$tarea->id)->get();
    @endphp                    
                      <!-- Button to trigger modal -->
<button class="btn btn-lg" data-toggle="modal" data-target="#modalForm{{ $tarea->id }}">
    <i class="fas fa-ellipsis-v"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="modalForm{{ $tarea->id }}" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form method="POST" action="{{ url('/tarea/'.$tarea->id) }}">
                @csrf
                @method('patch')
                @include('tarea.form', ['modo'=>'modificar', 'tarea' => $tarea, 'sucursals' => $sucursals,
                        'organizaciones' => $organizaciones, 'maquinas' => $maquinas, 'sucursal' => $sucursal, 
                        'tecnicos' => $tecnicos,'planservicios' => $planservicios])
            </form>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        //Es para el formato de select multiple
        $("#id_tecnico").multipleSelect({
                            filter: true
        });
    
        $('#id_organizacion').change(function(){   
            if ($(this).val() != ''){ 
                var select = 'CodiOrga';
                var selecttec = 'id';
                var value = $(this).val();           
                var _token = $('input[name="_token"]').val(); 
                $.ajax({
                    url:"{{ route('utilidad.fetch') }}",
                    method:"POST",
                    data:{select:select, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#nseriemaq').html(result);
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intentelo más tarde");
                    }
                })
                $.ajax({
                    url:"{{ route('tarea.selecttecnico') }}",
                    method:"POST",
                    data:{select:selecttec, value:value, _token:_token},
                    success:function(result)
                    {
                        $('#id_tecnico').html(result);
                        $("#id_tecnico").multipleSelect({
                            filter: true
                        });
                    },
                    error:function(){
                        alert("Ha ocurrido un error, intentelo más tarde");
                    }
                })
                
            }
               
        });
        //Cuando se modifique la fecha de inicio del plan, se asigna la misma fecha de finalizacion automaticamente
        $('#fechaplan').change(function(){ 
            if ($(this).val() != ''){ 
                var fecha = $(this).val();
                $('#fechafin').val(fecha);
            }
        });
    
    });
    
    function mostrarInputOrga() {
            organizacion = document.getElementById("organizacion_nueva");
            organizacion.style.display='block';
    }
    function mostrarInputMaq() {
            maquina = document.getElementById("maquina_nueva");
            maquina.style.display='block';
    }
    
    </script>