<?php 




class SisifoAnotacion {
    
	var $id;
	var $usuario;
	var $fecha;
	var $texto;

	
	function SisifoAnotacion ( $idinci, $usuario, $fecha, $texto, $insertar = false ) {
	
 	$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	$db = $sisifoConf -> getBd();

	   
		if ( $insertar ) {
			$sql = "INSERT INTO anotacion (id_incidencia, id_usuario, fecha, texto) VALUES ('" .
				$idinci . "','" . $usuario . "','" . now() . "','" . $texto . "');";
			$db -> execute ( $sql );
		}
		//$this -> id = $idmensaje;
		$this -> usuario = $usuario;
		$this -> fecha = $fecha;
		$this -> texto = $texto;
	}
	
	function getfecha () {
	        $res_date=new DateTime( $this -> Fecha,new DateTimeZone('GMT'));
        	$res_date->setTimeZone(new DateTimeZone('Europe/Madrid'));
        	return $res_date->format ('Y-m-d H:i:s');

	}

	function gettexto () {
		return ( $this -> texto );
	}

	function getusuario () {
		return ($this -> usuario );
	}		
	
}	
