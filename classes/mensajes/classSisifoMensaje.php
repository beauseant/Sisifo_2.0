<?php 




class SisifoMensaje {
    
	var $id;
	var $de;
	var $a;
	var $fecha;
	var $texto;
	var $adjunto;
	
	function SisifoMensaje ( $idinci, $de, $a, $fecha, $texto, $adjunto, $insertar = False ) {
	
		

		$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
		$db = $sisifoConf -> getBd();
		$lastId = False;
	   
		if ( $insertar ) {


			$sql = "INSERT INTO mensaje (id_incidencia, de, a, fecha, texto) VALUES ('" .
				$idinci . "','" . $de . "','" . $a . "','" . now() . "','" . $texto . "');";
			$db -> execute ( $sql );
			$lastId = $db->insert_Id();
		}
		$this -> id = $lastId;
		$this -> de = $de;
		$this -> a = $a;
		$this -> fecha = $fecha;
		$this -> texto = $texto;
		$this -> adjunto = $adjunto;
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


	function getId () {
		return ( $this -> id );
	}


	function getAdjunto () {
		return ( $this -> adjunto );

	}
	
	
}	
