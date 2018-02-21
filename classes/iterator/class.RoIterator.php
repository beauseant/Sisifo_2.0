<?php

require_once ("class.SimpleIterator.php");


	/**
	* Esta clase se encarga de realizar el recorrido sobre todos los posibles roles de 
	* un usuario, de forma que se puedan añadir nuevos roles sin tener
	* que tocar nada del codigo - excepto añadir un nuevo campo en la base de datos -.
	* @see SimpleIterator::SimpleIterator()
	* @package Iterator
	*/  
class EstadoInciIterator extends SimpleIterator {

	/**#@+
	* access private
	* @var object 
	*/
	/**
	*El vector con el resultado.
	*/        
    var $resultSet;
    /**#@-*/	
    
    function EstadoInciIterator ( ) {  
    
       global $sisifoConf;

	
		$db = $sisifoConf -> getBd();
	

		$consultaSQL = "SELECT * FROM estado_inci";
		$this -> resultSet  = $db->SelectLimit ( $consultaSQL );
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $this -> resultSet -> EOF );
    
    }
    
    function fetch () {    
	if  ( ! ($this -> EOF ()) ) {
		$resultado = "<OPTION value=" . $this -> resultSet -> fields ['id'] . ">" . 
			$this -> resultSet -> fields ['descripcion'];		
		$this -> resultSet -> MoveNext();
    	} 
	
	return $resultado;
    }
    
    function size() {
        return ( $this -> resultSet -> rowCount() );
    }

}
?>