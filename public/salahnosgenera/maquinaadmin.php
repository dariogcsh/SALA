<?php session_start();
include("funciones/info_varios.php");
    $obj = new Varios;
   if (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])){
      $array = $obj->lista_maquina($_SESSION["CodiOrga"]);
    } elseif (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) {
      $array = $obj->todas_maquinas();
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
    <title>Administrar máquinas</title> 
  
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
              function eliminarmaq($id){
                var codigo = $id;
                var dataString = 'codigo='+codigo;
                      var opcion = confirm("¿Desea eliminar la máquina?");
                          if (opcion == true) {
                            $.ajax({
                                type: "POST",
                                url: "funciones/borrarmaq.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                                  alert(data);
                                  location.href ="maquinaadmin.php";
                                } 
                            });
                          }
              }
                   
    </script>
</head>
<body>

 <div class="container-fluid" style="padding-top: 100px;">
  <h4>Administrar unidades</h4>
  <br>
      <?php include("barramenu.php"); ?>
        <div class="table-responsive-md">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Unidad</th>
              <th scope="col">Marca</th>
              <?php if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) { ?>
              <th scope="col">Organización</th>  
            <?php } ?>
            <th scope="col">N° de Serie</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($fila = mysqli_fetch_array($array)) {
                echo "<tr>";
                //echo "<th scope='row'><a href='asistenciadetalle.php?id=".$fila['CodiAsis']."' class='fa fa-eye fa-lg' aria-hidden='true'></a></th>";
                echo "<td><img src='imagen/". $fila["TipoMaq"] .".png' class='responsive' style='max-height: 50px;' title='". $fila["TipoMaq"] ."'></td>";
                echo "<td>". $fila["MarcMaq"] ." - ". $fila["ModeMaq"] ."</td>";
                if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])) {
                  $orga = $obj->datos_organizacion($fila["CodiOrga"]);
                  echo "<td>". $orga["NombOrga"] ."</td>";
                }
                echo "<td>". $fila["NumSMaq"] ."</td>";
                if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"]) AND ($_SESSION["PermEmpl"] == "Global")) {
                echo "<td><a href='javascript:eliminarmaq(".$fila['id'].")' type='button' class'btn'><img src='imagen/eliminar.png' class='responsive' style='max-height: 30px;' title='". $fila["NumSMaq"] ."'></a></td>";
               }
                echo "</tr>";
              } ?>
          </tbody>
        </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-3">
          <a class="btn btn-warning btn-block" href="maquinanueva.php" role="button">Nueva Unidad</a>
        </div>
        <br>
  </div>

</body>
</html>