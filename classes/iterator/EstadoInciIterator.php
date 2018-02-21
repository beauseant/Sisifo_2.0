<?php

require_once ("class.SimpleIterator.php");

class EstadoInciIterator extends SimpleIterator {
    
    var $resultSet;
    
    function EstadoInciIterator ( ) {  
    
	$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

	
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
		$resultado = "<OPTION value=" . $this -> resultSet -> fields ['id_estado_in'] . ">" . 
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
