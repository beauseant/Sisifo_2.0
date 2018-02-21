<?php

require_once ("class.SimpleIterator.php");

	/**
	* Esta clase se encarga de realizar el recorrido sobre las incidencias de la BD.
	* @see SimpleIterator::SimpleIterator()
	* @package Iterator
	*/  
class IncidenciaIterator extends SimpleIterator {
    
	/**#@+
	* access private
	* @var object 
	*/
	/**
	*El vector con el resultado.
	*/    
    var $resultSet;
    /**#@-*/	
    
    
   /**
    * Constructor.
    * Se encarga de inicializar la consulta SQL del iterador.
    * @param consultaSQL La consulta SQL. 
    * @param nrows posicion de comienzo, en este caso no se usa. 
    * @param offset el numero de datos a mostrar, en este caso no se usa.         
    */    
    function IncidenciaIterator ( $consultaSQL, $nrows, $offset ) {
    	global $sisifoConf;

	$db = $sisifoConf -> getBd();

	
		$this -> resultSet  = $db->SelectLimit ( $consultaSQL, $nrows, $offset );
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $this -> resultSet -> EOF );
    
    }
    
    function fetch () {    
	if  ( ! ($this -> EOF ()) ) {
		$incidencia = new SisifoIncidencia ( $this -> resultSet -> fields ['id'] );
		$this -> resultSet -> MoveNext();
    	}
	return $incidencia;
    }
    
    function size() {
        return ( $this -> resultSet -> rowCount() );
    }

}
?>
