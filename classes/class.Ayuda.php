<?php 


include_once("lib.php");

	/**
	* Clase usada para gestionar la ayuda que se presta al usuario del sistema.
	*/  
class Ayuda {
    
   
   /**#@+
   * access private
   * @var string 
   */
   /**
   * El id de la ayuda.
   */   
   var $id;
   
   /**
   * El texto de la ayuda.
   */   
   var $texto;
   
   /**#@-*/ 
	
	
	
	/**
	* Constructor.
	* Formatea la fecha con las incidencias de un usuario 
	* @param id el identificador del que se solicita ayuda.
	*/
	function Ayuda ( $id ) {
	
         	$this -> sisifoConf = new Configuracion ( 
			$_SESSION ['fichero'] );
		//Sacamos la tabla en la que se encuentra la incidencia. Si es de tipo hardware
		//estar�en la tabla inci_hard, por ejemplo.
		$db = $this -> sisifoConf -> getBd();
		$sql = "SELECT * FROM ayuda WHERE id='" . $id ."'";	
		
		$rs = $db -> Execute ( $sql );
						
		$this -> id = $id;
		$this -> texto = $rs  -> fields ['descripcion'];
	}
	
	/**
	* Funcion que devuelve el identificador del elemento de ayuda solicitado.
	*/
	function getId () {
		return $this -> id;
	}
	
	/**
	* Funcion que devuelve el texto con la ayuda solicitada.
	*/
	function getTexto () {
		return $this -> texto;
	}
	
    

}    
    
	    
