
@isset($tecnico)
    @if($tarea->id_user == $tecnico->id)
    <img class="img img-responsive float-left" src="/imagenes/TRACTOR.png" height="25px">
    @if($tarea->prioridad == "Alta")
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alerterror.png" height="13px">
    @elseif($tarea->prioridad == "Media")
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alertwarning.png" height="13px">
    @else
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alertinformation.png" height="13px">
    @endif
    @isset($tarea->ncor)
        <i class="float-left"> - N° COR: {{ $tarea->ncor }}</i>
    @endisset
    @if($tarea->turno == "Mañana")
        <h6 style="text-align: right">M</h6>
    @elseif($tarea->turno == "Mañana y tarde")
        <h6 style="text-align: right">M-T</h6>
    @else
        <h6 style="text-align: right">T</h6>
    @endif
    @if($tarea->estado == "Esperando autorización")
            <h6 style="text-align: right">(Autorización)</h6>
        @elseif($tarea->estado == "Esperando pieza")
            <h6 style="text-align: right">(Pieza)</h6>
        @endif
        <!-- Se incluye la vista "card.blade.php" -->
        @include('tarea.card')
    @endif
@else
    <img class="img img-responsive float-left" src="/imagenes/TRACTOR.png" height="25px">
    @if($tarea->prioridad == "Alta")
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alerterror.png" height="13px">
    @elseif($tarea->prioridad == "Media")
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alertwarning.png" height="13px">
    @else
        <img class="img img-responsive float-left" style="margin-top: 5px" src="/imagenes/alertinformation.png" height="13px">
    @endif
    @if($tarea->turno == "Mañana")
        <h6 style="text-align: right">M</h6>
    @elseif($tarea->turno == "Mañana y tarde")
        <h6 style="text-align: right">M-T</h6>
    @else
        <h6 style="text-align: right">T</h6>
    @endif
        <!-- Se incluye la vista "card.blade.php" -->
        @include('tarea.card')
@endif