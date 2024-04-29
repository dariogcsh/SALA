<?php session_start(); ?>
<!doctype html>
<html>
<head>
   <?php 
      //include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      include("funciones/info_eficiencia.php");
      include("funciones/info_agronomico.php");
      if(isset($_GET["cboorg"])){
        $idorganizacion = $_GET["cboorg"];

        $desde = $_GET["desde1"];
        $hasta = $_GET["hasta1"];

      }
      $url = "https://agrotecnologiasala.com.ar/reporteagro.php?desde1=".$desde."%26hasta1=".$hasta."%26cboorg=". $idorganizacion ."";

      $res = new Eficiencia;
      $obj = new Agro;
      ?>
  <title>Reporte Agronomico</title> 
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
    <script type="text/javascript">

      function enviar_email(){
        //window.location="maileficiencia.php";
        var orga = '<?php echo $idorganizacion; ?>';
        var url = '<?php echo $url; ?>';
        
        var dataString = 'CodiOrga='+orga+'&url='+url;
                            $.ajax({
                                type: "POST",
                                url: "mail/mailreporte.php",
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
        //Selecciona nombre de organizacion
        $organizacion = $res->ver_organizacion($idorganizacion);

        //Repite todo el bucle segun la cantidad de cultivos que detecte el inform
        $consulta = $obj->cant_cultivos($idorganizacion,$desde,$hasta);
        while ($registro = mysqli_fetch_array($consulta)) { 
          if ($registro["CultReAg"] == "Frijoles de soja") {
            $soja = "SI";
            }elseif ($registro["CultReAg"] == "Maíz") {
              $maiz = "SI";
              
            }
          }
                // -------------Selecciona datos agronomicos de la organizacion GRANJAS------------------------
                $reporte = $obj->reporte_granjas($idorganizacion,$desde,$hasta,"Frijoles de soja");
                $matrizg = array(); // matriz a guardar todos los datos obtenidos
                $x  = 0; //contador de while a continuacion

                //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                while ($fila = mysqli_fetch_array($reporte)) { 
                  $matrizg[$x]["cultivo"] = $fila["CultReAg"];
                  $matrizg[$x]["superficie"] = $fila["SupeReAg"];
                  $matrizg[$x]["rindetotal"] = $fila["RenTReAg"];
                  if ($matrizg[$x]["superficie"] <> 0) {
                    $matrizg[$x]["rindeprom"] = $matrizg[$x]["rindetotal"] / $matrizg[$x]["superficie"];
                    } else {
                    $matrizg[$x]["rindeprom"] = $fila["RenMReAg"];
                  }
                  $matrizg[$x]["humedad"] = $fila["HumeReAg"];
                  $matrizg[$x]["granja"] = $fila["GranReAg"];
                  $matrizg[$x]["cliente"] = $fila["ClieReAg"];
                  $x++;
                } ?>

                // GRAFICO DE SUPERFICIE-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Superficie ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["superficie"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Superficie',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Has.',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_divg'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO TOTAL-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Total ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["rindetotal"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Total',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Toneladas (t)',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div2g'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO PROMEDIO-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_rindemediog'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO HUMEDAD-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Periodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_humedadg'));
                chart.draw(view, options);







              <?php

               // ----------Selecciona datos agronomicos de la organizacion LOTES------------------------------
                $reporte = $obj->reporte_lotes($idorganizacion,$desde,$hasta,"Frijoles de soja");
                $matriz = array(); // matriz a guardar todos los datos obtenidos
                $x  = 0; //contador de while a continuacion

                //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                while ($fila = mysqli_fetch_array($reporte)) { 
                  $matriz[$x]["cultivo"] = $fila["CultReAg"];
                  $matriz[$x]["finicio"] = date("d/m/Y", strtotime($fila["FecIReAg"]));
                  $matriz[$x]["ffin"] = date("d/m/Y", strtotime($fila["FecFReAg"]));
                  $matriz[$x]["hinicio"] = date("d/m/Y", strtotime($fila["HorIReAg"]));
                  $matriz[$x]["hfin"] = date("d/m/Y", strtotime($fila["HorfReAg"]));
                  $matriz[$x]["superficie"] = $fila["SupeReAg"];
                  $matriz[$x]["rindetotal"] = $fila["RenTReAg"];
                  if ($matriz[$x]["superficie"] <> 0) {
                    $matriz[$x]["rindeprom"] = $matriz[$x]["rindetotal"] / $matriz[$x]["superficie"];
                    } else {
                    $matriz[$x]["rindeprom"] = $fila["RenMReAg"];
                  }
                  $matriz[$x]["humedad"] = $fila["HumeReAg"];
                  $matriz[$x]["cliente"] = $fila["ClieReAg"];
                  $matriz[$x]["granja"] = $fila["GranReAg"];
                  $matriz[$x]["campo"] = $fila["CampReAg"];
                  $x++;
                }

            ?> 


            // GRAFICO DE SUPERFICIE-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Superficie ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["superficie"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Superficie',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Has.',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO TOTAL-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Total ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["rindetotal"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Total',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Toneladas (t)',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO PROMEDIO-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_rindemedio'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO HUMEDAD-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Periodos'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_humedad'));
                chart.draw(view, options);



                
                <?php 
                      // -------------Selecciona datos agronomicos de la organizacion------------------------------
                    $reportev = $obj->reporte_variedades($idorganizacion,$desde,$hasta,"Frijoles de soja");
                    $matrizv = array(); // matriz a guardar todos los datos obtenidos
                    $t  = 0; //contador de while a continuacion

                    //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                    while ($fila = mysqli_fetch_array($reportev)) { 
                      $matrizv[$t]["superficie"] = $fila["SupeReAg"];
                      $matrizv[$t]["rindetotal"] = $fila["RenTReAg"];
                      if ($matrizv[$t]["superficie"] <> 0) {
                        $matrizv[$t]["rindeprom"] = $matrizv[$t]["rindetotal"] / $matrizv[$t]["superficie"];
                        } else {
                        $matrizv[$t]["rindeprom"] = $fila["RenMReAg"];
                      }
                      $matrizv[$t]["humedad"] = $fila["HumeReAg"];
                      $matrizv[$t]["variedad"] = $fila["VariReAg"];
                      $t++;
                    }


                ?>


                  // GRAFICO DE RENDIMIENTO PROMEDIO VARIEDADES-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $t ; $i++) { 
                    $valor = $matrizv[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $variedad = $matrizv[$i]["variedad"];
                    $variedad = str_replace("'", "*", $variedad);
                    echo "['". $variedad ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Variedades'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_variedadrinde'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO HUMEDAD VARIEDADES-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $t ; $i++) { 
                    $valor = $matrizv[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $variedad = $matrizv[$i]["variedad"];
                    $variedad = str_replace("'", "*", $variedad);
                    echo "['". $variedad ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Variedades'
                  },
                  colors: ["green"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_variedadhumedad'));
                chart.draw(view, options);








//------------------------------------------MAIZ--------------------------------------------------------

              <?php  // -------------Selecciona datos agronomicos de la organizacion GRANJAS------------------------
                $reporte = $obj->reporte_granjas($idorganizacion,$desde,$hasta,"Maíz");
                $matrizg = array(); // matriz a guardar todos los datos obtenidos
                $x  = 0; //contador de while a continuacion

                //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                while ($fila = mysqli_fetch_array($reporte)) { 
                  $matrizg[$x]["cultivo"] = $fila["CultReAg"];
                  $matrizg[$x]["superficie"] = $fila["SupeReAg"];
                  $matrizg[$x]["rindetotal"] = $fila["RenTReAg"];
                  if ($matrizg[$x]["superficie"] <> 0) {
                    $matrizg[$x]["rindeprom"] = $matrizg[$x]["rindetotal"] / $matrizg[$x]["superficie"];
                    } else {
                    $matrizg[$x]["rindeprom"] = $fila["RenMReAg"];
                  }
                  $matrizg[$x]["humedad"] = $fila["HumeReAg"];
                  $matrizg[$x]["granja"] = $fila["GranReAg"];
                  $matrizg[$x]["cliente"] = $fila["ClieReAg"];
                  $x++;
                } ?>

                // GRAFICO DE SUPERFICIE-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Superficie ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["superficie"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Superficie',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Has.',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_divgm'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO TOTAL-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Total ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["rindetotal"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Total',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Toneladas (t)',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div2gm'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO PROMEDIO-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_rindemediogm'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO HUMEDAD-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matrizg[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matrizg[$i]["cliente"];
                    $granja = $matrizg[$i]["granja"];
                    
                    echo "['". $cliente ." - ". $granja ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Periodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_humedadgm'));
                chart.draw(view, options);
                







                <?php
                 // -------------Selecciona datos agronomicos de la organizacion------------------------------
                $reporte = $obj->reporte_lotes($idorganizacion,$desde,$hasta,"Maíz");
                $x  = 0;
                //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                while ($fila = mysqli_fetch_array($reporte)) { 
                  $matriz[$x]["cultivo"] = $fila["CultReAg"];
                  $matriz[$x]["finicio"] = date("d/m/Y", strtotime($fila["FecIReAg"]));
                  $matriz[$x]["ffin"] = date("d/m/Y", strtotime($fila["FecFReAg"]));
                  $matriz[$x]["hinicio"] = date("d/m/Y", strtotime($fila["HorIReAg"]));
                  $matriz[$x]["hfin"] = date("d/m/Y", strtotime($fila["HorfReAg"]));
                  $matriz[$x]["superficie"] = $fila["SupeReAg"];
                  $matriz[$x]["rindetotal"] = $fila["RenTReAg"];
                  if ($matriz[$x]["superficie"] <> 0) {
                    $matriz[$x]["rindeprom"] = $matriz[$x]["rindetotal"] / $matriz[$x]["superficie"];
                    } else {
                    $matriz[$x]["rindeprom"] = $fila["RenMReAg"];
                  }
                  $matriz[$x]["humedad"] = $fila["HumeReAg"];
                  $matriz[$x]["cliente"] = $fila["ClieReAg"];
                  $matriz[$x]["granja"] = $fila["GranReAg"];
                  $matriz[$x]["campo"] = $fila["CampReAg"];
                  $x++;
                }

            ?> 


            // GRAFICO DE SUPERFICIE-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Superficie ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["superficie"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Superficie',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Has.',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_divm'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO TOTAL-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Total ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["rindetotal"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Total',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 'Toneladas (t)',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div2m'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO PROMEDIO-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Períodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_rindemediom'));
                chart.draw(view, options);


                // GRAFICO DE RENDIMIENTO HUMEDAD-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $x ; $i++) { 
                    $valor = $matriz[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $cliente = $matriz[$i]["cliente"];
                    $granja = $matriz[$i]["granja"];
                    $lote = $matriz[$i]["campo"];
                    echo "['". $cliente ." - ". $granja ." - ". $lote ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Periodos'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_humedadm'));
                chart.draw(view, options);



                
                <?php 
                      // -------------Selecciona datos agronomicos de la organizacion------------------------------
                    $reportev = $obj->reporte_variedades($idorganizacion,$desde,$hasta,"Maíz");
                    $t = 0;

                    //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                    while ($fila = mysqli_fetch_array($reportev)) {
                      $matrizv[$t]["cultivo"] =  $fila["CultReAg"];
                      $matrizv[$t]["superficie"] = $fila["SupeReAg"];
                      $matrizv[$t]["rindetotal"] = $fila["RenTReAg"];
                      if ($matrizv[$t]["superficie"] <> 0) {
                        $matrizv[$t]["rindeprom"] = $matrizv[$t]["rindetotal"] / $matrizv[$t]["superficie"];
                        } else {
                        $matrizv[$t]["rindeprom"] = $fila["RenMReAg"];
                      }
                      $matrizv[$t]["humedad"] = $fila["HumeReAg"];
                      $matrizv[$t]["variedad"] = $fila["VariReAg"];
                      $t++;
                    }


                ?>


                  // GRAFICO DE RENDIMIENTO PROMEDIO VARIEDADES-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Rinde Promedio ']," ;

                  for ($i=0; $i < $t ; $i++) { 
                    $valor = $matrizv[$i]["rindeprom"];
                    $valor = number_format($valor, 1, '.','');
                    $variedad = $matrizv[$i]["variedad"];
                    $variedad = str_replace("'", "*", $variedad);
                    echo "['". $variedad ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Rinde Promedio',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: 't/ha',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Variedades'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_variedadrindem'));
                chart.draw(view, options);



                // GRAFICO DE RENDIMIENTO HUMEDAD VARIEDADES-----------------------------------
                  var data = google.visualization.arrayToDataTable([

                 <?php echo "['Month', 'Humedad ']," ;

                  for ($i=0; $i < $t ; $i++) { 
                    $valor = $matrizv[$i]["humedad"];
                    $valor = number_format($valor, 1, '.','');
                    $variedad = $matrizv[$i]["variedad"];
                    $variedad = str_replace("'", "*", $variedad);
                    echo "['". $variedad ."', ". $valor ."],";
                  } ?>
                ]);

                    var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                               { calc: "stringify",
                                 sourceColumn: 1,
                                 type: "string",
                                 role: "annotation" }
                               ]);

                var options = {
                  title: 'Humedad',
                  titleTextStyle: {
                    fontSize: 16 // 12, 18 whatever you want (don't specify px)
                  },
                  backgroundColor: { fill:'transparent' },
                  legend: { position: 'top'},
                  seriesType: 'bars',
                  bar: {groupWidth: "85%"},
                  vAxis: {
                    title: '%',
                    minValue: 0
                  },
                  hAxis: {
                    title: 'Variedades'
                  },
                  colors: ["gold"],
                  };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_variedadhumedadm'));
                chart.draw(view, options);

}

