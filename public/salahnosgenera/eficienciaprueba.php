<?php session_start(); ?>
<!doctype html>
<html>
<head>
   <?php 
      //include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      include("funciones/info_eficiencia.php");
      if(isset($_POST["maq"])){
        $maquina = $_POST["maq"];
        $opt = $_POST["periodo"];
        $opt = $opt - 1;
        $desde = array();
        $hasta = array();
        $desde[0] = $_POST["desde1"];
        $hasta[0] = $_POST["hasta1"];
        $desde[1] = $_POST["desde2"];
        $hasta[1] = $_POST["hasta2"];
        $desde[2] = $_POST["desde3"];
        $hasta[2] = $_POST["hasta3"];
        $desde[3] = $_POST["desde4"];
        $hasta[3] = $_POST["hasta4"];
        $desde[4] = $_POST["desde5"];
        $hasta[4] = $_POST["hasta5"];
        $desde[5] = $_POST["desde6"];
        $hasta[5] = $_POST["hasta6"];
        $desde[6] = $_POST["desde7"];
        $hasta[6] = $_POST["hasta7"];
        $desde[7] = $_POST["desde8"];
        $hasta[7] = $_POST["hasta8"];
        $desde[8] = $_POST["desde9"];
        $hasta[8] = $_POST["hasta9"];
        $desde[9] = $_POST["desde10"];
        $hasta[9] = $_POST["hasta10"];
        $finicio = $desde[0];
        $ffin = $hasta[$opt];
        $medida = $_POST["medida"];
        $UM = $_POST["ancho"];
      }
      //$maquina = "1J0S670BLE0090016"; // Numero de PIN de máquina

      $res = new Eficiencia;
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

