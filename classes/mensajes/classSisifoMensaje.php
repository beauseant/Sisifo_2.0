<?php 




class SisifoMensaje {
    
	var $id;
	var $de;
	var $a;
	var $fecha;
	var $texto;

	
	function SisifoMensaje ( $idinci, $de, $a, $fecha, $texto, $insertar = false ) {
	
    	global $sisifoConf;

	$db = $sisifoConf -> getBd();

	   
		if ( $insertar ) {
			$sql = "INSERT INTO mensaje (id_incidencia, de, a, fecha, texto) VALUES ('" .
				$idinci . "','" . $de . "','" . $a . "','" . now() . "','" . $texto . "');";
			$db -> execute ( $sql );
		}
		//$this -> id = $idmensaje;
		$this -> de = $de;
		$this -> a = $a;
		$this -> fecha = $fecha;
		$this -> texto = $texto;
	}
	
	function getfecha () {
	        $res_date=new DateTime( $this -> fecha,new DateTimeZone('GMT'));
       		$res_date->setTimeZone(new DateTimeZone('Europe/Madrid'));
       		return $res_date->format ('Y-m-d H:i:s');

	}

	function gettexto () {
		return ( $this -> texto );
	}

	function getDe () {
		return ( $this -> de );
	}

	function getA () {
		return ( $this -> a );
	}

	
	
}	
