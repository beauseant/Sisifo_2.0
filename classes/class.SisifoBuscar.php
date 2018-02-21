<?php 


include_once("../lib.php");

	/**
	* Clase usada para obtener una cadena SQL que devuelva las busquedas requeridas.
	*/  
class SisifoBuscar {
    
   
   /**#@+
   * access private
   * @var string 
   */
   /**
   * El id de la ayuda.
   */   
   var $sql;
   
   /**#@-*/ 
	
	
	
	/**
	* Constructor.
	* Recibe los parametros de busqueda, y construye la cadena SQL.
	* @param mensaje el texto a buscar en los mensajes, o vacio si no se quiere ese campo.
	* @param anotacion el texto a buscar en anotacion, o vacio si no se quiere ese campo.
	* @param desc_larga el texto a buscar en desc_larga, o vacio si no se quiere ese campo.
	* @param desc_breve el texto a buscar en desc_breve, o vacio si no se quiere ese campo.
	*/
	function SisifoBuscar ( $mensaje, $anotacion, $desc_breve, 
	  $desc_larga, $usuario, $ordenfecha ) {

		
		$sql = "SELECT  incidencia.id FROM incidencia";
	
		//Hacemos la poda por clave primaria en la consulta:
		//AND (incidencia.id = mensaje.id_incidencia AND incidencia.id =
		//	 anotacion.id_incidencia)
		$tablas = array();
	
		$contador = 0;
		if ( $mensaje ) {
			$tablas[$contador] = "mensaje";
			$contador++;
		}
		if ( $anotacion ) {
			$tablas[$contador] = "anotacion";
			$contador++;
		}
	
		$total = count ( $tablas );
	
		if ( $total  > 0 ) {
			$sql = $sql . ",";
			$cadena2 = "AND (";
		}

		//Buscamos las tabalas involucradas en la busqueda:
		//SELECT incidencia.id FROM mensaje, incidencia

		for ( $i = 0 ; $i < $total ; $i++ ) {
			$sql = $sql . $tablas[$i];
			$cadena2 = $cadena2 . "incidencia.id=" . $tablas[$i] . ".id_incidencia";
			if ( $i < ( $total - 1 ) ) {
				$sql = $sql . ",";
				$cadena2 = $cadena2 . " AND ";
			}
			
		}
		if ( $total  > 0 ) {
			$cadena2 = $cadena2 . ")";
		}
		


		//Y ahora hacemos la consulta por los atributos:
		//WHERE mensaje.texto like '%friki%'  AND anotacion.texto like '%prueba%'
		$atributos = array();
	
		$contador = 0;
	
		if ( $desc_breve ) {
			$atributos[$contador] = "incidencia.desc_breve ILIKE '%" . $desc_breve . "%'";
			$contador++;
		}
		if ( $desc_larga ) {
			$atributos[$contador] = "incidencia.desc_larga  ILIKE '%" . $desc_larga . "%'";
			$contador++;
		}
		if ( $mensaje ) {
			$atributos[$contador] = "mensaje.texto  ILIKE '%" . $mensaje . "%'";
			$contador++;
		}
		if ( $anotacion ) {
			$atributos[$contador] = "anotacion.texto  ILIKE '%"  . $anotacion . "%'";
			$contador++;
		}
		if ( $usuario ) {
			$atributos[$contador] = "incidencia.id_usuario ='"  . $usuario . "'";
			$contador++;
		}

	
		$total = count ( $atributos );
	
		if ( $total  > 0 ) {
			$sql = $sql . " WHERE ";
		}
	
		for ( $i = 0 ; $i < $total ; $i++ ) {
			$sql = $sql . $atributos[$i];
			if ( $i < ( $total - 1 ) ) {
				$sql = $sql . " AND ";
			}
		}
	
	
		$sql = $sql . " " . $cadena2 . " ORDER BY fecha_llegada " . $ordenfecha;
	
		$this -> sql = $sql;
	
	}
	
	/**
	* Funcion que devuelve la cadena SQL.
	*/
	function getSQL () {
		return $this -> sql;
	}
	
	
    

}    
    
	    
