<?php session_start();
    if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){
      
    } elseif (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])) {
      
      } else {
        header("Location: index.php");
      }
     ?>
<!doctype html>
<html>
<head>
   <?php 
     if (isset($_REQUEST["modo"])){
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
   $modo = $_REQUEST["modo"];
 } else {
  $modo = "sucursal";
 }
      ?>
    <title>Asistencias solicitadas</title> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"><!-- iconos -->

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
</head>
<body>
  
  <div class="container-fluid" style="padding-top: 100px;">
  <h4>Historial de asistencias</h4>
  <br>
      <?php include("barramenu.php"); ?>
      <?php 
        include("funciones/info_varios.php");
        $obj = new Varios ;
        $asistencia = $obj->asistencia_asignada($modo,$_SESSION["CodiEmpl"]);
        ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Ver</th>
              <th scope="col">Organización</th>
              <th scope="col">Solicitado</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_array($asistencia)) {
                echo "<tr>";
                echo "<th scope='row'><a href='asistenciadetalle.php?id=".$fila['CodiAsis']."'class='fa fa-eye fa-lg' aria-hidden='true'></a></th>";
                echo "<td>". $fila["NombOrga"] ."</td>";
                echo "<td>". $fila["FecIAsis"] ."</td>";
                echo "<td>". $fila["EstaAsis"] ."</td>";
                echo "</tr>";
              }

                  ?>

          </tbody>
        </table>
  
  </div>



</body>
</html>