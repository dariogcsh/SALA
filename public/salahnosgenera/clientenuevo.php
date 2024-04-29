
<!doctype html>
<html>
<head>
   <?php 
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      ?>
    <title>Nuevo Cliente</title> 
  
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
              $('#solicitud').on('click',function(){
        
                      var CodiMaq=$("#maquina").val();
                      var tipoasis=$("#asistencia").val();
                      var CodDAsis=$("#codigo_diagnostico").val();
                      var DescAsis=$("#descripcion").val();
                      var isChecked= document.getElementById('estado').checked;

                      if(isChecked){ //checked
                        var MaqDAsis = "SI";
                      }else{ //unchecked
                        var MaqDAsis = "NO";
                      }

                      var dataString = 'CodiMaq='+CodiMaq+'&tipoasis='+tipoasis+'&CodDAsis='+CodDAsis+'&DescAsis='+DescAsis+'&MaqDAsis='+MaqDAsis;
                     

                            $.ajax({
                                type: "POST",
                                url: "funciones/asistencianueva.php",
                                data: dataString,
                                cache: false,
                                success: function(data){
                                  alert(data);
                                  location.href ="asistenciahistorial.php";
                                }
                            });
                      });
                    });
    </script>
</head>
<body>
  
  <div class="container-fluid">
    <?php include("barramenu.php"); ?>
    <?php 
    /*
      include("funciones/info_varios.php");
      $obj = new Varios ;
      $organizacion = $obj->datos_organizacion($_SESSION["CodiOrga"]);
      $maquina = $obj->lista_maquina($_SESSION["CodiOrga"]);
      $asistencia = $obj->lista_asistencia();

      <div class="form-group">
                         <?php echo "<input type='text' class='form-control' id='organizacion' disabled='true' value='".$organizacion['NombOrga']."'>"; ?>
                        </div> */
      ?>
      <div class="container minh-100">
        <div class="row justify-content-center align-items-center minh-100">

              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

                      <form style="align-items: center; padding-top: 100px;">
                        <h4>Nuevo Cliente</h4>
                      </br>
                        <div class="form-group">
                            <input class="form-control" type="text" id="apellido" placeholder="Apellido y Nombre">
                          </div>
                        <div class="form-group">                                        
                          <select class="selectpicker form-control" data-live-search="true" title="Máquina" id="maquina">
                            <?php 
                              while ($fila = mysqli_fetch_array($maquina)) {
                                      echo "<option value='". $fila["NumSMaq"] ."' data-subtext = ". $fila["NumSMaq"] .">". $fila["ModeMaq"] ."</option>";
                                    }
                              ?>
                          </select> 
                          </div>
                          
                           <div class="form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="" id="monitoreo">
                                <label class="form-check-label" for="monitoreo">
                                  Monitoreo
                                </label>
                              </div>
                          </div>
                          <div class="form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" value="" id="power">
                                <label class="form-check-label" for="power">
                                  PowerGard
                                </label>
                              </div>
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="text" id="codigo_diagnostico" placeholder="Código de diagnóstico">
                          </div>
                       <div class="form-group">
                          <textarea class="form-control" id="descripcion" placeholder="Descripción de Asistencia" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block" id="solicitud">Enviar</button>
                      </form>
                      </br>
              </div>
              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
        </div>
      </div>
  </div> 



</body>
</html>