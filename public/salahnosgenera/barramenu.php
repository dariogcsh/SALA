
    <script type="text/javascript">
      function confirmar($pregunta)
        {
          if(confirm($pregunta))
          {
            return true;
          }
          return false;
        }
    </script>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #078A03">
  <a class="navbar-brand" href="#"><h3>Sala Hnos</h3></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="menu.php">Inicio </a>
      </li>
      <?php /*
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Informes
        </a> 
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Eficiencia de Máquinas</a>
          <a class="dropdown-item" href="#">Agronómico</a>
          <a class="dropdown-item" href="#">Asistencias Telefónicas y Remotas</a>
          <a class="dropdown-item" href="#">Alertas</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Mantenimiento y reparaciones </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Mapa de variedades </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" title="Cerrar Sesion" href="#"><i class="material-icons"> power_settings_new </i></a>
      </li>
      */ ?>
      <li class="nav-item dropdown">
        <!--
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Asistencia
        </a> 

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php if (!isset($_SESSION["CodiClie"]) AND isset($_SESSION["CodiEmpl"])){ ?>
            <a class="dropdown-item" href="asistencialista.php?modo=concesionario">Asistencias del Concesionario</a>
            <a class="dropdown-item" href="asistencialista.php?modo=sucursal">Asistencias de Sucursal</a>
          <?php } elseif (!isset($_SESSION["CodiEmpl"]) AND isset($_SESSION["CodiClie"])) { ?>
          <a class="dropdown-item" href="asistencia.php">Solicitar Asistencia</a>
          <a class="dropdown-item" href="asistenciahistorial.php">Historial de Asistencias</a>
        <?php } ?>
        </div>
      -->
         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Informes
        </a> 
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="menuinfmaquina.php">Eficiencia de maquinas</a>
          <a class="dropdown-item" href="filtroRA.php">Reporte Agronomico</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tutoriales.php">Tutoriales </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" title="Cerrar Sesion" href="cerrarsesion.php" onclick="return confirmar('¿Desea cerrar la sesión?')"><i class="material-icons">power_settings_new</i></a>
      </li>
    </ul>
    <img src="imagen/logo1.jpg" height="45">
  </div>
</nav>

