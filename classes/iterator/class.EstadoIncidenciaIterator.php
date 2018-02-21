<?php

require_once ("class.SimpleIterator.php");

	/**
	* Esta clase se encarga de realizar el recorrido sobre todos los posibles estados de
	* una incidencia, de forma que se puedan añadir nuevos estados de incidencia sin tener
	* que tocar nada del codigo - excepto añadir un nuevo campo en la base de datos -.
	* @see SimpleIterator::SimpleIterator()
	* @package Iterator
	*/  
class EstadoIncidenciaIterator extends SimpleIterator {
    
    
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
    
	//function EstadoIncidenciaIterator ( $consultaSQL, $nrows, $offset ) {    	
function EstadoIncidenciaIterator () {    
	global $sisifoConf;

	$db = $sisifoConf -> getBd();

	
		$this -> resultSet  = $db-> Execute (  "SELECT * FROM estado_inci");
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $this -> resultSet -> EOF );
    
    }
    
    function fetch () {    
	if  ( ! ($this -> EOF ()) ) {
		$resultado = $this -> resultSet -> fields ['descripcion'];
		$this -> resultSet -> MoveNext();
    	}
	return $resultado;
    }
    
    function size() {
        return ( $this -> resultSet -> rowCount() );
    }

}
?>
