<?php 

	require_once ( "phplot/phplot.php" );
 	require_once ("class.SisifoIncidencia.php");
	require_once ('singleton/class.Configuracion.php');


class SisifoEstadisticas {

var $graph;
var $db;
var $data;

	function SisifoEstadisticas ( $db ) {

		/*$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
		$this -> db = $sisifoConf -> getBd();*/

		$this -> graph = new PHPlot();
		$this -> graph->SetDataType( "text-data" );
		$this -> graph->SetPlotType("bars");
		//$this -> data = array();

		$data2 = array (
			array ("Enero",12,15,23),	
			array ("Febrero",2,5,3)
		);

		$this -> graph->SetDataValues($data2);
	}

	function estadisEstados ( $year, $id_usr ) {

	}

	function sacarEstados ( $year, $id_usr  ) {

		$sql = "SELECT * FROM estado_inci";
		$resultSetEstado = $this -> db -> Execute ( $sql );
		$resultado = array();
		$contador = 0;

		while ( ! $resultSetEstado  -> EOF ) {
			$id_estado = $resultSetEstado -> fields['id_estado_in'];
			$desc_estado = $resultSetEstado -> fields['descripcion'];

			$sql = "SELECT COUNT(*) as \"numInci\" FROM Incidencia WHERE
				 id_estado = " . $id_estado;

			if ( $id_usr ) {
				$sql = $sql . " AND id_usuario = " . $id_usr;
			} else {
				$sql = $sql . " AND id_usuario > 0";
			}
			if ( $year ) {
				$sql = $sql . " AND fecha_llegada LIKE '%". $year . "%'";
			}
	
			//echo $sql;
			$resultSet = $this -> db -> Execute ( $sql );
			
			$resultado[ $contador ] = $resultSet -> fields  ['numInci'];	

			$resultSetEstado -> MoveNext();
			$contador++;
		}
		$this -> data = array ( array("2005", 3,2,5) );
		$this -> graph->SetDataValues($this -> data );
	}
	
	function broza() {
		$data = array(
			array("__A__",0.0,20,4,5,6),
			array("__B__",2.0,30,5,6,7),
			array("__C__",3.0,40,5,7,8),
			array("__D__",4.0,50,3,6,3),
			array("__E__",4.4,40,3,6,5),
			array("__F__",5.4,40,5,6,5),
			array("__G__",5.5,40,7,6,5),
			array("__H__",7,35,0.0,0.0,""),
			array("__I__",7.4,40,14,16,25),
			array("__J__",7.6,40,6,6,5),
			array("__K__",8.2,40,3,6,5),
			array("__L__",8.5,40,8,6,9),
			array("__M__",9.3,40,5,6,5),
			array("__N__",9.6,40,9,6,7),
			array("__O__",9.9,40,2,6,5),
			array("__P__",10.0,40,3,6,8),
			array("__Q__",10.4,40,3,6,5),
			array("__R__",10.5,40,3,6,5),
			array("__S__",10.8,40,3,6,5),
			array("__T__",11.4,40,3,6,5),
			array("__U__",12.0,40,3,7,5),
			array("__V__",13.4,40,3,5,3),
			array("__W__",14.0,30,3,5,6)
		);
		$data2 = array (
			array ("Enero",12,15,23),	
			array ("Febrero",2,5,3)
		);

		$this -> graph->SetDataValues($data2);
		//$this -> graph->DrawGraph();
	}

	function pintar ( ) {

		$this -> graph->DrawGraph();
		$this -> graph->PrintImage();
	}


}
