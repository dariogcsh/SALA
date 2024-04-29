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
                /*
                  $('#cboorganizacion').on('change',function(){
                      var codiorg = $(this).val();
                      if(codiorg){
                          
                          $.ajax({
                              type:'POST',
                              url:'funciones/eventos.php',
                              data:'codi_org='+codiorg,
                              success:function(respuesta){
                                  $('#clientes').html(respuesta);     
                              }

                          }); 
                          
                      }else{
                          $('#maquinas').html('<option value="">Seleccione Organización primero</option>'); 
                      }
                  });
                 
                  $('.mdb-select').materialSelect();
                   */
              });

          function crearinforme($a){

            var desde1 = document.getElementById("desde1").value;
            var hasta1 = document.getElementById("hasta1").value;
            var cboorg = document.getElementById("cboorganizacion").value;
            //var maq = document.getElementById("cliente").value;
            if ($a == 0) {
              //var maq = document.getElementById("cliente").value;
              

              window.open('https://agrotecnologiasala.com.ar/reporteagro.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&cboorg=' + cboorg + '', '_blank');
             
            } 
              if ($a == 1) {
            
              <?php 
                $array = $res->consultar_monitoreo("SI","COSECHADORA");
                while ($fila = mysqli_fetch_array($array)) { ?>
                  //var maqui = '<?php echo $fila["NumSMaq"]; ?>' ;
                  var organ = '<?php echo $fila["CodiOrga"]; ?>' ;
                  
                 window.open('https://agrotecnologiasala.com.ar/reporteagro.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&cboorg=' + organ + '', '_blank');
                
              

          <?php } ?>
                  
          }
              if ($a == 2) {
                

                
                window.open('https://agrotecnologiasala.com.ar/reporteagro.php?desde1=' + desde1 + '&hasta1=' + hasta1 + '&cboorg=' + cboorg + '', '_self');  
                
                $('#informeload').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Creando Informe...').addClass('disabled');
                alert("El informe se esta generando, espere un momento");
           }
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
          
        
              <div class="form-group row"> 
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-01-01" name="desde1"  id="desde1">
                </div>
                <div class="col-6">
                  <input class="form-control" type="date" value="2020-08-31" name="hasta1"  id="hasta1">
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
          
        </div>
        </form>


      </div>
      
  </div> 

</body>
</html>