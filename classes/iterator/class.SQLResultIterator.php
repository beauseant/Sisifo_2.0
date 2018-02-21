<?php

require_once ("class.SimpleIterator.php");

class SQLResultIterator extends SimpleIterator {
    
    var $resultSet;
    
    function SQLResultIterator ( $consultaSQL, $nrows, $offset ) {    	
    	global $sisifoConf;

	$db = $sisifoConf -> getBd();

	
		$this -> resultSet  = $db->SelectLimit ( $consultaSQL, $nrows, $offset );
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $resultSet -> EOF );
    
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
