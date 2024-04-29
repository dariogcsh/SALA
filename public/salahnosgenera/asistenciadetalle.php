<?php session_start();
    if (isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){
        header("Location: index.php");
      }
$idasistencia = $_REQUEST["id"]; ?>
<!doctype html>
<html>
<head>
   <?php 
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      ?>
    <title>Detalle de Asistencia</title> 
  
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
             $(document).ready(function(){
             
              $('#btn-enviar').on('click',function(){
                      var DescAsis=$("#DescAsis").val();
                      
                      var CodiAsis = "<?php echo $idasistencia; ?>";
                    
                      var dataString = 'DescAsis='+DescAsis+'&CodiAsis='+CodiAsis;
                            
                            $.ajax({
                                type: "POST",
                                url: "funciones/solucionnueva.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                              
                                 if (data==0) {
                                    alert("Mensaje enviado con éxito.");
                                  location.href ="asistenciahistorial.php";
                                  } else {
                                  alert("Mensaje enviado con éxito.");
                                  location.href ="asistencialista.php";
                                  }
                                } 
                            });
                      });
            

              $('#btn-solucionado').on('click',function(){
                      var CodiAsis = "<?php echo $idasistencia; ?>";
                      var dataString = 'CodiAsis='+CodiAsis;
                      var opcion = confirm("¿Desea finalizar la asistencia?");
                          if (opcion == true) {
                            $.ajax({
                                type: "POST",
                                url: "funciones/cerrarasistencia.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                                  alert(data);
                                  if ("<?php echo !isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"]);?>"){
                                    location.href ="asistencialista.php";
                                } else {
                                    location.href ="asistenciahistorial.php";
                                }
                                } 
                            });
                          }
                      });
                    });
    </script>
</head>
<body>
  <?php
    include("funciones/info_varios.php");
    $obj = new Varios;
    $array = $obj->detalle_asistencia($idasistencia);
    $mensaje = $obj->mensajes($idasistencia);
  ?>
  <div class="container-fluid" style="padding-top: 100px;">
    <?php include("barramenu.php"); 
    $fechamodif = $array["FecRAsis"];
     if ($array["EstaAsis"] == "Solicitud Nueva" AND isset($_SESSION['CodiEmpl'])) {
          $time = time();
          $fechamodif = date("Y-m-d H:i:s", $time); 
   }
   if (($array["EstaAsis"] == "Solicitud" OR $array["EstaAsis"] == "Solicitud Nueva") AND  isset($_SESSION['CodiEmpl'])) {
   $obj->modificar_estado_asistencia("Leido (realizando diagnóstico)",$fechamodif,$idasistencia);
 }
   ?>
      <div class="container">
        <h4>Detalle de asistencia</h4>
        <br>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>ID Asistencia:</u></b> ". $array['CodiAsis'] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php $fecha = date("d/m/Y - H:i", strtotime($array["FecIAsis"]));
              echo "<b><u>Fecha de solicitud:</u></b> ". $fecha ." hs"; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Asignado a:</u></b> " . $array['NombEmpl'] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Sucursal:</u></b> ". $array["NombSucu"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php $fecha = date("d/m/Y - H:i", strtotime($fechamodif));
               echo "<b><u>Fecha primera visualización:</u></b> ". $fecha ." hs"; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Estado Actual:</u></b> ". $array["EstaAsis"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Tipo de máquina:</u></b> ". $array["TipoMaq"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Modelo:</u></b> ". $array["ModeMaq"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Máquina con monitoreo: </u></b> ". $array["InscMaq"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>N° de serie: </u></b> ". $array["NumSMaq"] .""; ?>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-12">
              <?php echo "<b><u>Descripción de solicitud de asistencia:</u></b> ". $array["DescAsis"] .""; ?>
            </div>
          </div>
          <br>
          <hr align="center" width="80%" />
          <br>

          <h4>Datos de usuario solicitante</h4>
          <br>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Nombre: </u></b> ". $array["NombClie"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Actividad que desempeña:</u></b> ". $array["DatoClie"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Teléfono: </u></b> ". $array["TeleClie"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>E-mail:</u></b> ". $array["MailClie"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Organización: </u></b> ". $array["NombOrga"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Organización con monitoreo:</u></b> ". $array["InscOrga"] .""; ?>
            </div>
          </div>
          <br>
          <hr align="center" width="80%" />
          <br>

          <h4>Datos de técnico asignado</h4>
          <br>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Nombre: </u></b> ". $array["NombEmpl"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Actividad que desempeña:</u></b> ". $array["PuesEmpl"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Teléfono: </u></b> ". $array["TeleEmpl"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>E-mail:</u></b> ". $array["MailEmpl"] .""; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <?php echo "<b><u>Sucursal: </u></b> ". $array["NombSucu"] .""; ?>
            </div>
            <div class="col-sm-12 col-md-6">  
            </div>
          </div>
          <br>
          <hr align="center" width="80%" />
          <br>



            <table class="table table-dark table-striped">
                <tbody>
                  
                <?php while ($fila = mysqli_fetch_array($mensaje)) {
                  echo "<tr>";

                  if ($fila["CodiClie"] == 0) {
                    $empl = $obj->empleado_sucursall($fila["CodiEmpl"]);
                    echo "<td><b>". $empl["NombEmpl"] ."</b><br>";
                    echo "". $empl["NombSucu"] ."</td>";
                  } else {
                    $clie = $obj->cliente_organizacion($fila["CodiClie"]);
                    echo "<td><b>". $clie["NombOrga"] ."</b><br>";
                    echo "". $clie["NombClie"] ."</td>";

                  }
                  $fecha = date("d/m/Y - H:i", strtotime($fila["FecISolu"]));
                  echo "<td>". $fecha ." hs</td>";
                  echo "<td>". $fila['DescSolu'] ."</td>";

                  echo "</tr>";
                } ?> 

                </tbody>
              </table>

          <br> <div class="row">
          <?php 
          if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) { ?>
          <div class="col-sm-12 col-md-6 col-lg-3"> 
            <button type="button" class="btn btn-warning btn-block" id="btn-responder" data-toggle="modal" data-target="#myModal">Responder</button>
          </div>
           <?php
          } else { ?>
            <div class="col-sm-12 col-md-6 col-lg-3"> 
             <button type="button" class="btn btn-warning btn-block" id="btn-responder" data-toggle="modal" data-target="#myModal">Agregar comentario</button>
           </div>
         <?php }

          ?> 
          <div class="col-sm-0 col-md-0 col-lg-6"> 
          </div>
          <div class="col-sm-12 col-md-6 col-lg-3"> 
            <button type="button" class="btn btn-success btn-block" id="btn-solucionado">Asistencia Solucionada</button>
          </div>
          </div>
          <br><br><br>
          <!-- The Modal -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">
              
                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Agregar comentario</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                  <form role="form">
                    <div class="form-group">
                      <textarea class="form-control" id="DescAsis" rows="5" placeholder="Agregar comentario aquí"></textarea>
                    </div>
                  </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                     <button type="button" id="btn-enviar" class="btn btn-success" data-dismiss="modal">Enviar</button>
                </div>
                
              </div>
            </div>
          </div>
      </div>
  </div> 

</body>
</html>