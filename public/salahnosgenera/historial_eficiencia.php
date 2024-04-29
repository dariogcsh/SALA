<?php session_start();
include("funciones/info_varios.php");
    $obj = new Varios;
   if (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])){
      $array = $obj->lista_informes($_SESSION["CodiOrga"]);
    } elseif (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) {
      $array = $obj->todos_informes();
      } else {
        header("Location: index.php");
      }
?>
<!doctype html>
<html>
<head>
   <?php 
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      ?>
    <title>Historial de Informes</title> 
  
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
      function desactivar(id) {
         $('#' + id).html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Recuperando...').addClass('disabled');
         alert("Estamos recuperando el informe, espere un momento");
      }
    </script>
   
</head>
<body>

 <div class="container-fluid" style="padding-top: 100px;">
  <h4>Historial de Informes de Eficiencia</h4>
  <br>
      <?php include("barramenu.php"); ?>
        <div class="table-responsive-md">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Cultivo</th>
              <th scope="col">Desde</th>
              <th scope="col">Hasta</th>
              <?php if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) { ?>
              <th scope="col">Organización</th>  
            <?php } ?>
              <th scope="col">Maquina</th>
              <th scope="col">Recuperar</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $cont = 0; 
              while ($fila = mysqli_fetch_array($array)) {
              $desde = $fila["FecIInfo"];
              $hasta = $fila["FecFInfo"];
              $url = $fila["URLInfo"];
             
                echo "<tr>";
                //echo "<th scope='row'><a href='asistenciadetalle.php?id=".$fila['CodiAsis']."' class='fa fa-eye fa-lg' aria-hidden='true'></a></th>";
                echo "<td>". $fila["CultInfo"] ."</td>";
                echo "<td>". date("d/m/Y", strtotime($desde)) ."</td>";
                echo "<td>". date("d/m/Y", strtotime($hasta)) ."</td>";
                if (!isset($_SESSION["CodiClie"]) AND (isset($_SESSION["CodiEmpl"]))) {
                  //$orga = $obj->datos_organizacion($fila["CodiOrga"]);
                  echo "<td>". $fila["NombOrga"] ."</td>";
                }
                echo "<td>". $fila["NumSMaq"] ."</td>";
                echo "<td><a href='".$url."'><button type='button' class='btn btn-warning' id='".$cont."' onClick='desactivar(this.id)'>Visualizar Informe</button></a></td>";
               
                echo "</tr>";
                $cont++;
               }
             ?>
          </tbody>
        </table>
        </div>
  </div>

</body>
</html>