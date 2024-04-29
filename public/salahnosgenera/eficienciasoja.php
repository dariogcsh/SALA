<?php session_start(); ?>
<!doctype html>
<html>
<head>
   <?php 
      
      //include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      include("funciones/info_eficiencia.php");
      $res = new Eficiencia;
      if(isset($_GET["maq"])){
        $maquina = $_GET["maq"];
        $opt = $_GET["periodo"];
        $idorganizacion = $_GET["cboorg"];
        $desde = array();
        $hasta = array();
        $desde[0] = $_GET["desde1"];
        $hasta[0] = $_GET["hasta1"];
        $desde[1] = $_GET["desde2"];
        $hasta[1] = $_GET["hasta2"];
        $desde[2] = $_GET["desde3"];
        $hasta[2] = $_GET["hasta3"];
        $desde[3] = $_GET["desde4"];
        $hasta[3] = $_GET["hasta4"];
        $desde[4] = $_GET["desde5"];
        $hasta[4] = $_GET["hasta5"];
        $desde[5] = $_GET["desde6"];
        $hasta[5] = $_GET["hasta6"];
        $desde[6] = $_GET["desde7"];
        $hasta[6] = $_GET["hasta7"];
        $desde[7] = $_GET["desde8"];
        $hasta[7] = $_GET["hasta8"];
        $desde[8] = $_GET["desde9"];
        $hasta[8] = $_GET["hasta9"];
        $desde[9] = $_GET["desde10"];
        $hasta[9] = $_GET["hasta10"];
        $finicio = $desde[0];
        $optfin = $opt-1;
        $ffin = $hasta[$optfin];
        //$medida = $_GET["medida"];
        //$UM = $_GET["ancho"];
      }
      $url = "https://agrotecnologiasala.com.ar/eficienciasoja.php?desde1=".$desde[0]."%26hasta1=".$hasta[0]."%26desde2=".$desde[1]."%26hasta2=". $hasta[1] ."%26desde3=". $desde[2] ."%26hasta3=". $hasta[2] ."%26desde4=". $desde[3] ."%26hasta4=". $hasta[3] ."%26desde5=". $desde[4] ."%26hasta5=". $hasta[4] ."%26desde6=". $desde[5] ."%26hasta6=". $hasta[5] ."%26desde7=". $desde[6] ."%26hasta7=". $hasta[6] ."%26desde8=". $desde[7] ."%26hasta8=". $hasta[7] ."%26desde9=". $desde[8] ."%26hasta9=". $hasta[8] ."%26desde10=". $desde[9] ."%26hasta10=". $hasta[9] ."%26cboorg=". $idorganizacion ."%26periodo=". $opt ."%26maq=". $maquina ."";

      ?>
      
  <title>Eficiencia de máquina</title> 
  <LINK REL=StyleSheet HREF="chart.css" TYPE="text/css">
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
 
        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>
    
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <!-- jsPDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <script type="text/javascript">
      //Generacion de PDF
      function genPDF(){
        html2canvas(document.getElementById("content"), {
            onrendered: function(canvas) {

                var imgData = canvas.toDataURL('image/png');
                console.log('Report Image URL: '+imgData);
                var doc = new jsPDF('p', 'mm', [10000, 800]); //height - width
                
                doc.addImage(imgData, 'PNG', 10, 10);
                doc.save('sample.pdf');
            }
        });
      }

      function enviar_email(){
        //window.location="maileficiencia.php";
        var orga = '<?php echo $idorganizacion; ?>';
        var url = '<?php echo $url; ?>';
        var cultivo = 'SOJA';
        var dataString = 'CodiOrga='+orga+'&url='+url+'&cultivo='+cultivo;
                            $.ajax({
                                type: "POST",
                                url: "mail/maileficiencia.php",
                                data: dataString,
                                success: function(resp){
                                  alert(resp);
                                }
                            });
      }
      function guardar_informe(){
        //window.location="maileficiencia.php";
        var orga = '<?php echo $idorganizacion; ?>';
        var url = '<?php echo $url; ?>';
        var cultivo = 'SOJA';
        var maq = '<?php echo $maquina; ?>';
        var finicio = '<?php echo $finicio; ?>';
        var ffin = '<?php echo $ffin; ?>';
        var tipoinf = 'Eficiencia';
        var dataString = 'CodiOrga='+orga+'&url='+url+'&cultivo='+cultivo+'&maq='+maq+'&finicio='+finicio+'&ffin='+ffin+'&tipoinf='+tipoinf;
                            $.ajax({
                                type: "POST",
                                url: "funciones/guardarinforme.php",
                                data: dataString,
                                success: function(resp){
                                  alert(resp);
                                }
                            });
      }

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {


    <?php 
    
    
              //Defino unas variables de datos acumulados
              $organizacion = $res->ver_organizacion($idorganizacion);
              

              $ralentihr = 0;
              $trabajandohr = 0;
              $transportehr = 0;

              $segmento = substr($maquina,3,4);
              $matriz = array();
              $array = array();
              $array = $res->l_segmento($segmento);
              // Comienza a generar el array con los numeros de serie de las maquinas del segmento seleccionado
              $i = 0;
              while ($fila = mysqli_fetch_array($array)) {
                $matriz[$i]["NumSMaq"] = $fila["NumSMaq"];
                $matriz[$i]["TipoMaq"] = $fila["TipoMaq"];
                 //guardo la posicion del valor
                if ($maquina == $fila["NumSMaq"]) {
                  $p = $i; //guardo la posicion donde se encuentra la máquina en el array
                }
                $i++;
              }
              $cantmaq = $i;


              for ($z=0; $z <= $opt; $z++) {

                  //Este IF es para el periodo ACUMULADO
                  if ($z == $opt) {
                    $desde[$z] = $finicio;
                    $hasta[$z] = $ffin;
                  }


                  // ---------------------------------HR RALENTI------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Ralentí",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrralenti"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrralenti"] = 0;
                    }
                   ;
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array


                  // ---------------------------------HR TRANSPORTE------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Transporte",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtransporte"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtransporte"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR TRABAJANDO------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Trabajando",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtrabajando"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtrabajando"] = 0;
                    }
                    $matriz[$i]["hrtotal"] = $matriz[$i]["hrtrabajando"] + $matriz[$i]["hrtransporte"] + $matriz[$i]["hrralenti"];
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // -----------------------------HR RALENTI CON TOLVA NO LLENA------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Ralentí con depósito de grano no lleno",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtolvavacia"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtolvavacia"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                   // ---------------------------------HR RALENTI CON TOLVA LLENA------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Ralentí con depósito de grano lleno",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtolvallena"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtolvallena"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR SEPARADOR DE VIRAJES------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Separador de virajes en cabecero engranado",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrseparador"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrseparador"] = 0;
                    }
                    if ($matriz[$i]["hrtrabajando"] > 1 AND $matriz[$i]["hrralenti"] <> 0) {
                      $matriz[$i]["ralentiporc"] = $matriz[$i]["hrralenti"] / $matriz[$i]["hrtotal"] * 100 ;
                      if ($z == $opt AND $matriz[$i]["ralentiporc"] > 5) {
                        $aux = $matriz[$i]["ralentiporc"];
                        $ralentiparr[$e] = number_format($aux, 2, '.','');
                        $e++;
                      }
                    } else {
                      $matriz[$i]["ralentiporc"] = 0;
                    }
                    if ($matriz[$i]["hrtrabajando"] > 1 AND $matriz[$i]["hrtolvallena"] <> 0) {
                      $matriz[$i]["ralentitllenaporc"] = $matriz[$i]["hrtolvallena"] / $matriz[$i]["hrtotal"] * 100 ; 
                      if ($z == $opt AND $matriz[$i]["ralentitllenaporc"] > 0.1) {
                        $aux = $matriz[$i]["ralentitllenaporc"];
                        $ralentitlparr[$f] = number_format($aux, 2, '.','');
                        $f++;
                      }
                    } else {
                      $matriz[$i]["ralentitllenaporc"] = 0;
                    }
                    if ($matriz[$i]["hrtrabajando"] > 1 AND $matriz[$i]["hrtolvavacia"] <> 0) {
                      $matriz[$i]["ralentitvaciaporc"] = $matriz[$i]["hrtolvavacia"] / $matriz[$i]["hrtotal"] * 100 ;     
                      if ($z == $opt AND $matriz[$i]["ralentitvaciaporc"] > 4) {
                        $aux = $matriz[$i]["ralentitvaciaporc"];
                        $ralentitvparr[$g] = number_format($aux, 2, '.','');
                        $g++;
                      }
                    } else {
                      $matriz[$i]["ralentitvaciaporc"] = 0;
                    }
                    if ($matriz[$i]["hrtrabajando"] > 1 AND $matriz[$i]["hrseparador"] <> 0) {
                      $matriz[$i]["separadorporc"] = $matriz[$i]["hrseparador"] / $matriz[$i]["hrtotal"] * 100 ;
                      if ($z == $opt AND $matriz[$i]["hrseparador"] > 0.1) {
                        $aux = $matriz[$i]["separadorporc"];
                        $separadorparr[$h] = number_format($aux, 2, '.','');
                        $h++;
                      }
                    }
                    else {
                      $matriz[$i]["separadorporc"] = 0;
                    }
                      
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR COSECHA------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Cosecha",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrcosecha"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrcosecha"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR COSECHA- TOTAL-----------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia_total($segmento,"hr","Cosecha",$desde[$z],$hasta[$z]);
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrcosecha_total"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrcosecha_total"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR COSECHA Y DESCARGA------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Cosecha y descarga",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrcosechadescarga"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrcosechadescarga"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR COSECHA Y DESCARGA TOTAL------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia_total($segmento,"hr","Cosecha y descarga",$desde[$z],$hasta[$z]);
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrcosechadescarga_total"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrcosechadescarga_total"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------HR DESCARGANDO SIN COSECHAR------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Descarga no cosechando",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrdescarga"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrdescarga"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array


                  // ----------------------------HR TRANSPORTE A MAS DE 16 KM/HS------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Transporte a más de 16 km/h (10 mph) o interruptor de carretera conectado",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtransporte17"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtransporte17"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------HR TRANSPORTE A MENOS DE 16 KM/HS------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia($segmento,"hr","Transporte a menos de 16 km/h (10 mph), separador desconectado",$desde[$z],$hasta[$z],"Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["hrtransporte15"] = $valorarray2[$indice];
                    }
                    else {
                      $matriz[$i]["hrtransporte15"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array


                  // ---------------------------------KM/HR TRABAJANDO------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia_promedios($segmento,"km/hr","Trabajando",$desde[$z],$hasta[$z],"3","Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["kmtrabajando"] = $valorarray2[$indice];
                      if ($z == $opt) {
                        $velocidadarr[$a] = $valorarray2[$indice];
                        $a++;
                      }
                    }
                    else {
                      $matriz[$i]["kmtrabajando"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ---------------------------------L/HR TRABAJANDO------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia_promedios($segmento,"l/hr","Trabajando",$desde[$z],$hasta[$z],"10","Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["ltrabajando"] = $valorarray2[$indice];
                      if ($z == $opt) {
                        $ltrabajandoarr[$c] = $valorarray2[$indice];
                        $c++;
                      }
                    }
                    else {
                      $matriz[$i]["ltrabajando"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array

                  // ------------------------FACTOR DE CARGA DEL MOTOR------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->datos_eficiencia_promedios($segmento,"%","Trabajando",$desde[$z],$hasta[$z],"40","Tiempo en Soja");
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $aux = $fila["ValoUtil"];
                    $valorarray2[$o] = number_format($aux, 2, '.','');
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    if (in_array($matriz[$i]["NumSMaq"],$valorarray1)){
                      $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                      $matriz[$i]["factorcarga"] = $valorarray2[$indice];
                      if ($z == $opt) {
                        $factorcargaarr[$b] = $valorarray2[$indice];
                        $b++;
                      }
                    }
                    else {
                      $matriz[$i]["factorcarga"] = 0;
                    }
                  }
                  // Finaliza el calculo de los valores para cada maquina en el array


                  // --------------SUPERFICIE Y CONSUMO POR HA------------------------------
                  // Comienzo de calculo el valor correspondiente
                  $valorbuscado = $res->ancho_apero($segmento);
                  unset($valorarray1);
                  unset($valorarray2);
                  $o = 0;
                  while ($fila = mysqli_fetch_array($valorbuscado)) {
                    $valorarray1[$o] = $fila["NumSMaq"];
                    $valorarray2[$o] = $fila["CanPMaq"];
                    $o++;
                  }
                  // Recorres todas las maquinas del mismo modelo y asigna valor correspondiente
                  for ($i=0; $i < $cantmaq; $i++) {
                    
                        if (in_array($matriz[$i]["NumSMaq"],$valorarray1) AND $matriz[$i]["ltrabajando"] <> 0 AND $matriz[$i]["kmtrabajando"] <> 0){
                          $indice = array_search($matriz[$i]["NumSMaq"], $valorarray1);
                          $apero = $valorarray2[$indice];
                          if ($apero <> 0) {
                          $matriz[$i]["superficie"] = $apero*0.3048*$matriz[$i]["kmtrabajando"]*0.1;
                          $matriz[$i]["ltsconsumo"] = $matriz[$i]["ltrabajando"] / $matriz[$i]["superficie"];
                          } else {
                            $matriz[$i]["superficie"] = 0;
                            $matriz[$i]["ltsconsumo"] = 0;
                          }
                        }
                        else {
                          $matriz[$i]["superficie"] = 0;
                          $matriz[$i]["ltsconsumo"] = 0;
                        }
                      
                      if (($z == $opt) AND ($matriz[$i]["ltsconsumo"]<>0)) {
                            $superficiearr[$d] = $matriz[$i]["superficie"];
                            $consumoarr[$d] = $matriz[$i]["ltsconsumo"] ;
                            $d++;
                      }
                  }
                  if ($z == $opt) {
                    $hrtrabajando = $matriz[$p]["hrtrabajando"];
                    $hrralenti = $matriz[$p]["hrralenti"];
                    $hrtransporte = $matriz[$p]["hrtransporte"];
                    $hrcosecha = $matriz[$p]["hrcosecha"];
                    $hrcosechadescarga = $matriz[$p]["hrcosechadescarga"];
                    $hrcosecha_total = $matriz[$p]["hrcosecha_total"];
                    $hrcosechadescarga_total = $matriz[$p]["hrcosechadescarga_total"];
                    $hrdescarga = $matriz[$p]["hrdescarga"];
                    $hrseparador = $matriz[$p]["hrseparador"];
                    $hrtolvallena = $matriz[$p]["hrtolvallena"];
                    $hrtolvavacia = $matriz[$p]["hrtolvavacia"];
                    $hrtransporte17 = $matriz[$p]["hrtransporte17"];
                    $hrtransporte15 = $matriz[$p]["hrtransporte15"];
                    $tipomaq = $matriz[$p]["TipoMaq"];
                    $numeroserie = $matriz[$p]["NumSMaq"];
                     
                    //Datos de utilizacion de la tecnologia
                    $horasensoja = $res->horas_en($maquina, 'hr', 'Tiempo en Soja', 'Hora', $desde[$z], $hasta[$z]);
                    $horasensoja = number_format($horasensoja, 2, '.','');
                    $horascosecha = $hrcosecha_total + $hrcosechadescarga_total;

                    $autotrac = $res->horas_en($maquina, 'hr', 'AutoTrac', 'Enc', $desde[$z], $hasta[$z]);
                    $autotrac = number_format($autotrac, 2, '.','');

                    $velmolinete = $res->horas_en($maquina, 'hr', 'Velocidad auto de molinetes', 'Enc',$desde[$z], $hasta[$z]);
                    $velmolinete = number_format($velmolinete, 2, '.','');

                    $harvest = $res->horas_en($maquina, 'hr', 'Harvest Smart activado', 'Enc',$desde[$z], $hasta[$z]);
                    $harvest = number_format($harvest, 2, '.','');

                    $alturaplataforma = $res->horas_en($maquina, 'hr', 'Altura autom de plataforma de corte', 'Enc', $desde[$z], $hasta[$z]);
                    $alturaplataforma = number_format($alturaplataforma, 2, '.','');

                    $rowsense = $res->horas_en($maquina, 'hr', 'RowSense', 'Enc', $desde[$z], $hasta[$z]);
                    $rowsense = number_format($rowsense, 2, '.','');

                    $mantenerauto = $res->horas_en($maquina, 'hr', 'Mantener automáticamente', 'Enc', $desde[$z], $hasta[$z]);
                    $mantenerauto = number_format($mantenerauto, 2, '.','');

                    //Horas totales de trilla acumulado
                    $horasdetrilla = $res->horas_trilla($maquina, 'Total de horas de separador', 'Hora', $desde[$z], $hasta[$z]);
                    $horastrillatotal = number_format($horasdetrilla, 0, '.','');


                  }

                  // Guardo en arrays datos de graficos
                  $superficie[$z] = $matriz[$p]["superficie"];
                  $consumo[$z] = $matriz[$p]["ltsconsumo"];
                  $velocidad[$z] = $matriz[$p]["kmtrabajando"];
                  $factorcarga[$z] = $matriz[$p]["factorcarga"];
                  $aux = $matriz[$p]["ralentiporc"];
                  $ralenti[$z] = number_format($aux, 2, '.','');
                  $aux = $matriz[$p]["ralentitllenaporc"];
                  $ralentilleno[$z] = number_format($aux, 2, '.','');
                  $aux = $matriz[$p]["ralentitvaciaporc"];
                  $ralentivacio[$z] = number_format($aux, 2, '.','');
                  $aux = $matriz[$p]["separadorporc"];
                  $separadorviraje[$z] = number_format($aux, 2, '.','');

              }

                $velocidadprom = array_sum($velocidadarr) / count($velocidadarr);
                $velocidadprom = number_format($velocidadprom, 2, '.','');
                $velocidadmejor = max($velocidadarr);

                $factorcargaprom = array_sum($factorcargaarr) / count($factorcargaarr);
                $factorcargaprom = number_format($factorcargaprom, 2, '.','');
                $factorcargamejor = max($factorcargaarr);
                
                $superficieprom = array_sum($superficiearr) / count($superficiearr);
                $superficieprom = number_format($superficieprom, 2, '.','');
                $superficiemejor = max($superficiearr);
                $superficiemejor = number_format($superficiemejor, 2, '.','');

                $consumoprom = array_sum($consumoarr) / count($consumoarr);
                $consumoprom = number_format($consumoprom, 2, '.','');
                $consumomejor = min($consumoarr);
                $consumomejor = number_format($consumomejor, 2, '.','');

                $ralentiprom = array_sum($ralentiparr) / count($ralentiparr);
                $ralentiprom = number_format($ralentiprom, 2, '.','');
                $ralentimejor = min($ralentiparr);

                $ralentillenoprom = array_sum($ralentitlparr) / count($ralentitlparr);
                $ralentillenoprom = number_format($ralentillenoprom, 2, '.','');
                $ralentillenomejor = min($ralentitlparr);

                $ralentivacioprom = array_sum($ralentitvparr) / count($ralentitvparr);
                $ralentivacioprom = number_format($ralentivacioprom, 2, '.','');
                $ralentivaciomejor = min($ralentitvparr);

                $separadorprom = array_sum($separadorparr) / count($separadorparr);
                $separadorprom = number_format($separadorprom, 2, '.','');
                $separadormejor = min($separadorparr);

                /*
                $ralentillenoprom = array_sum($ralentillenoarr) / count($ralentillenoarr);
                $ralentillenomejor = max($ralentillenoarr);

                $ralentivacioprom = array_sum($ralentivacioarr) / count($ralentivacioarr);
                $ralentivaciomejor = max($ralentivacioarr);
                */

        ?>

        // GRAFICO UTILIZACION DE LA MÁQUINA ACUMULADO
        var data = new google.visualization.arrayToDataTable([
          ['Estado', 'Horas'],
          <?php 
            echo "['Trabajando', ".$hrtrabajando."],";
            echo "['Ralenti', ".$hrralenti."],";
            echo "['Transporte', ".$hrtransporte."],";
          ?>
          ]);

        // Set chart options
        var options = {
        title: 'Horas de uso segun el estado (Hs)',
        titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
        backgroundColor: { fill:'transparent' },
        pieHole:0.45,
        colors: ["green", "gold", "black"],
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);


        //GRÁFICO UTILIZACION DE LA MÁQUINA DETALLADO ACUMULADO
         var data = new google.visualization.arrayToDataTable([
          ['Estado', 'Horas'],
          <?php 
            echo "['Cosecha', ".$hrcosecha."],";
            echo "['Cosecha y Descarga', ".$hrcosechadescarga."],";
            echo "['Descarga no cosechando', ".$hrdescarga."],";
            echo "['Separador de virajes con cabecero engranado', ".$hrseparador."],";
            echo "['Ralenti con depósito de grano lleno', ".$hrtolvallena."],";
            echo "['Ralenti con depósito de grano no lleno', ".$hrtolvavacia."],";
            echo "['Transporte a más de 16 km/h', ".$hrtransporte17."],";
            echo "['Transporte a menos de 16 km/h', ".$hrtransporte15."],";
          ?>
          ]);

        // Set chart options
        var options = {
        title: 'Horas de uso segun el estado (Hs)',
        titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
        backgroundColor: { fill:'transparent' },
        pieHole:0.45,
        colors: ["green", "#21B403", "#2ECC0E", "#50EA30", "gold","#F4FA3B", "black", "#525252"],
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);

        // GRAFICO DE FACTOR DE SUPERFICIE-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $superficieprom .", 'Mejor valor: ' + ". $superficiemejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
            $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
           
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $superficiereal = $superficie[$r];
            $superficiereal = number_format($superficiereal, 2, '.','');
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $superficieprom .",    ". $superficiemejor .",       ". $superficiereal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Superficie cosechada por hora (Has)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Hectáreas',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_superficie'));
        chart.draw(view, options);


          //   GRAFICO DE CONSUMO-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $consumoprom .", 'Mejor valor: ' + ". $consumomejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
       
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $consumoreal = $consumo[$r];
            $consumoreal = number_format($consumoreal, 2, '.','');
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $consumoprom .", ". $consumomejor .", ". $consumoreal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Consumo de combustible por Hectárea (Lts)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Litros',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_consumo'));
        chart.draw(view, options);





         // GRAFICO DE VELOCIDAD-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $velocidadprom .", 'Mejor valor: ' + ". $velocidadmejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $velocidadreal = $velocidad[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $velocidadprom .",    ". $velocidadmejor .",       ". $velocidadreal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Velocidad (Km/Hs)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Km/Hs',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_combo'));
        chart.draw(view, options);


        // GRAFICO DE FACTOR DE CARGA-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $factorcargaprom .", 'Mejor valor: ' + ". $factorcargamejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $factorcargareal = $factorcarga[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $factorcargaprom .",    ". $factorcargamejor .",       ". $factorcargareal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Factor de carga de motor (%)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Porcentaje',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_carga_motor'));
        chart.draw(view, options);



                // GRAFICO DE RALENTI-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $ralentiprom .", 'Mejor valor: ' + ". $ralentimejor .",  '',{role:'annotation'}]," ;


          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $ralentireal = $ralenti[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $ralentiprom .",    ". $ralentimejor .", ". $ralentireal .", '". $ralentireal ."' + ''],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,4
                       ]);

        var options = {
          title: 'Horas en Ralenti (%)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Porcentaje',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_ralenti'));
        chart.draw(view, options);



                       // GRAFICO DE RALENTI CON TOLVA LLENA-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $ralentillenoprom .", 'Mejor valor: ' + ". $ralentillenomejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $ralentillenoreal = $ralentilleno[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $ralentillenoprom .",    ". $ralentillenomejor .",       ". $ralentillenoreal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Horas en Ralenti con tolva llena (%)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Porcentaje',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_ralentidepo'));
        chart.draw(view, options);




                       // GRAFICO DE RALENTI CON TOLVA VACIA-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $ralentivacioprom .", 'Mejor valor: ' + ". $ralentivaciomejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $ralentivacioreal = $ralentivacio[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $ralentivacioprom .",    ". $ralentivaciomejor .",       ". $ralentivacioreal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Horas en Ralenti con tolva vacia (%)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Porcentaje',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_ralentidepono'));
        chart.draw(view, options);




          // GRAFICO DE SEPARADOR DE VIRAJES-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month', 'Promedio: ' + ". $separadorprom .", 'Mejor valor: ' + ". $separadormejor .",  '']," ;

          for ($r=0; $r <= $opt ; $r++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
           $fdesde = date("d/m/Y", strtotime($desde[$r]));
            $fhasta = date("d/m/Y", strtotime($hasta[$r]));
            //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
            $separadorreal = $separadorviraje[$r];
            echo "['". $fdesde ."' + ' - ' + '". $fhasta ."',  ". $separadorprom .",    ". $separadormejor .",       ". $separadorreal ."],";
          } ?>
        ]);

            var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        2,3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

        var options = {
          title: 'Separador de virajes con plataforma embrayada (%)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: { position: 'top'},
          seriesType: 'bars',
          bar: {groupWidth: "85%"},
          vAxis: {
            title: 'Porcentaje',
            minValue: 0
          },
          hAxis: {
            title: 'Períodos'
          },
          series: {0: {type: 'line'},
                    1: {type: 'line'}},
          colors: ["gold", "black", "green"],
          };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_separador'));
        chart.draw(view, options);



          // GRAFICO DE UTILIZACIÓN DE TECNOLOGIA-----------------------------------
          var data = google.visualization.arrayToDataTable([

         <?php echo "['Month','Utilización de Tecnología: ', 'Tiempo en Soja: ','Tiempo de Cosecha: ']," ;

            echo "['AutoTrac™', ". $autotrac .", ". $horasensoja .", ". $horascosecha ."],";
            echo "['Velocidad Autom. de Molinete', ". $velmolinete .", ". $horasensoja .", ". $horascosecha ."],";
            echo "['Harvest Smart', ". $harvest .", ". $horasensoja .", ". $horascosecha ."],";
            echo "['Altura Autom. de Plataforma', ". $alturaplataforma .", ". $horasensoja .", ". $horascosecha ."],";
            echo "['RowSense™', ". $rowsense .", ". $horasensoja .", ". $horascosecha ."],";
            echo "['Mantener Automáticamente', ". $mantenerauto .", ". $horasensoja .", ". $horascosecha ."],";
         ?>
        ]);

          var view = new google.visualization.DataView(data);
                        view.setColumns([0, 1,
                        { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                        2,
                        { calc: "stringify",
                         sourceColumn: 2,
                         type: "string",
                         role: "annotation" },
                        3,
                       { calc: "stringify",
                         sourceColumn: 3,
                         type: "string",
                         role: "annotation" }
                       ]);

          var options = {
          title: 'Utilización de Tecnología (Hs)',
          titleTextStyle: {
            fontSize: 16 // 12, 18 whatever you want (don't specify px)
          },
          backgroundColor: { fill:'transparent' },
          legend: {position: 'top', maxLines: 3},
          seriesType: 'bars',
          vAxis: {
            title: 'Tecnologías',
          },
          
          colors: [ "gold", "green", "black"]
          };

        var chart = new google.visualization.BarChart(document.getElementById('chart_tecnologia'));
        chart.draw(view, options);

}
</script>
    
