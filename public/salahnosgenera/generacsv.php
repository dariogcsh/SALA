<!doctype html>
<html>
<head>
   <?php 
     // include("funciones/getDataEficiencia.php"); // PHP que genera las consulta y obtiene los datos para todas las graficas.
      ?>
      <?php 
      include("funciones/info_varios.php");
      $obj = new Varios;
      ?>
    <title>Generar CSV</title> 
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
</head>
<body>
 
  <div class="container-fluid">
    <?php include("barramenu.php"); ?>
      <div class="container minh-100">
        <div class="row justify-content-center align-items-center minh-100">

              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
              <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">

                      <form style="align-items: center; padding-top: 100px;">
                        <h4>Generar CSV</h4>
                      </br>
                      <div class="form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" checked="true" id="cosechadora">
                                <label class="form-check-label" for="cosechadora">
                                  Cosechadora
                                </label>
                              </div>
                        </div>
                        <div class="form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" checked="true" id="tractor">
                                <label class="form-check-label" for="tractor">
                                  Tractor
                                </label>
                              </div>
                          </div>
                          <div class="form-group">
                             <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" checked="true" id="pulverizadora">
                                <label class="form-check-label" for="pulverizadora">
                                  Pulverizadora
                                </label>
                              </div>
                          </div>
                        <div class="form-group">
                          <input class="form-control" type="text" id="desde" placeholder="Código de diagnóstico">
                        </div>
                          <div class="form-group">
                            <input class="form-control" type="text" id="hasta" placeholder="Código de diagnóstico">
                          </div>
                        <button type="submit" class="btn btn-success btn-block" id="solicitud" onClick="javascript:abrir2paginas()">Correr BOT</button>
                        <button type="button" class="btn btn-success btn-block" id="cultivos" onClick="javascript:insertar_tiempo_cultivo()">Colocar Cultivos</button>
                      </form>
                      </br>
              </div>
              <div class="col-sm-12 col-md-2 col-lg-3 col-xl-3"></div>
        </div>
      </div>
  </div> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
      
        function abrir2paginas(){
          var desde = document.getElementById("desde").value;
          var hasta = document.getElementById("hasta").value;
            var de = Date.parse(desde);
            var dt1 = new Date(de);
            var ha = Date.parse(hasta);
            var dt2 = new Date(ha);
            var diasdif= dt2.getTime()-dt1.getTime();
            var contdias = Math.round(diasdif/(1000*60*60*24));
            dt2.setDate(dt2.getDate() - contdias + 1);

            <?php 
                
                $maquina = $obj->descarga_maq(); 
                
            ?>
            
        for (var i = 0; i < contdias; i++) {
                var desde = dt1.toISOString().substring(0, 10);
                var hasta = dt2.toISOString().substring(0, 10);
                
                <?php while ($fila = mysqli_fetch_array($maquina)) {
                        $maq = $fila["CodiMaqu"];
                        if ($maq<>0) {
                 ?>
                  
                    window.open('https://ultimatedata.deere.com/api/export/' + <?php echo $maq; ?> + '/' + desde + 'T03:00:00.000Z/' + hasta + 'T03:00:00.000Z/csv?unitOfMeasure=METRIC&aggregated=true&utcOffSet=-03%3A00', '_blank'); 
                    
                <?php } } ?>
               /*
                window.open('https://ultimatedata.deere.com/api/export/331534/' + desde + 'T03:00:00.000Z/' + hasta + 'T03:00:00.000Z/csv?unitOfMeasure=METRIC&aggregated=false&utcOffSet=-03%3A00', '_blank'); 
*/
                dt1.setDate(dt1.getDate() + 1);
                dt2.setDate(dt2.getDate() + 1);
               // dt2.setDate(dt2.getDate() + 1);
            }
        }

         function insertar_tiempo_cultivo(){
          window.location.href = 'tiempo_cultivo.php';   
        }


</script>
</body>
</html>
