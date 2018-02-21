<?php 

require_once ("class.SisifoIncidencia.php");
require_once ("class.SisifoUpload.php");


	/**
	* Clase para buscar informacion de una incidencia generica, es decir, que no sea,
	* hardware, software... Tambien se usa para dar de alta una incidencia de
	* esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/ 
	
class SisifoInciAudio extends SisifoIncidencia{

    
       /**#@+
   * access private
   * @var object 
   */
   /**
    
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
   
    var $rutatmp;
 
    /**#@-*/
    
    var $sisifoConf;
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/           
    function SisifoInciAudio ( $id, $crear = false ) {    	
    	

	$this -> sisifoConf  	= new Configuracion ( $_SESSION ['fichero'] );
	$db 			= $this -> sisifoConf -> getBd();
	$confg 			= $this -> sisifoConf -> getSisifoConf;
	$this -> rutatmp	= $this -> sisifoConf -> getRutaTmp(); 
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_audio WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $id;	
		$this -> adjunto = new SisifoUpload ();
	}
    }
    
    
    /**
    * Metodo para insertar una nueva incidencia de este tipo.
    * @param desc_breve La descripcion breve de la incidencia.
    * @param desc_larga La descripcion larga de la incidencia.
    */
    function insertar ( $desc_breve, $desc_larga, $cc ) {
    
    	

	$db = $this -> sisifoConf -> getBd();

		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 13, $cc );
		$db -> CompleteTrans();
		return $last_id;
    }
     
    
    
    /**
    * Devuelve los datos de la incidencia, incluidos los de la incidencia padre, 
    * convertidos en una cadena de texto en formato html.
    */
    function toStr () {
	
	$id = $this->inciId;
        $resultado = parent::toStr();

	return $resultado;    
    }
   
}    
    
?>
