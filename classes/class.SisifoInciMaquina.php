<?php 

require_once ("class.SisifoIncidencia.php");



	/**
	* Clase para buscar informacion de una incidencia relacionada con el alta de una
	* nueva maquina... Tambien se usa para dar de alta una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/ 
	
class SisifoInciMaquina extends SisifoIncidencia{

    
       /**#@+
   * access private
   * @var object 
   */
   /**
    
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
    
    /**#@-*/
    
    var $sisifoConf;
    
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/           
    function SisifoInciMaquina ( $id, $crear = false ) {    	
    	

	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	$db = $this -> sisifoConf -> getBd();

	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_alta_maq WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> nombre_maq = $resultSet -> fields ['nombre'];	
		$this -> laboratorio = $resultSet -> fields ['laboratorio'];	
	}
    }
    
    
    /**
    * Metodo para insertar una nueva incidencia de este tipo.
    * @param desc_breve La descripcion breve de la incidencia.
    * @param desc_larga La descripcion larga de la incidencia.
    */
    function insertar ( $desc_breve, $desc_larga, $nombre_maq, $labo,$param1 = 0,$param2=0, $param3=0, $param4=0,$param5=0 ) {

	$db = $this -> sisifoConf -> getBd();

		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 8 );
			$sql =  "INSERT INTO inci_alta_maq (id, nombre, laboratorio) VALUES ('".
				$last_id . "', '" . $nombre_maq .  "', '" . $labo . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    }
     
    
    
    /**
    * Devuelve los datos de la incidencia, incluidos los de la incidencia padre, 
    * convertidos en una cadena de texto en formato html.
    */
    function toStr () {    
	
	$resultado = parent::toStr() .
	 '
		<BR>
				<TR><TD class ="celdagrisclara">
					Nombre m&aacute;quina:</TD><TD>'. $this -> nombre_maq . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
				   Laboratorio:</TD><TD>'. $this -> laboratorio. 
				'</TD></TR>				
	';
	
	
	return $resultado;    
    }
    

   
}    
    
?>