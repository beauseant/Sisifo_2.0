<?php 

require_once ("class.SisifoIncidencia.php");
require_once ("singleton/class.Configuracion.php");


	/**
	* Clase para buscar informacion de una incidencia relacionada con una peticion
	* / devolucion
	* de llave en la base de datos. Tambien se usa para dar de alta una incidencia de
	* esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/ 
class SisifoInciLlave extends SisifoIncidencia{

    
       /**#@+
   * access private
   * @var object 
   */
   /**
   * El laboratorio del cual se solicita la llave.
   */    
    var $laboratorio;
    
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
    
   /**
   * El tipo de incidencia, peticion o devolucion.
   */        
    var $tipo;
    /**#@-*/
    
    var $sisifoConf;
    
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/           
    function SisifoInciLlave ( $id, $crear = false ) {    	
    	
	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	$db = $this -> sisifoConf -> getBd();
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_llaves WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> laboratorio = $resultSet -> fields ['laboratorio'];
		$this -> tipo = $resultSet -> fields ['tipo'];
	}
    }
    
    
    /**
    * Metodo para insertar una nueva incidencia de este tipo.
    * @param desc_breve La descripcion breve de la incidencia.
    * @param desc_larga La descripcion larga de la incidencia.
    * @param estado El estado de la incidencia, peticion devolucion
    * @param laboratorio el laboratorio del que se quiere dicha llave.
    */
    function insertar ( $desc_breve, $desc_larga, $estado, $laboratorio, $cc=0,$param1 = 0,$param2=0, $param3=0, $param4=0 ) {
    
    	

	$db = $this -> sisifoConf -> getBd();

		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 5, $cc );
			$sql =  "INSERT INTO inci_llaves (id, laboratorio, tipo ) VALUES ('";
			$sql .= $last_id . "','" . $laboratorio . "','" . $estado . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    }
     
    
    
    /**
    * Devuelve los datos de la incidencia, incluidos los de la incidencia padre, 
    * convertidos en una cadena de texto en formato html.
    */
    function toStr () {    
    	
	$maquina = $this -> datos_maquina;
	
	$resultado = parent::toStr();
    	$resultado = $resultado . '
		<BR>
				<TR><TD class ="celdagrisclara">
					Laboratorio:</TD><TD>'. $this -> laboratorio . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
					Tipo:</TD><TD>'. $this -> tipo .
				'</TD></TR>				
	';
	
	return $resultado;    
    }
    

   
}    
    
?>
