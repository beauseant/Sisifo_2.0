<?php

require_once ("class.SimpleIterator.php");

class MaquinaIterator extends SimpleIterator {
    
    var $resultSet;
    
    var $sisifoConf;

    var $idMaquina;
    var $serialMaquina;
    var $laboratorioMaquina;
    var $nombreMaquina;


    
    function MaquinaIterator ( $nrows, $offset ) {  
    
    	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

	$db = $this -> sisifoConf -> getBd();

		$consultaSQL = "SELECT * FROM maquina ORDER BY Nombre";
		//$this -> resultSet  = $db -> SelectLimit ( $consultaSQL, $nrows, $offset );
		$this -> resultSet  = $db -> Execute ( $consultaSQL );
		$posActual = 0;
    }
    
    function EOF () {
	
	return ( $this -> resultSet -> EOF );
    
    }
    
    function fetch () {    
	if  ( ! ($this -> EOF ()) ) {
		$this -> idMaquina = $this -> resultSet -> fields ['id'];
		$this -> serialMaquina =  $this -> resultSet -> fields ['serial'];
		$this -> laboratorioMaquina =  $this -> resultSet -> fields ['id_lab'];		
		$this -> nombreMaquina =  $this -> resultSet -> fields ['nombre'];

		$this -> resultSet -> MoveNext();
    	} 
	
    }
    
    function size() {
        return ( $this -> resultSet -> rowCount() );
    }


    function getId () {

	return $this -> idMaquina; 

    }

    function getLaboratorio () {

        return $this -> laboratorioMaquina;

    }


    function getSerial () {

        return $this -> serialMaquina;

    }

   function getNombre () {

        return $this -> nombreMaquina;

    }


}
?>
