<?php

require_once ("class.SimpleIterator.php");

class TipoCableIterator extends SimpleIterator {
    
    var $resultSet;
    
    var $sisifoConf;
    
    function TipoCableIterator () {  
    
    	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

	$db = $this -> sisifoConf -> getBd();

		$consultaSQL = "SELECT * FROM tipocable";
		//$this -> resultSet  = $db -> SelectLimit ( $consultaSQL, $nrows, $offset );
		$this -> resultSet  = $db -> Execute ( $consultaSQL );
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $this -> resultSet -> EOF );
    
    }
    
    function fetch () {    
	if  ( ! ($this -> EOF ()) ) {
		$resultado = '<OPTION value="' . $this -> resultSet -> fields ['id'] . '">' . 
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
