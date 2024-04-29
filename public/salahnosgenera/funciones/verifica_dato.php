<?php
include("info_eficiencia.php");
$res = new Eficiencia;
if(isset($_GET["maq"])){
        $maquina = $_GET["maq"];
        $opt = $_GET["periodo"];
        $cultivo = $_GET["cultivo"];
        $idorganizacion = $_GET["cboorg"];
        $desde = array();
        $hasta = array();
        $desde[0] = $_GET["desde1"];
        $hasta[0] = $_GET["hasta1"];
        $desde[1] = $_GET["desde2"];
        $hasta[1] = $_GET["hasta2"];
        $desde[2] = $_GET["desde3"];
        $hasta[2] = $_GET["hasta3"];
        $desde[3] = $_GET["desde4"];
        $hasta[3] = $_GET["hasta4"];
        $desde[4] = $_GET["desde5"];
        $hasta[4] = $_GET["hasta5"];
        $desde[5] = $_GET["desde6"];
        $hasta[5] = $_GET["hasta6"];
        $desde[6] = $_GET["desde7"];
        $hasta[6] = $_GET["hasta7"];
        $desde[7] = $_GET["desde8"];
        $hasta[7] = $_GET["hasta8"];
        $desde[8] = $_GET["desde9"];
        $hasta[8] = $_GET["hasta9"];
        $desde[9] = $_GET["desde10"];
        $hasta[9] = $_GET["hasta10"];
      }
      if ($cultivo == "Soja") {
      	$url = "https://agrotecnologiasala.com.ar/salahnosgenera/eficienciasoja.php?desde1=".$desde[0]."&hasta1=".$hasta[0]."&desde2=".$desde[1]."&hasta2=". $hasta[1] ."&desde3=". $desde[2] ."&hasta3=". $hasta[2] ."&desde4=". $desde[3] ."&hasta4=". $hasta[3] ."&desde5=". $desde[4] ."&hasta5=". $hasta[4] ."&desde6=". $desde[5] ."&hasta6=". $hasta[5] ."&desde7=". $desde[6] ."&hasta7=". $hasta[6] ."&desde8=". $desde[7] ."&hasta8=". $hasta[7] ."&desde9=". $desde[8] ."&hasta9=". $hasta[8] ."&desde10=". $desde[9] ."&hasta10=". $hasta[9] ."&cboorg=". $idorganizacion ."&periodo=". $opt ."&maq=". $maquina ."&ancho=". $UM ."";
      }
      if ($cultivo == "Maíz") {
      	$url = "https://agrotecnologiasala.com.ar/salahnosgenera/eficienciamaiz.php?desde1=".$desde[0]."&hasta1=".$hasta[0]."&desde2=".$desde[1]."&hasta2=". $hasta[1] ."&desde3=". $desde[2] ."&hasta3=". $hasta[2] ."&desde4=". $desde[3] ."&hasta4=". $hasta[3] ."&desde5=". $desde[4] ."&hasta5=". $hasta[4] ."&desde6=". $desde[5] ."&hasta6=". $hasta[5] ."&desde7=". $desde[6] ."&hasta7=". $hasta[6] ."&desde8=". $desde[7] ."&hasta8=". $hasta[7] ."&desde9=". $desde[8] ."&hasta9=". $hasta[8] ."&desde10=". $desde[9] ."&hasta10=". $hasta[9] ."&cboorg=". $idorganizacion ."&periodo=". $opt ."&maq=". $maquina ."&ancho=". $UM ."";
      }
      if ($cultivo == "Trigo") {
      	$url = "https://agrotecnologiasala.com.ar/salahnosgenera/eficienciatrigo.php?desde1=".$desde[0]."&hasta1=".$hasta[0]."&desde2=".$desde[1]."&hasta2=". $hasta[1] ."&desde3=". $desde[2] ."&hasta3=". $hasta[2] ."&desde4=". $desde[3] ."&hasta4=". $hasta[3] ."&desde5=". $desde[4] ."&hasta5=". $hasta[4] ."&desde6=". $desde[5] ."&hasta6=". $hasta[5] ."&desde7=". $desde[6] ."&hasta7=". $hasta[6] ."&desde8=". $desde[7] ."&hasta8=". $hasta[7] ."&desde9=". $desde[8] ."&hasta9=". $hasta[8] ."&desde10=". $desde[9] ."&hasta10=". $hasta[9] ."&cboorg=". $idorganizacion ."&periodo=". $opt ."&maq=". $maquina ."&ancho=". $UM ."";
        $pif = $opt-1;
    // Verificamos si hay información en el ultimo periodo para enviar o no, informe al cliente.
          $horastrabarray = $res->verifica_actividad($maquina,"Trabajando",$desde[$pif],$hasta[$pif],"hr","0");
          $dato = mysqli_fetch_array($horastrabarray);
          if (isset($dato[0])) {
            $horastrab = $dato[0];
            if ($horastrab <= 3) { ?>
            	<script type="text/javascript">window.close();</script> 
            <?php } else { 
             	header("Location:".$url."");
              }
          } else { ?>
          	<script type="text/javascript">window.close();</script>
          <?php } 
      }
      

	$pif = $opt-1;
    // Verificamos si hay información en el ultimo periodo para enviar o no, informe al cliente.
          $horastrabarray = $res->verifica_actividad($maquina,"Trabajando",$desde[$pif],$hasta[$pif],"hr",$cultivo);
          $dato = mysqli_fetch_array($horastrabarray);
          if (isset($dato[0])) {
            $horastrab = $dato[0];
            if ($horastrab <= 3) { ?>
            	<script type="text/javascript">window.close();</script> 
            <?php } else { 
             	header("Location:".$url."");
              }
          } else { ?>
          	<script type="text/javascript">window.close();</script>
          <?php } ?>