</head>
<body>

  <div class="container-fluid" style="background-image: url('imagen/fondo1.png'); background-size: 100%;" id="content">
    <img src="imagen/caratula.png" class="responsive" width="100%">
      <div class="container" style="margin-top: 100px;">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8" align="left">
            <button class="btn btn-block btn-warning btn-block" id="org"><b style="font-size: 20px;"><?php echo $organizacion; ?></b></button><br>
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3" align="center">
                  <?php if ($tipomaq == "COSECHADORA") { ?>
                  <u><b>TOTAL HS DE TRILLA</b></u>
                  <img src="imagen/PLATAFORMA.png" class="responsive" width="75%">
                  <b><h4><?php echo $horastrillatotal; ?> hs</h4></b>
                  <?php } ?>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9" align="center">
                    <div class="table-responsive-md">
                        <table class="table  table-striped">
                          <tbody>
                            
                          <?php for ($z=0; $z <= $opt; $z++) {
                            $g = $z+1;
                            echo "<tr>";
                              if ($z == $opt) {
                                $desde[$z] = $finicio;
                                $hasta[$z] = $ffin;
                                echo "<td><b>Acum</b><br>";
                              } else {
                              echo "<td><b>P". $g ."</b><br>";
                              }
                              echo "<td>". date("d-m-Y", strtotime($desde[$z])) ."<br>";
                              echo "<td>". date("d-m-Y", strtotime($hasta[$z])) ."<br>";
                              $z++;
                              $g = $z+1;
                              if ($z<=$opt) {
                              if ($z == $opt) {
                                $desde[$z] = $finicio;
                                $hasta[$z] = $ffin;
                                echo "<td><b>Acum</b><br>";
                              } else {
                              echo "<td><b>P". $g ."</b><br>";
                              }
                              echo "<td>". date("d-m-Y", strtotime($desde[$z])) ."<br>";
                              echo "<td>". date("d-m-Y", strtotime($hasta[$z])) ."<br>";
                              }
                            echo "</tr>";
                          } ?> 

                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4" align="center">
            <?php echo "<img src='imagen/".$tipomaq.".png' class='responsive' width='70%'>" ;
                echo "<h5>". $numeroserie ."</h5>";
             ?>
          </div>
        </div>
      </div>
      <br>
      <br>
            <div class="container-fluid">
              <img src="imagen/soja.jpg" class="responsive" width="100%">

              <br>
            </div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_div" class="chart"></div>
              
            <br>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_div2" class="chart"></div>
              
            <br>
          </div>
        </div>
         <br>
         <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_superficie" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_consumo" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_combo" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_carga_motor" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_ralenti" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_ralentidepo" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_ralentidepono" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_separador" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_tecnologia" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-0 col-md-0 col-lg-4 col-xl-4" align="center"></div>
          <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4" align="center">
            <?php
            if (isset($_SESSION["CodiEmpl"]) AND ($_SESSION["PermEmpl"] == "Global")){ 
            echo "<a class='btn btn-success btn-block' href='whatsapp://send?text=Muy%20buenas%20tardes,%20adjuntamos%20informe%20de%20eficiencia%20de%20la%20máquina%20correspondiente%20a%20la%20cosecha%20de%20SOJA,%20para%20visualizarlo,%20toca%20el%20siguiente%20link%20y%20luego%20espera%20un%20momento%20a%20que%20cargue%20la%20plataforma%20web.%20Desde%20ya%20muchas%20gracias.%20". $url ."' data-action='share/whatsapp/share'>Compartir por WhatsApp</a>" ;
            
            ?>
            <button type="button" class="btn btn-dark btn-block" id="informes" onClick="javascript:enviar_email()">Enviar por Correo Electrónico</button>
            <button type="button" class="btn btn-warning btn-block" id="guardar" onClick="javascript:guardar_informe()">Guardar Informe</button>
            <button onclick="genPDF();" class="btn btn-success btn-block" >PDF</button>
          <?php } ?>
          <br>
          </div>
          <div class="col-sm-0 col-md-0 col-lg-4 col-xl-4" align="center"></div>
        </div>
      </div>
      </div> 
  </div> 
</body>
</html>