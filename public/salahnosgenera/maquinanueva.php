<?php session_start();
      include("funciones/info_varios.php");
      $obj = new Varios;
      include("funciones/info_eficiencia.php");
      $res = new Eficiencia;
  
    if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){
      $organizaciones = $res->lista_organizaciones();
    } elseif (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])) {
      $organizacion = $obj->datos_organizacion($_SESSION["CodiOrga"]);
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
    <title>Nueva Maquinaria</title> 
  
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
              $('#maquina_nueva').on('click',function(){

                      var CodiOrga=$("#cboorganizacion").val();
                      var TipoMaq=$("#maquina").val();
                      var marca=$("#marca").val();
                      var modelo=$("#modelo").val();
                      var numero_serie=$("#numero_serie").val();

                      if(CodiOrga==""){
                        alert("Por favor, seleccione su organización");
                        document.getElementById("cboorganizacion").focus();
                        return false;
                      }
                      if(TipoMaq==""){
                        alert("Por favor, seleccione el tipo de máquina");
                        document.getElementById("maquina").focus();
                        return false;
                      }
                      if(marca==""){
                        alert("Por favor, seleccione la marca");
                        document.getElementById("marca").focus();
                        return false;
                      }
                      if(modelo==""){
                        alert("Por favor, ingrese el modelo");
                        document.getElementById("modelo").focus();
                        return false;
                      }
                      if(numero_serie==""){
                        alert("Por favor, ingrese el número de serie");
                        document.getElementById("numero_serie").focus();
                        return false;
                      }
                      
                      var dataString = 'TipoMaq='+TipoMaq+'&marca='+marca+'&modelo='+modelo+'&numero_serie='+numero_serie+'&CodiOrga='+CodiOrga;
                      
                            $.ajax({
                                type: "POST",
                                url: "funciones/maqnueva.php",
                                data: dataString,
                                cache: false,
                                success: function(resp){
                                  alert(resp);
                                  location.href = "maquinaadmin.php";
                                }
                            });
                      });
                    });
    </script>
</head>
<body>
  
  <div class="container-fluid">
    <?php include("barramenu.php");
      ?>
      <div class="container minh-100">
        <div class="row justify-content-center align-items-center minh-100">

              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

                      <form style="align-items: center; padding-top: 100px;">
                        <h4>Unidad nueva</h4>
                      </br>
                      <?php 
                        if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){
                      ?>
                        <div class="form-group">                                        
                          <select class="selectpicker form-control" data-live-search="true" title="Seleccionar Organización" id="cboorganizacion">
                            <?php 
                              while ($fila = mysqli_fetch_array($organizaciones)) {
                                      if ($fila["InscOrga"] == "SI") {
                                        $subtitulo = "MONITOREADO";
                                      } else {
                                        $subtitulo = "";
                                      }
                                      echo "<option value='". $fila["CodiOrga"] ."' data-subtext = ". $subtitulo .">". $fila["NombOrga"] ."</option>";
                                    }
                              ?>
                          </select>                                
                        </div> 
                      <?php } else { ?>
                        <div class="form-group">                                        
                          <select class="selectpicker form-control" data-live-search="true" title="Seleccionar Organización" id="cboorganizacion">
                            <?php 
                                  echo "<option value='". $organizacion["CodiOrga"] ."'>". $organizacion["NombOrga"] ."</option>";
                              ?>
                          </select>                                
                        </div> 
                      <?php } ?>
                        <div class="form-group">                                        
                          <select class="selectpicker form-control" data-live-search="true" title="Máquina" id="maquina">
                            <option value="COSECHADORA">COSECHADORA</option>
                            <option value="PULVERIZADORA">PULVERIZADORA</option>
                            <option value="TRACTOR">TRACTOR</option>
                            <option value="PICADORA">PICADORA</option>
                            <option value="SEMBRADORA">SEMBRADORA</option>
                          </select> 
                          </div>
                          <div class="form-group">                                        
                          <select class="selectpicker form-control" data-live-search="true" title="Marca" id="marca">
                            <option value="JOHN DEERE">JOHN DEERE</option>
                            <option value="MASSEY FERGUSON">MASSEY FERGUSON</option>
                            <option value="CASE IH">CASE IH</option>
                            <option value="CLASS">CLASS</option>
                            <option value="NEW HOLLAND">NEW HOLLAND</option>
                            <option value="DEUTZ - FAHR">DEUTZ - FAHR</option>
                            <option value="AGCO ALLIS">AGCO ALLIS</option>
                            <option value="OTRO">OTRO</option>
                          </select> 
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" id="modelo" placeholder="Modelo: S680">
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" id="numero_serie" placeholder="N° de Serie: 1J0S680BKF...">
                          </div>
                        <button type="button" class="btn btn-success btn-block" id="maquina_nueva">Guardar</button>
                      </form>
                      </br>
              </div>
              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
        </div>
      </div>
  </div> 



</body>
</html>