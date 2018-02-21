<?php 

	require_once ('singleton/class.Configuracion.php');


class SisifoFrases {

var $db;
var $total;


	function SisifoFrases () {
		$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
		$this -> db = $sisifoConf -> getBd();

		$sql = "SELECT COUNT(*) as \"numFrases\" FROM frase";
		$resultSet = $this -> db -> Execute ( $sql );
		$this -> total = $resultSet -> fields  ['numFrases'];
	}

	function dameFrase ( ) {

		srand((double)microtime()*1000000);
		$numero_aleat = rand ( 1, $this -> total );

		$sql = "SELECT * FROM frase WHERE id='" . $numero_aleat  ."'";
		$resultSet = $this -> db -> Execute ( $sql );
		
		return ( $resultSet -> fields  ['texto'] . ". [" . $resultSet -> fields  ['autor'] . "]");

	}

	



}