</head>
<body>

  <div class="container-fluid">

    <!-- Incluimos la Barra de Menú -->
    <?php //include("barramenu.php"); 
     // ----------------------------------------------- LISTA DE ORGANIZACIONES ---------------------------------------------
    ?>

      <div class="container" style="margin-top: 100px;">
        <div class="row">
          
            <?php
              
              // Calculamos el promedio en ralenti con máquinas del mismo segmento
              //Calculamos horas en ralenti
              $ralentihr = $res->suma_segmento($maquina,"hr","Ralentí",$finicio,$ffin);
              if (empty($ralentihr)) {
                $ralentihr = 0;
              }
              //Calculamos horas trabajando
              $trabajandohr = $res->suma_segmento($maquina,"hr","Trabajando",$finicio,$ffin);
              if (empty($trabajandohr)) {
                $trabajandohr = 0;
              }
              //Calculamos horas en transporte
              $transportehr = $res->suma_segmento($maquina,"hr","Transporte",$finicio,$ffin);
              if (empty($transportehr)) {
                $transportehr = 0;
              }
              $totalhsprom = $ralentihr + $trabajandohr + $transportehr;
              if ($totalhsprom<>0) {
                $porcralentiprom = $ralentihr / $totalhsprom * 100;
                $porcralentiprom = number_format($porcralentiprom, 2, '.','');
              }

              //Suma los valores de tiempo en trabajo para cada máquina del mismo segmento
              $sumatrabajando = $res->mejor_suma_segmento($maquina,"hr","Trabajando",$finicio,$ffin);
              $i=0;
              $cant2=0;
              if (!empty($sumatrabajando)) {
                while ($fila = mysqli_fetch_array($sumatrabajando)){
                    $val2[$i] = $fila["ValoUtil"];
                    $nserie2[$i] = $fila["NumSMaq"];
                    $i++;
                    $cant2++;
                  }
              }

              //Suma los valores de tiempo en transporte para cada máquina del mismo segmento
              $sumatransporte = $res->mejor_suma_segmento($maquina,"hr","Transporte",$finicio,$ffin);
              $i=0;
              $cant3 = 0;
              if (!empty($sumatransporte)) {
                while ($fila = mysqli_fetch_array($sumatransporte)){
                    $val3[$i] = $fila["ValoUtil"];
                    $nserie3[$i] = $fila["NumSMaq"];
                    $i++;
                    $cant3++;
                  }
              }

              //Suma los valores de tiempo en ralenti para cada máquina del mismo segmento
              $sumaralenti = $res->mejor_suma_segmento($maquina,"hr","Ralentí",$finicio,$ffin);
              $array = array();
              $z = 0;
              $valor2 = 0;
              $valor3 = 0;
              if (!empty($sumaralenti)) {
                while ($fila = mysqli_fetch_array($sumaralenti)) {
                    $val1 = $fila["ValoUtil"];
                    $nserie1 = $fila["NumSMaq"];
                    //for para hacer los calculos
                    for ($i=0; $i < $cant2 ; $i++) { 
                      if ($nserie1 == $nserie2[$i]) {
                        $valor2 = $val2[$i];
                      } 
                    }
                    for ($x=0; $x < $cant3 ; $x++) { 
                      if ($nserie1 == $nserie3[$x]) {
                        $valor3 = $val3[$x];
                      }       
                    } 
                  $totalhs = $val1 + $valor2 + $valor3;
                  if (($totalhs<>0) && ($val1<>0)) {
                    $array[$z] = $val1 / $totalhs *100;
                    $z++;
                  }
                }
              } 
            if (!empty($array)) {
              $ralentimejor = min($array);
            } else {
              $ralentimejor = 0;
            }
              $ralentimejor = number_format($ralentimejor, 2, '.','');
            
             echo  $porcralentiprom ." - ". $ralentimejor  ;

          for ($i=0; $i <= $opt ; $i++) { //Cada bucle representa una barra del grafico o un periodo
            // Utilizamos switch para obtener los valores de fecha desde y fecha hasta y utilizarlos en la consulta
             //Calculamos horas en ralenti
              $ralentihr = $res->datos_eficiencia($maquina,"hr","Ralentí",$desde[$i],$hasta[$i]);

              //Calculamos horas trabajando
              $trabajandohr = $res->datos_eficiencia($maquina,"hr","Trabajando",$desde[$i],$hasta[$i]);

              //Calculamos horas en transporte
              $transportehr = $res->datos_eficiencia($maquina,"hr","Transporte",$desde[$i],$hasta[$i]);

              
                $vall1 = $ralentihr;
              
                $vall2 = $trabajandohr;
               
                $vall3 = $transportehr;
                
                
                $totalhs = $vall1 + $vall2 + $vall3;
              if ($totalhs<>0) {
                $porcralenti = $vall1 / $totalhs * 100;
              } else{
                $porcralenti = 0;
              }
              $porcralenti = number_format($porcralenti, 2, '.','');
            echo  $porcralentiprom .",    ". $ralentimejor .",       ". $porcralenti .;
          } ?>
     
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Datos de utilización (hs)</u></h4><br>
            <div id="chart_div" class="chart"></div>

            <br>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Datos de utilización detallado (hs)</u></h4><br>
            <div id="chart_div2" class="chart"></div>
            <br>
          </div>
        </div>
         <br>
         <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Superficie cosechada por hora (Ha)</u></h4><br>
            <div id="chart_superficie" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Combustible consumido por hectárea (Lts)</u></h4><br>
            <div id="chart_consumo" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Velocidad de trabajo (km/hs)</u></h4><br>
            <div id="chart_combo" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Factor de carga promedio del motor (%)</u></h4><br>
            <div id="chart_carga_motor" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Horas en Ralenti (%)</u></h4><br>
            <div id="chart_ralenti" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Horas de Ralenti con tolva llena (%)</u></h4><br>
            <div id="chart_ralentidepo" class="chart"></div>
          </div>
          <br>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Horas de Ralenti con tolva NO llena (%)</u></h4><br>
            <div id="chart_ralentidepono" class="chart"></div>
            
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <h4><u>Separador de virajes con cabecero engranado (%)</u></h4><br>
            <div id="chart_separador" class="chart"></div>
          </div>
          <br>
        </div>
      </div> 
  </div> 
</body>
</html>