<?php session_start();
include("funciones/info_eficiencia.php");
  $res = new Eficiencia;

if (isset($_SESSION['CodiClie'])){
  $codigoorga = $_SESSION["CodiOrga"];
  $nombreorga = $res->ver_organizacion($codigoorga);
} elseif (isset($_SESSION['CodiEmpl'])) {
  $organizaciones = $res->lista_organizaciones();
} else {
  header("Location: login.php");
  session_destroy();
}

?>
<!doctype html>
<html>
<head>
  <title>Generar Informe</title> 
  <LINK REL=StyleSheet HREF="chart.css" TYPE="text/css">
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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


             $(document).ready(function(){

              

                         $(".radioperiodo").click(function(evento){
                    
                                    var valor = $(this).val();
                                 for (var i=2; i<=10; i++) { 
                                    if(i <= valor){
                                        $("#divp" + i).css("display", "block");
                                    }else {
                                      $("#divp" + i).css("display", "none");
                                    }
                                  }
                            });
                
                  $('#cboorganizacion').on('change',function(){
                      var codiorg = $(this).val();
                      if(codiorg){
                          
                          $.ajax({
                              type:'POST',
                              url:'funciones/eventos.php',
                              data:'codi_org='+codiorg,
                              success:function(respuesta){
                                  $('#maquinas').html(respuesta);
                                  var codimaq = $('#maquinas').val();
                                    if(codimaq){
                                        $.ajax({
                                            type:'POST',
                                            url:'funciones/eventos.php',
                                            data:'codi_maq='+codimaq,
                                            success:function(respuesta){
                                                $('#medida').val(respuesta);

                                            }
                                        }); 
                                        
                                    }
                              }

                          }); 
                          
                      }else{
                          $('#maquinas').html('<option value="">Seleccione Organización primero</option>'); 
                      }
                  });

                  $('#maquinas').on('change',function(){
                      var codimaq = $(this).val();
                      if(codimaq){
                          $.ajax({
                              type:'POST',
                              url:'funciones/eventos.php',
                              data:'codi_maq='+codimaq,
                              success:function(respuesta){
                                  $('#medida').val(respuesta);

                              }
                          }); 
                          
                      }
                  });



                  $('.mdb-select').materialSelect();
              });
          function retardo(){

          }
          function crearinforme($a){

            var desde1 = document.getElementById("desde1").value;
            var hasta1 = document.getElementById("hasta1").value;
            var desde2 = document.getElementById("desde2").value;
            var hasta2 = document.getElementById("hasta2").value;
            var desde3 = document.getElementById("desde3").value;
            var hasta3 = document.getElementById("hasta3").value;
            var desde4 = document.getElementById("desde4").value;
            var hasta4 = document.getElementById("hasta4").value;
            var desde5 = document.getElementById("desde5").value;
            var hasta5 = document.getElementById("hasta5").value;
            var desde6 = document.getElementById("desde6").value;
            var hasta6 = document.getElementById("hasta6").value;
            var desde7 = document.getElementById("desde7").value;
            var hasta7 = document.getElementById("hasta7").value;
            var desde8 = document.getElementById("desde8").value;
            var hasta8 = document.getElementById("hasta8").value;
            var desde9 = document.getElementById("desde9").value;
            var hasta9 = document.getElementById("hasta9").value;
            var desde10 = document.getElementById("desde10").value;
            var hasta10 = document.getElementById("hasta10").value;

            if (document.getElementById("p1").checked == true) {
              var periodo = 1;
            }
            if (document.getElementById("p2").checked == true) {
              var periodo = 2;
            }
            if (document.getElementById("p3").checked == true) {
              var periodo = 3;
            }
            if (document.getElementById("p4").checked == true) {
              var periodo = 4;
            }
            if (document.getElementById("p5").checked == true) {
              var periodo = 5;
            }
            if (document.getElementById("p6").checked == true) {
              var periodo = 6;
            }
            if (document.getElementById("p7").checked == true) {
              var periodo = 7;
            }
            if (document.getElementById("p8").checked == true) {
              var periodo = 8;
                }
            if (document.getElementById("p9").checked == true) {
              var periodo = 9;
                }
            if (document.getElementById("p10").checked == true) {
              var periodo = 10;
            }
            if (document.getElementById("soja").checked == true) {
              var cultivo = "Soja";
            }
            if (document.getElementById("maiz").checked == true) {
              var cultivo = "Maíz";
            }

            if (document.getElementById("trigo").checked == true) {
              var cultivo = "Trigo";
            }

            if ($a == 0) {
              var maq = document.getElementById("maquinas").value;
              var cboorg = document.getElementById("cboorganizacion").value;
              /*
              window.open('https://agrotecnologiasala.com.ar/eficiencia2.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '&ancho=' + ancho + '', '_blank'); 
              */
              if (document.getElementById("soja").checked == true) {
              window.open('eficienciasoja.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_blank'); 
              }
              if (document.getElementById("maiz").checked == true) {
              window.open('eficienciamaiz.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_blank');
              }  
              if (document.getElementById("trigo").checked == true) {
              window.open('eficienciatrigo.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_blank');
              }  
            } else { 
              if ($a == 1) {
            
          <?php  
            $array = $res->consultar_monitoreo("SI","COSECHADORA");

            while ($fila = mysqli_fetch_array($array)) { ?>
              var maqui = '<?php echo $fila["NumSMaq"]; ?>' ;
              var organ = '<?php echo $fila["CodiOrga"]; ?>' ;

                window.open('funciones/verifica_dato.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + organ + '&periodo=' + periodo + '&maq=' + maqui + '&cultivo=' + cultivo +'', '_blank'); 
 
          <?php  } ?>
                  
           } else {
              if ($a == 2) {
                var maq = document.getElementById("maquinas").value;
                var cboorg = document.getElementById("cboorganizacion").value;

                /*
                window.open('https://agrotecnologiasala.com.ar/eficiencia2.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '&ancho=' + ancho + '', '_blank'); 
                */
                if (document.getElementById("soja").checked == true) {
                window.open('eficienciasoja.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_self'); 
                }
                
                if (document.getElementById("maiz").checked == true) {
                window.open('eficienciamaiz.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_self'); 
                }
                if (document.getElementById("trigo").checked == true) {
                window.open('eficienciatrigo.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&desde2=' + desde2 + '&hasta2=' + hasta2 + '&desde3=' + desde3 + '&hasta3=' + hasta3 + '&desde4=' + desde4 + '&hasta4=' + hasta4 + '&desde5=' + desde5 + '&hasta5=' + hasta5 + '&desde6=' + desde6 + '&hasta6=' + hasta6 + '&desde7=' + desde7 + '&hasta7=' + hasta7 + '&desde8=' + desde8 + '&hasta8=' + hasta8 + '&desde9=' + desde9 + '&hasta9=' + hasta9 + '&desde10=' + desde10 + '&hasta10=' + hasta10 + '&cboorg=' + cboorg + '&periodo=' + periodo + '&maq=' + maq + '', '_blank');
                }  
                $('#informeload').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Creando Informe...').addClass('disabled');
                alert("El informe se esta generando, espere un momento");
           } } }
               /*
                window.open('https://ultimatedata.deere.com/api/export/331534/' + desde + 'T03:00:00.000Z/' + hasta + 'T03:00:00.000Z/csv?unitOfMeasure=METRIC&aggregated=false&utcOffSet=-03%3A00', '_blank'); 
*/
           
        }

    </script>
</head>
<body>

  <div class="container-fluid">

    <!-- Incluimos la Barra de Menú -->
    <?php include("barramenu.php"); 
     // ----------------------------------------------- LISTA DE ORGANIZACIONES---------------------------------

    ?>

      <div class="container" style="margin-top: 100px;">
        <form style="padding-bottom: 30px;">
          <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">                          
              <div class="form-group">      
              <?php if (isset($_SESSION['CodiClie'])){ ?>
                <select class="form-control" id="cboorganizacion" name="cboorg" disabled="true">
                  <?php
                    echo "<option value='". $codigoorga ."' data-subtext = ''>". $nombreorga ."</option>"; ?>
                  </select>
                 <?php } ?>     
                  <?php 
                   if (isset($_SESSION['CodiEmpl'])) { ?>                             
                <select class="selectpicker form-control" data-live-search="true" title="Seleccionar Organización" id="cboorganizacion" name="cboorg">
                  <?php 
                    while ($fila = mysqli_fetch_array($organizaciones)) {
                            if ($fila["InscOrga"] == "SI") {
                              $subtitulo = "MONITOREADO";
                            } else {
                              $subtitulo = "";
                            }
                            echo "<option value='". $fila["CodiOrga"] ."' data-subtext = ". $subtitulo .">". $fila["NombOrga"] ."</option>";
                          }
                  }
                    
                    ?>
                </select>                                
              </div>                                  
          </div>
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">

          <div class="form-group">
           <select class="form-control"  id="maquinas" name="maq">
            <?php
            if (isset($_SESSION['CodiClie'])){ 
            include('funciones/conexion.php');
                $query = $conn->query("SELECT * FROM maquinaria WHERE CodiOrga = '".$codigoorga."' ORDER BY TipoMaq ASC");
    
                    //Count total number of rows
                    $rowCount = $query->num_rows;
                    
                    //Display states list
                    if($rowCount > 0){
                        while($row = $query->fetch_assoc()){ 
                          if ($row["InscMaq"] == "SI") {
                             echo '<option value="'.$row['NumSMaq'].'">'.$row['NumSMaq'].' - '. $row['ModeMaq'] .' - (Monitoreado)</option>';
                          } else {
                            echo '<option value="'.$row['NumSMaq'].'">'.$row['NumSMaq'].' - '. $row['ModeMaq'] .'</option>';
                        }}
                       
                    }else{
                        echo '<option value="">Maquinaria no disponible</option>';
                    }  } ?>
            
           </select>
          </div>
      
        </div>
        <hr align="center" width="80%" />
        </div>
        
        <div class="row">
          
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div class="col-12"><h5><u><b>Cantidad de Períodos</b></u></h5></div>
            <div class="form-group">
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p1" value="1" name="periodo" checked="true">
                <label class="form-check-label" for="p1">1</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p2" value="2" name="periodo">
                <label class="form-check-label" for="p2">2</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p3" value="3" name="periodo">
                <label class="form-check-label" for="p3">3</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p4" value="4" name="periodo">
                <label class="form-check-label" for="p4">4</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p5" value="5" name="periodo">
                <label class="form-check-label" for="p5">5</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p6" value="6" name="periodo">
                <label class="form-check-label" for="p6">6</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p7" value="7" name="periodo">
                <label class="form-check-label" for="p7">7</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p8" value="8" name="periodo">
                <label class="form-check-label" for="p8">8</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p9" value="9" name="periodo">
                <label class="form-check-label" for="p9">9</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input radioperiodo" type="radio" id="p10" value="10" name="periodo">
                <label class="form-check-label" for="p10">10</label>
              </div>
              </div>
              </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center">
              <div class="col-12"><h5><u><b>Tipo de Cultivo</b></u></h5></div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" id="soja" value="soja" name="ancho" checked="true">
                  <label class="form-check-label" for="soja">Soja  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" id="maiz" value="maiz" name="ancho">
                  <label class="form-check-label" for="maiz">Maiz</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input " type="radio" id="trigo" value="trigo" name="ancho">
                  <label class="form-check-label" for="trigo">Trigo</label>
                </div>
            </div>
            <!--
            <div class="col-12"><h5><u><b>Tipo de Cultivos</b></u></h5></div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" value="" id="soja" checked="true">
              <label class="form-check-label" for="soja">
                Soja
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" value="" id="maiz" checked="true">
              <label class="form-check-label" for="maiz">
                Maíz
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" value="" id="otro" checked="true">
              <label class="form-check-label" for="otro">
                Otro
              </label>
            </div> -->
            </div>
          <hr align="center" width="80%" />
        </div>

        <!-- Periodo 1 y 2 -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp1">
              <div class="col-12"><h6><u><b>Periodo 1</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-03-01" name="desde1"  id="desde1">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-03-29" name="hasta1"  id="hasta1">
                </div>
              </div>
              
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp2" style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 2</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-03-30" name="desde2" id="desde2">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-10" name="hasta2" id="hasta2">
                </div>
              </div>
          </div>
          <hr align="center" width="80%" />
        </div>

        <!-- Periodo 3 y 4 -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp3"style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 3</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-11" name="desde3" id="desde3">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-17" name="hasta3" id="hasta3">
                </div>
              </div>
              
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp4"style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 4</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-18" name="desde4" id="desde4">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-21" name="hasta4" id="hasta4">
                </div>
              </div>
          </div>
          <hr align="center" width="80%" />
        </div>

        <!-- Periodo 5 y 6 -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp5"style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 5</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-22" name="desde5" id="desde5">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-29" name="hasta5" id="hasta5">
                </div>
              </div>
              
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp6" style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 6</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-04-30" name="desde6" id="desde6">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-08" name="hasta6" id="hasta6">
                </div>
              </div>
          </div>
          <hr align="center" width="80%" />
        </div>

        <!-- Periodo 7 y 8 -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp7" style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 7</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-09" name="desde7" id="desde7">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-28" name="hasta7" id="hasta7">
                </div>
              </div>
              
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp8" style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 8</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-12" name="desde8" id="desde8">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-18" name="hasta8" id="hasta8">
                </div>
              </div>
          </div>
          <hr align="center" width="80%" />
        </div>

        <!-- Periodo 9 y 10 -->
        <div class="row">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp9" style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 9</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-19" name="desde9" id="desde9">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-25" name="hasta9" id="hasta9">
                </div>
              </div>
              
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6" align="center" id="divp10"style="display:none;">
              <div class="col-12"><h6><u><b>Periodo 10</b></u></h6></div>
              <div class="form-group row"> 
                <div class="col-6"><h7>Desde</h7></div>
                <div class="col-6"><h7>Hasta</h7></div>
              </div>
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-05-26" name="desde10" id="desde10">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-06-04" name="hasta10" id="hasta10">
                </div>
              </div>
          </div>
          <hr align="center" width="80%" />
        </div>

        <div class="row">
          <div class="col-sm-0 col-md-3 col-lg-4 col-xl-4"></div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <?php 
            if (isset($_SESSION["CodiEmpl"]) AND ($_SESSION["PermEmpl"] == "Global")){ ?>
            <button type="button" class="btn btn-warning btn-block" id="1informe" onClick="javascript:crearinforme(0)">Crear Informe para compartir</button>
             <button type="button" class="btn btn-success btn-block" id="informes" onClick="javascript:crearinforme(1)">Crear todos los Informes de Monitoreo</button>
            <?php } ?>
              <button type="button" class="btn btn-dark btn-block" id="informeload" onClick="javascript:crearinforme(2)" >Crear Informe</button>
              
          </div>
            <div class="loader"></div>
          <div class="col-sm-0 col-md-3 col-lg-4 col-xl-4"></div>
          <hr align="center" width="80%"/>
        </div>
        </form>


      </div>
      
  </div> 

</body>
</html>