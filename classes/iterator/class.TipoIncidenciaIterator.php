<?php

require_once ("class.SimpleIterator.php");

class TipoIncidenciaIterator extends SimpleIterator {
    
    var $resultSet;
    
    //function TipoIncidenciaIterator ( $consultaSQL, $nrows, $offset ) {    	
	function TipoIncidenciaIterator () {    	
    	global $sisifoConf;

	$db = $sisifoConf -> getBd();

	
		$this -> resultSet  = $db-> Execute (  "SELECT * FROM tipo_incidencia");
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
