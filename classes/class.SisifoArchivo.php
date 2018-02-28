<?php 


include_once("includes/lib.php");
include_once("class.SisifoIncidencia.php");

	/**
	* Clase usada para gestionar el archivo de incidencias.
	* Por archivo de incidencias se entienden las incidencias antiguas de un usuario,
	* y que no aparecen en la pantalla principal de la aplicacion.
	*/  
class SisifoArchivo {
    
   
   /**#@+
   * access private
   * @var object 
   */
   /**
   * La fecha de la que se quieren mostrar incidencias.
   */   
   var $fecha;
   
   /**
   * El identificador del usuario del que se quieren mostrar las incidencias.
   */      
   var $id_usr;
   /**#@-*/ 
	
	
	
	/**
	* Constructor.
	* Formatea la fecha con las incidencias de un usuario 
	* @param y el anno del que se quieren mostrar las incidencias.
	* @param m el mes del que se quieren mostrar las incidencias.
	* @param d el dia del que se quieren mostrar las incidencias.
	* @param id_usr el usuario del que se quieren buscar las incidencias.
	*/
	function SisifoArchivo ( $y="", $m="", $d="", $id_usr="" ) {
		$this -> fecha = "";
		if ( isset( $y ) && isset( $m ) && isset( $d )) {
			$this -> fecha = $y . "-" . $m . "-" . $d;
		} elseif ( isset( $y ) && isset( $m ) ) {
			$this -> fecha = $y . "-" . $m;
		}
		$this -> id_usr = $id_usr;
	}
	
	/**
	* Devuelve un array con las incidencias solicitadas para esa fecha y usuario.
	*/
	function dame ( ) {
			
		global $sisifoConf;
	
		$db = $sisifoConf -> getBd();
		
		
		$consulta = "SELECT id FROM Incidencia WHERE id_usuario = '".
		$this -> id_usr . "' AND fecha_llegada like '". $this -> fecha ."%'
			ORDER BY id DESC;";		

	
		$rs = $db-> execute ($consulta );
		
		$webIncidencias = array();
		while (!$rs->EOF) {
			$incidencia = new SisifoIncidencia ( $rs -> fields [id] );
			$webIncidencias[] = $incidencia;
			$rs->MoveNext();
		}
		
		//Habia� incidencias para ese usuario??????
		if ( array_count ( $webIncidencias ) == 0 ) {
			return array();
		}else {
			return $webIncidencias; ;
		}
		
	}
	
   //Coger las ltimas n incidencias llegada s al sistema:
    function getLastInci ($n,$filtro, $startfrom = 0) {
        return $this->getLastInciRange($n,$startfrom, $filtro );
    }


    //nueva funcion 2018
    function getAllInciUser ( $admin = false) {
		global $sisifoConf;
		
		$db = $sisifoConf -> getBd();

	    $uid = getUID($_SESSION['login']);

		$sql = "SELECT incidencia.id,estado_inci.descripcion, incidencia.id_usuario AS estado,tipo_incidencia.descripcion AS tipo, fecha_llegada,fecha_resolucion,desc_breve,cc
					FROM (( incidencia
						INNER JOIN estado_inci ON incidencia.id_estado = estado_inci.id_estado_in)
						INNER JOIN tipo_incidencia ON incidencia.tipo = tipo_incidencia.id)";
		
		#$sql = "SELECT * FROM listAllInci";

		if (!$admin){
			$sql = $sql . " WHERE id_usuario = $uid";
		}

		

		#$sql = "SELECT id,id_estado,fecha_llegada,fecha_resolucion,desc_breve,cc FROM incidencia WHERE id_usuario = $uid ORDER BY id DESC";


		$rs = $db->execute($sql);
		return $rs;
	}


    function getLastInciRange ($limit, $start, $filtro, $byAdmin = 0) {
 	
		global $sisifoConf;
		
		$db = $sisifoConf -> getBd();
	        $uid = getUID($_SESSION['login']);
		if ( (! isset ( $filtro ) ) || ( $filtro == "") ) {
	        	$sql = "SELECT id FROM incidencia WHERE id_usuario = $uid ORDER BY id DESC";
			$rs = $db->SelectLimit($sql,$limit, $start);
		} else {
	        	$sql = "SELECT id FROM incidencia WHERE id_usuario = $uid AND id_estado= $filtro
				 ORDER BY id DESC";	
			$rs = $db->SelectLimit($sql, -1, $start);
		}
		
		$webIncidencias = array();
		while (!$rs->EOF) {
			$incidencia = new SisifoIncidencia ( $rs -> fields ['id'] );
			$webIncidencias[] = $incidencia;
			$rs->MoveNext();
		}
		
		//Hasb� incidencias para ese usuario??????
		if ( array_count ( $webIncidencias ) == 0 ) {
			return array();
		}else {
			return $webIncidencias; ;
		}
    }


    //Devuelve el numero de incidencias enviadas por el usuario:

    function getNumInci ( $filtro ) {
        global $sisifoConf;

        $db = $sisifoConf -> getBd();
        $uid = getUID($_SESSION['login']);

        if ( (! isset ( $filtro ) ) || ( $filtro == "") ) {
                $sql = "SELECT COUNT(id) FROM incidencia WHERE id_usuario = $uid";
                $rs = $db->Execute ($sql,$limit, $start);
        } else {
                $sql = "SELECT count(id) FROM incidencia WHERE id_usuario = $uid AND id_estado= $filtro
                         ";
                $rs = $db->Execute ($sql, -1, $start);
        }
	
	$num = $rs -> fields[0];

	return $num;
	


    }
	
	
}    
    
	    