</script>
    
</head>
<body>

  <div class="container-fluid" style="background-image: url('imagen/fondo1.png'); background-size: 100%;">
    <img src="imagen/caratula_reporte.jpg" class="responsive" width="100%">
      <div class="container" style="margin-top: 100px;">
        <div class="row">
          <div class="col-sm-12">
            <button class="btn btn-block btn-warning btn-block" id="org"><b style="font-size: 20px;"><?php echo $organizacion; ?></b></button><br>
            <div class="row">
                <div class="col-sm-12" align="center">
                    <div class="table-responsive-md">
                        <table class="table  table-striped">
                          <tbody>
                            
                          <?php 
                            echo "<tr>";
                              echo "<td><b>Desde</b><br>";
                              echo "<td>". date("d-m-Y", strtotime($desde)) ."<br>";
                              echo "<td><b>Hasta</b><br>";
                              echo "<td>". date("d-m-Y", strtotime($hasta)) ."<br>";
                         
                            echo "</tr>";
                           ?> 

                          </tbody>
                        </table>
                      </div>
                </div>
            </div>
          </div>

        </div>
   
     
      <br>
      <br>
      <?php if ($soja == "SI") { ?>

        
              <img src="imagen/soja.jpg" class="responsive" width="100%">

              <br>
           <br>

        <h4><b>Granjas</b></h4>
        
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_divg" class="chart"></div>
              
            <br>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_div2g" class="chart"></div>
              
            <br>
          </div>
        </div>
         <br>
         <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_rindemediog" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_humedadg" class="chart"></div>
          </div>
          <br>
        </div>

        <h4><b>Lotes</b></h4>
        
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
            <div id="chart_rindemedio" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_humedad" class="chart"></div>
          </div>
          <br>
        </div>

        <h4><b>Variedades</b></h4>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_variedadrinde" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_variedadhumedad" class="chart"></div>
          </div>
          <br>
        </div>
  <br>
           <br>

<?php  } 
        if ($maiz == "SI") { ?>
          <img src="imagen/maiz.jpg" class="responsive" width="100%">
          <br>
          <br>
       <h4><b>Granjas</b></h4>
        
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_divgm" class="chart"></div>
              
            <br>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_div2gm" class="chart"></div>
              
            <br>
          </div>
        </div>
         <br>
         <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_rindemediogm" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_humedadgm" class="chart"></div>
          </div>
          <br>
        </div>
        

        <h4><b>Lotes</b></h4>
        
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_divm" class="chart"></div>
              
            <br>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_div2m" class="chart"></div>
              
            <br>
          </div>
        </div>
         <br>
         <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_rindemediom" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_humedadm" class="chart"></div>
          </div>
          <br>
        </div>

        <h4><b>Variedades</b></h4>
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_variedadrindem" class="chart"></div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div id="chart_variedadhumedadm" class="chart"></div>
          </div>
          <br>
        </div>
          <br>
           <br>

            <?php }

               // ----------Selecciona datos agronomicos de la organizacion LOTES------------------------------
                $reporte = $obj->reporte_total($idorganizacion,$desde,$hasta);
                $matriz = array(); // matriz a guardar todos los datos obtenidos
                $x  = 0; //contador de while a continuacion
                

            ?> 

            <h4><b>Reporte Detallado</b></h4>


                      <div class="table-responsive-md">
                        <table class="table  table-striped">
                          <thead>
                           <tr>
                            
                              <th>Cliente</th>
                              <th>Granja</th>
                              <th>Campo</th>
                              <th>Cultivo</th>
                              <th>Variedad</th>
                              <th>Superficie</th>
                              <th>Rinde Total</th>
                              <th>Rinde Peromedio</th>
                              <th>Humedad</th>
                              <th>Fecha de Inicio</th>
                              <th>Hora de Inicio</th>
                              <th>Fecha de Fin.</th>
                              <th>Hora de Fin.</th>
                         
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                            //Se extraen datos de la consulta y se guardan en una matriz para ser usada en los graficos a traves de un "for{}"
                            while ($fila = mysqli_fetch_array($reporte)) { 
                              echo "<tr>";
                              echo "<td>".$fila["ClieReAg"]."</td>";
                              echo "<td>".$fila["GranReAg"]."</td>";
                              echo "<td>".$fila["CampReAg"]."</td>";
                              echo "<td>".$fila["CultReAg"]."</td>";
                              echo "<td>".$fila["VariReAg"]."</td>";
                              echo "<td>".$fila["SupeReAg"]." Has.</td>";
                              echo "<td>".$fila["RenTReAg"]." t</td>";
                              echo "<td>".$fila["RenMReAg"]." t/ha</td>";
                              echo "<td>".$fila["HumeReAg"]." %</td>";
                              echo "<td>". date("d/m/Y", strtotime($fila["FecIReAg"])) ."</td>";
                              echo "<td>".$fila["HorIReAg"]." hs</td>";
                              echo "<td>". date("d/m/Y", strtotime($fila["FecFReAg"])) ."</td>";
                              echo "<td>".$fila["HorFReAg"]." hs</td>";
                              echo "</tr>";
                            }
                          ?> 

                          </tbody>
                        </table>
                      </div>
           
        <div class="row">
          <div class="col-sm-0 col-md-0 col-lg-4 col-xl-4" align="center"></div>
          <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4" align="center">
            <?php
            if (isset($_SESSION["CodiEmpl"]) AND ($_SESSION["PermEmpl"] == "Global")){ 
            echo "<a class='btn btn-success btn-block' href='whatsapp://send?text=Muy%20buenas%20tardes,%20adjuntamos%20reporte%20agronómico%20de%20lo%20cosechado%20hasta%20el%20momento%20para%20visualizarlo,%20toca%20el%20siguiente%20enlace%20y%20luego%20espera%20un%20momento%20a%20que%20cargue%20la%20plataforma%20web.%20Desde%20ya%20muchas%20gracias.%20". $url ."' data-action='share/whatsapp/share'>Compartir por WhatsApp</a>" ;
            ?>
            <button type="button" class="btn btn-dark btn-block" id="informes" onClick="javascript:enviar_email()">Enviar por Correo Electrónico</button>
            
          <?php } ?>
          <br>
          </div>
          <div class="col-sm-0 col-md-0 col-lg-4 col-xl-4" align="center"></div>
        </div>
      </div>
      </div> 

</body>
</html>