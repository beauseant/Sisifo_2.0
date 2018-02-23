<?php 

require_once ("classSisifoMensaje.php");


class SisifoArchivoMensaje {
    
	var $id_incidencia;

	function SisifoArchivoMensaje ( $id ) {
		
		$this -> id_incidencia = $id;	
	
	}
	
	function buscar ( ) {


			$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
			$db = $sisifoConf -> getBd();
		

			$sql ='SELECT * FROM mensaje LEFT OUTER JOIN upload ON mensaje.id=upload.id_mensaje WHERE mensaje.id_incidencia=' . $this -> id_incidencia;			
		
			
			$rs = $db -> execute ( $sql );

			
			$webMensaje = array();

			while (!$rs->EOF) {
				$mensaje = new SisifoMensaje ( 
					$rs -> fields ['id_incidencia'],$rs -> fields ['de'], $rs -> fields ['a'], 
					$rs -> fields ['fecha'], $rs -> fields ['texto'],
					[$rs -> fields ['id_upload'],$rs -> fields ['id_mensaje'],$rs -> fields ['nombre_inci'], $rs -> fields ['nombre']]);

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
