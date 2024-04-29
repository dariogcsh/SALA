
    @foreach($eventos as $evento)
         @if(($evento->fechainicio >= $hoyf) AND ($evento->fechafin <= $hoyf) AND ($cant >= 0))
             @php
                 $cant++;
                 $fecha++;
                 $verde++;
             @endphp
         @endif
         @if(($evento->fechainicio >= $hoyf) AND ($evento->fechafin <= $hoyf) AND ($cant > 1))
             @php
                 $fecha++;
                 $negro++;
             @endphp
         @endif
    @endforeach
    @if($negro > 0)
    <th scope="row" bgcolor="black">
         <b style="background-color:black;"><a id="{{ $i }}" class="click" style="color:white">{{ $i }}</a></b>
     @elseif(($verde > 0))
     <th scope="row" bgcolor="green">
         <b style="background-color:green;"><a id="{{ $i }}" class="click" style="color:white">{{ $i }}</a></b>
    @else
    <th scope="row">
    @endif
    @foreach($jdus as $jdu)
         @if(($jdu->fechainicio >= $hoyf) AND ($jdu->fechafin <= $hoyf) AND ($fecha == 0))
             <b><a id="{{ $i }}" class="click" style="color:black">{{ $i }}</a></b><img src="{{ asset('/imagenes/aamarillo.png') }}"  height="20">
             @php
                 $fecha++;
             @endphp
         @elseif(($jdu->fechainicio >= $hoyf) AND ($jdu->fechafin <= $hoyf) AND ($fecha > 0))
             <img src="{{ asset('/imagenes/aamarillo.png') }}"  height="20">
             @php
                 $fecha++;
             @endphp
         @endif
    @endforeach
    @if($fecha == 0)
         <b>{{ $i }} </b>
    @endif
 </th>