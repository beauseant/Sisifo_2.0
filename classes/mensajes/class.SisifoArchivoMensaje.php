<?php 

require_once ("classSisifoMensaje.php");

class SisifoArchivoMensaje {
    
	var $id_incidencia;

	function SisifoArchivoMensaje ( $id ) {
		
		$this -> id_incidencia = $id;	
	
	}
	
	function buscar ( ) {
		global $sisifoConf;
	
		$db = $sisifoConf -> getBd();

		
			$sql = "SELECT * FROM mensaje WHERE id_incidencia =" . $this -> id_incidencia . " ORDER BY fecha;";
			
			$rs = $db -> execute ( $sql );
			
			$webMensaje = array();
			while (!$rs->EOF) {
				$mensaje = new SisifoMensaje ( 
					$rs -> fields ['id_incidencia'],$rs -> fields ['de'], $rs -> fields ['a'], 
					$rs -> fields ['fecha'], $rs -> fields ['texto']  );
				$webMensaje[] = $mensaje;
				$rs->MoveNext();
			}
			//Había mensajes para esa incidencia??????
			if ( array_count ( $webMensaje ) == 0 ) {
				return array();
			}else {
				return $webMensaje;
			}									
	
	}

}	
