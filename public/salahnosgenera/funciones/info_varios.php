<?php

/**
 * 
 */
class Varios
{
		public function datos_organizacion($organizacion){
			include("conexion.php");
			$query = "SELECT * FROM organizacion WHERE CodiOrga = '". $organizacion ."'";
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			return $array;
		}

		public function lista_maquina($orga){
			include("conexion.php");
    		$query = "SELECT * FROM maquinaria WHERE CodiOrga = '".$orga."' ORDER BY TipoMaq ASC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function lista_informes($orga){
			include("conexion.php");
    		$query = "SELECT * FROM informes WHERE CodiOrga = '".$orga."' ORDER BY FecFInfo DESC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function todas_maquinas(){
			include("conexion.php");
    		$query = "SELECT * FROM maquinaria ORDER BY TipoMaq ASC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function todos_informes(){
			include("conexion.php");
    		$query = "SELECT * FROM informes INNER JOIN organizacion ON informes.CodiOrga = organizacion.CodiOrga ORDER BY FecFInfo DESC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function descarga_maq(){
			include("conexion.php");
    		$query = "SELECT * FROM idmaquina";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function lista_asistencia(){
			include("conexion.php");
			$query = "SELECT * FROM tipo_asistencia ORDER BY NombTiAs";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function historial_asistencia($orga){
			include("conexion.php");
			$query = "SELECT CodiAsis, FecIAsis, NombEmpl, EstaAsis FROM asistencia INNER JOIN empleado ON asistencia.CodiEmpl = empleado.CodiEmpl INNER JOIN maquinaria ON asistencia.CodiMaq = maquinaria.NumSMaq WHERE maquinaria.CodiOrga = '".$orga."' ORDER BY FecIAsis DESC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function designacion($orga){
			include("conexion.php");
			$query = "SELECT * FROM empleado INNER JOIN empleado_sucursal ON empleado.CodiEmpl = empleado_sucursal.CodiEmpl INNER JOIN organizacion ON empleado_sucursal.CodiSucu = organizacion.CodiSucu WHERE organizacion.CodiOrga = '". $orga ."' AND empleado.PuesEmpl = 'Administrativo de Servicio'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}
		public function detalle_asistencia($id){
			include("conexion.php");
			$query = "SELECT * FROM asistencia INNER JOIN  maquinaria ON asistencia.CodiMaq = maquinaria.NumSMaq INNER JOIN  tipo_asistencia ON asistencia.CodTAsis = tipo_asistencia.CodiTiAs INNER JOIN cliente ON asistencia.CodiClie = cliente.CodiClie INNER JOIN organizacion ON cliente.CodiOrga = organizacion.CodiOrga INNER JOIN empleado ON asistencia.CodiEmpl = empleado.CodiEmpl INNER JOIN empleado_sucursal ON empleado.CodiEmpl = empleado_sucursal.CodiEmpl INNER JOIN sucursal ON empleado_sucursal.CodiSucu = sucursal.CodiSucu WHERE asistencia.CodiAsis = '".$id."' ";
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			return $array;
		}

		public function asistencia_asignada($modo,$empleado){
			include("conexion.php");
			if ($modo == "sucursal") {
				$query = "SELECT * FROM asistencia INNER JOIN empleado ON asistencia.CodiEmpl = empleado.CodiEmpl INNER JOIN empleado_sucursal ON empleado.CodiEmpl = empleado_sucursal.CodiEmpl INNER JOIN maquinaria ON asistencia.CodiMaq = maquinaria.NumSMaq INNER JOIN cliente ON asistencia.CodiClie = cliente.CodiClie INNER JOIN organizacion ON cliente.CodiOrga = organizacion.CodiOrga WHERE empleado_sucursal.CodiEmpl = '". $empleado ."' GROUP BY FecIAsis ORDER BY FecIAsis DESC";
			} else {
			$query = "SELECT * FROM asistencia INNER JOIN empleado ON asistencia.CodiEmpl = empleado.CodiEmpl INNER JOIN empleado_sucursal ON empleado.CodiEmpl = empleado_sucursal.CodiEmpl INNER JOIN maquinaria ON asistencia.CodiMaq = maquinaria.NumSMaq INNER JOIN cliente ON asistencia.CodiClie = cliente.CodiClie INNER JOIN organizacion ON cliente.CodiOrga = organizacion.CodiOrga GROUP BY FecIAsis ORDER BY FecIAsis DESC";
			}
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function mensajes($CodiAsis){
			include("conexion.php");
			$query = "SELECT * FROM asistencia_solucion INNER JOIN asistencia ON asistencia_solucion.CodiAsis = asistencia.CodiAsis INNER JOIN solucion ON asistencia_solucion.CodiSolu = solucion.CodiSolu WHERE asistencia_solucion.CodiAsis = '". $CodiAsis ."' ORDER BY solucion.FecISolu DESC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}	

		public function empleado_sucursall($empleado){
			include("conexion.php");
			$query = "SELECT * FROM empleado INNER JOIN empleado_sucursal ON empleado.CodiEmpl = empleado_sucursal.CodiEmpl INNER JOIN sucursal ON empleado_sucursal.CodiSucu = sucursal.CodiSucu WHERE empleado.CodiEmpl = '". $empleado ."'";
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			return $array;
		}

		public function cliente_organizacion($cliente){
			include("conexion.php");
			$query = "SELECT * FROM cliente INNER JOIN organizacion ON cliente.CodiOrga = organizacion.CodiOrga WHERE cliente.CodiClie = '". $cliente ."'";
			$result = $conn->query($query);
			$conn->close();
			$array = mysqli_fetch_array($result);
			return $array;
		}

		public function modificar_estado_asistencia($estado,$fecha,$id){
			include("conexion.php");
			$query = "UPDATE asistencia SET EstaAsis= '". $estado ."', FecRAsis = '". $fecha ."' WHERE CodiAsis = '". $id ."'";
			$conn->query($query);
			$conn->close();
			return 0;
		}

		public function cerrar_asistencia($estado,$fecha,$id){
			include("conexion.php");
			$query = "UPDATE asistencia SET EstaAsis= '". $estado ."', FecFAsis = '". $fecha ."' WHERE CodiAsis = '". $id ."'";
			$conn->query($query);
			$conn->close();
			return 0;
		}

		//funcion para agregar el cultivo a los registros de la tabla utilidad
		public function registros_sin_cultivo(){
			include("conexion.php");
			$query = "SELECT NumSMaq, FecIUtil, HorIUtil, FecFUtil, HorFUtil FROM utilidad WHERE CultUtil = '0'  ORDER BY CultUtil ASC LIMIT 52";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function registros_sin_cultivo2(){
			include("conexion.php");
			$query = "SELECT NumSMaq, FecIUtil, HorIUtil, FecFUtil, HorFUtil FROM utilidad WHERE CultUtil = '0'  ORDER BY CultUtil DESC LIMIT 32";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function buscar_cultivo($finicio, $hinicio, $ffin, $hfin, $maquina){
			include("conexion.php");
			$query = "SELECT CateUtil FROM utilidad WHERE FecIUtil = '". $finicio ."' AND HorIUtil = '". $hinicio ."' AND FecFUtil = '". $ffin ."' AND HorFUtil = '". $hfin ."' AND NumSMaq = '". $maquina ."' AND (CateUtil LIKE '%Tiempo en Soja%' OR CateUtil LIKE '%Tiempo en maíz%' OR CateUtil LIKE '%Tiempo en trigos%' OR CateUtil LIKE '%Tiempo en maíz para palomitas%')";
			$result = $conn->query($query);
			$conn->close();
			$dato = mysqli_fetch_array($result);
			$cant = count($dato);
			if ($cant == 0) {
				$cul = '1';
			} else {
				$cul = $dato[0];
			}
			return $cul;
		}

		public function actualizar_cultivo($finicio, $hinicio, $ffin, $hfin, $maquina, $cultivo){
			include("conexion.php");
			$query = "UPDATE utilidad SET CultUtil = '". $cultivo ."' WHERE FecIUtil = '". $finicio ."' AND HorIUtil = '". $hinicio ."' AND FecFUtil = '". $ffin ."' AND HorFUtil = '". $hfin ."' AND NumSMaq = '". $maquina ."' AND CultUtil = '0'";
			$conn->query($query);
			$conn->close();
			return 0;
		}

		public function get_email($organ){
			include("conexion.php");
			$query = "SELECT CorrMail, TipoMail FROM mail WHERE OrgaMail = '". $organ ."'";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

}




?>