<?php

/**
 * 
 */
class Agro 
{
		public function reporte_granjas($idorga,$finicio,$ffin,$cultivo){
			include("conexion.php");
			$query = "SELECT NumSReAg, ClieReAg, GranReAg, CultReAg, VariReAg, SUM(SupeReAg) as SupeReAg, UOM1ReAg, SUM(RenTReAg) as RenTReAg, RenMReAg, UOM2ReAg, UOM3ReAg, AVG(HumeReAg) as HumeReAg, FecIReAg, HorIReAg, FecFReAg, HorFReAg FROM reporte_agronomico WHERE OrgaReAg = '". $idorga ."' AND FecIReAg >= '". $finicio ."' AND FecFReAg <= '". $ffin ."' AND CultReAg = '". $cultivo ."' GROUP BY GranReAg, ClieReAg ORDER BY FecFReAg ASC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function reporte_lotes($idorga,$finicio,$ffin,$cultivo){
			include("conexion.php");
			$query = "SELECT NumSReAg, ClieReAg, GranReAg, CampReAg, CultReAg, VariReAg, SUM(SupeReAg) as SupeReAg, UOM1ReAg, SUM(RenTReAg) as RenTReAg, RenMReAg, UOM2ReAg, UOM3ReAg, AVG(HumeReAg) as HumeReAg, FecIReAg, HorIReAg, FecFReAg, HorFReAg FROM reporte_agronomico WHERE OrgaReAg = '". $idorga ."' AND FecIReAg >= '". $finicio ."' AND FecFReAg <= '". $ffin ."' AND CultReAg = '". $cultivo ."' GROUP BY CampReAg, GranReAg, ClieReAg ORDER BY FecFReAg ASC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function reporte_variedades($idorga,$finicio,$ffin,$cultivo){
			include("conexion.php");
			$query = "SELECT NumSReAg, CultReAg, VariReAg, SUM(SupeReAg) as SupeReAg, UOM1ReAg, SUM(RenTReAg) as RenTReAg, RenMReAg, UOM2ReAg, UOM3ReAg, AVG(HumeReAg) as HumeReAg, FecIReAg, HorIReAg, FecFReAg, HorFReAg FROM reporte_agronomico WHERE OrgaReAg = '". $idorga ."' AND FecIReAg >= '". $finicio ."' AND FecFReAg <= '". $ffin ."' AND CultReAg = '". $cultivo ."' GROUP BY VariReAg ORDER BY RenMReAg DESC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function cant_cultivos($idorga,$finicio,$ffin){
			include("conexion.php");
			$query = "SELECT CultReAg FROM reporte_agronomico WHERE OrgaReAg = '". $idorga ."' AND FecIReAg >= '". $finicio ."' AND FecFReAg <= '". $ffin ."' GROUP BY CultReAg";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

		public function reporte_total($idorga,$finicio,$ffin){
			include("conexion.php");
			$query = "SELECT * FROM reporte_agronomico WHERE OrgaReAg = '". $idorga ."' AND FecIReAg >= '". $finicio ."' AND FecFReAg <= '". $ffin ."' ORDER BY FecFReAg ASC";
			$result = $conn->query($query);
			$conn->close();
			return $result;
		}

}
?>