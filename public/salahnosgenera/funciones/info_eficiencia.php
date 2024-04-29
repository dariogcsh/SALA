<?php

/**
 * 
 */
class Eficiencia 
{

	public function l_segmento($segmaq){ // Calcula el promedio de las máquinas del mismo segmento
		include("conexion.php");
		$query = "SELECT NumSMaq, TipoMaq FROM maquinaria WHERE NumSMaq LIKE '%". $segmaq ."%' GROUP BY NumSMaq";
		$result = $conn->query($query);
		$conn->close(); 
		return $result;
	}

	public function datos_eficiencia($segmento,$UOMUtil,$estado,$finicio,$ffin,$cultivo){
		include("conexion.php");
		
		$query = "SELECT NumSMaq, SUM(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq LIKE '%". $segmento ."%' AND UOMUtil = '". $UOMUtil ."' AND SeriUtil = '". $estado ."' AND  FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."' AND CultUtil LIKE '%". $cultivo ."%' GROUP BY NumSMaq";

		$result = $conn->query($query);
		$conn->close();
		return $result;

	}

	public function rinde_hectarea($segmento,$UOMUtil,$estado,$finicio,$ffin,$cultivo){
		include("conexion.php");
		
		$query = "SELECT NumSInAg, SUM(RindInAg) as ValoUtil FROM utilidad WHERE NumSMaq LIKE '%". $segmento ."%' AND  FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."' AND CultUtil = '". $cultivo ."' GROUP BY NumSMaq";

		$result = $conn->query($query);
		$conn->close();
		return $result;

	}

	public function datos_eficiencia_total($segmento,$UOMUtil,$estado,$finicio,$ffin){
		include("conexion.php");
		
		$query = "SELECT NumSMaq, SUM(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq LIKE '%". $segmento ."%' AND UOMUtil = '". $UOMUtil ."' AND SeriUtil = '". $estado ."' AND  FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."' GROUP BY NumSMaq";

		$result = $conn->query($query);
		$conn->close();
		return $result;

	}

	public function datos_eficiencia_promedios($segmento,$UOMUtil,$estado,$finicio,$ffin,$m,$cultivo){
		include("conexion.php");
		$query = "SELECT NumSMaq, AVG(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq LIKE '%". $segmento ."%' AND UOMUtil = '". $UOMUtil ."' AND SeriUtil = '". $estado ."' AND FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."' AND ValoUtil > '". $m ."' AND CultUtil LIKE '%". $cultivo ."%' GROUP BY NumSMaq"	;

		$result = $conn->query($query);
		$conn->close();
		return $result;
	}

	public function ancho_apero($segmento){
			include("conexion.php");
    		$query = "SELECT NumSMaq, CanPMaq FROM maquinaria WHERE NumSMaq LIKE '%". $segmento ."%'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function ancho_maicero($segmento){
			include("conexion.php");
    		$query = "SELECT NumSMaq, MaicMaq FROM maquinaria WHERE NumSMaq LIKE '%". $segmento ."%'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}


		public function lista_organizaciones(){
			include("conexion.php");
			$query = "SELECT * FROM organizacion ORDER BY NombOrga";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function lista_monitoreo(){
			include("conexion.php");
			$query = "SELECT NumSMaq, NombOrga FROM maquinaria INNER JOIN organizacion ON maquinaria.CodiOrga = organizacion.CodiOrga WHERE maquinaria.InscMaq = 'SI' GROUP BY NumSMaq ORDER BY NombOrga";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function ver_organizacion($codigo){
			include("conexion.php");
			$query = "SELECT NombOrga FROM organizacion WHERE CodiOrga = '". $codigo ."' ORDER BY NombOrga";
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			$dato = $array[0];
			return $dato;
		}

		public function horas_en($maquina,$UOMUtil, $categoria, $SeriUtil, $finicio, $ffin){
			include("conexion.php");
			$query = "SELECT SUM(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq = '". $maquina ."' AND UOMUtil = '". $UOMUtil ."' AND CateUtil LIKE '%". $categoria ."%' AND SeriUtil = '". $SeriUtil ."' AND FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."'"	;
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			$dato = $array[0];
			return $dato;
		}

		public function horas_trilla($maquina, $categoria, $SeriUtil, $finicio, $ffin){
			include("conexion.php");
			$query = "SELECT MAX(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq = '". $maquina ."' AND  CateUtil = '". $categoria ."' AND SeriUtil = '". $SeriUtil ."' AND FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."'"	;
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			$dato = $array[0];
			return $dato;
		}

		public function verifica_cosecha($maquina, $categoria, $finicio, $ffin){
			include("conexion.php");
			$query = "SELECT NumSMaq FROM utilidad WHERE NumSMaq = '". $maquina ."' AND CateUtil LIKE '%". $categoria ."%' AND FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."'"	;
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function consultar_monitoreo($var,$tipomaq){
			include("conexion.php");
			$query = "SELECT NumSMaq, CodiOrga FROM maquinaria WHERE InscMaq = '".$var."' AND TipoMaq = '". $tipomaq ."'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function verifica_actividad($maquina,$estado,$finicio,$ffin,$UOMUtil,$cultivo){
			include("conexion.php");
			$query = "SELECT SUM(ValoUtil) as ValoUtil FROM utilidad WHERE NumSMaq = '". $maquina ."' AND UOMUtil = '". $UOMUtil ."' AND SeriUtil = '". $estado ."' AND FecIUtil >= '". $finicio ."' AND FecFUtil <= '". $ffin ."' AND CultUtil LIKE '%". $cultivo ."%'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

	

}
?>