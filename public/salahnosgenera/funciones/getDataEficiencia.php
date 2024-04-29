
      <?php 
      include("info_eficiencia.php");
      $maquina = "1J0S670BLE0090016"; // Numero de PIN de máquina
      $finicio = "2019-10-27"; //Fecha desde
      $ffin = "2020-01-14"; //Fecha hasta
      // Calculos para el gráfico de torta
      // creamos el objeto Eficiencia que se encuentra en "info_eficiencia.php"
      $res = new Eficiencia;

      // ----------------------------------------------- LISTA DE ORGANIZACIONES ---------------------------------------------

      $organizaciones = $res->lista_organizaciones();

      // ----------------------------------------------- GRAFICO DE ANILLO 1 ---------------------------------------------

      //Calculamos horas en ralenti
      $ralentihr = $res->datos_eficiencia($maquina,"hr","Ralentí",$finicio,$ffin);

      //Calculamos horas trabajando
      $trabajandohr = $res->datos_eficiencia($maquina,"hr","Trabajando",$finicio,$ffin);

      //Calculamos horas en transporte
      $transportehr = $res->datos_eficiencia($maquina,"hr","Transporte",$finicio,$ffin);



            // ----------------------------------------------- GRAFICO DE ANILLO 2 ---------------------------------------------

      //Calculamos horas en ralenti
      $ralentillenohr = $res->datos_eficiencia($maquina,"hr","Ralentí con depósito de grano lleno",$finicio,$ffin);
      $ralentinollenohr = $res->datos_eficiencia($maquina,"hr","Ralentí con depósito de grano no lleno",$finicio,$ffin);

      //Calculamos horas trabajando
      $cosechahr = $res->datos_eficiencia($maquina,"hr","Cosecha",$finicio,$ffin);
      $cosechaydescargahr = $res->datos_eficiencia($maquina,"hr","Cosecha y descarga",$finicio,$ffin);
      $descargahr = $res->datos_eficiencia($maquina,"hr","Descarga no cosechando",$finicio,$ffin);
      $separadorhr = $res->datos_eficiencia($maquina,"hr","Separador de virajes en cabecero engranado",$finicio,$ffin);

      //Calculamos horas en transporte
      $transportemashr = $res->datos_eficiencia($maquina,"hr","Transporte a más de 16 km/h (10 mph) o interruptor de carretera conectado",$finicio,$ffin);
      $transportemenoshr = $res->datos_eficiencia($maquina,"hr","Transporte a menos de 16 km/h (10 mph), separador desconectado",$finicio,$ffin);



      // ----------------------------------------------- GRAFICO DE BARRAS VELOCIDAD ---------------------------------------------

      //Calculamos VELOCIDAD PROMEDIO DE LA MÁQUINA
      $velocidadprom = $res->datos_promedios($maquina,"km/hr","Trabajando",$finicio,$ffin);

      //Calculamos VELOCIDAD PROMEDIO DEL SEGMENTO
      $vpromprom = $res->promedio_promedios($maquina,"km/hr","Trabajando",$finicio,$ffin);

      //Calculamos VELOCIDAD EL MEJOR VALOR DE VELOCIDAD PROMEDIO
      $vmejorprom = $res->mejor_promedio($maquina,"km/hr","Trabajando",$finicio,$ffin);

      ?>