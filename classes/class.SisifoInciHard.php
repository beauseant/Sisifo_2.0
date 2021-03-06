<?php 

require_once ("class.SisifoMaquina.php");
require_once ("class.SisifoIncidencia.php");



	/**
	* Clase para buscar informacion de una incidencia relacionada con el hardware
	* en la base de datos. Tambien se usa para dar de alta una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/  
class SisifoInciHard extends SisifoIncidencia{
    
    
       /**#@+
   * access private
   * @var object 
   */
   
   /**
   * Los datos de la maquina a los que se refiere la incidencia.
   */    
    var $datos_maquina;
    
   /**
   * El tipo de problema hardware de la incidencia.
   */        
    var $tipo_hard;
   /**#@-*/
   
    var $sisifoConf;

 	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/       
    function SisifoInciHard ( $id, $crear = false ) {    	

	   $this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	   $db = $this -> sisifoConf -> getBd();
		
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_hard WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> datos_maquina = new SisifoMaquina ( $resultSet -> fields ['id_equipo']); 
		$tipo_hard_num = $resultSet -> fields ['tipo'];	
		$sql = "SELECT * FROM tipo_hard WHERE id = $tipo_hard_num";
		$resultSet = $db->Execute ( $sql );
		$this -> tipo_hard = $resultSet -> fields ['descripcion'];
	}
    }

    
	/**
	* Metodo para insertar una nueva incidencia en la base de datos.
	* @param desc_breve descripcion breve.
	* @param desc_larga la descripcion larga.
	* @param tipo_hard El tipo de incidencia hardware.
	* @param id_maq El identificador de la maquina a la que se refiere.
	*/             
    function insertar ( $desc_breve, $desc_larga, $tipo_hard, $id_maq, $cc = 0,  $param1 = 0,$param2=0, $param3=0, $param4=0 ) {
    
	
	   	$db = $this -> sisifoConf -> getBd();
		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 1, $cc );
			$sql =  "INSERT INTO inci_hard (id, tipo, id_equipo ) VALUES ('";
			$sql .= $last_id . "','" . $tipo_hard . "','" . $id_maq . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		
		
		return $last_id;
    }
     
    
   	/**
	* Metodo para convertir la incidencia en una cadena que se pueda presentar en pantala.
	*/      
    function toStr () {    
    	
	$maquina = $this -> datos_maquina;
	
	$resultado = parent::toStr();
    	$resultado = $resultado . '
		<BR>
				<TR><TD class ="celdagrisclara">
					Nombre:</TD><TD>'. $maquina -> getNombre() . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
                                        Laboratorio:</TD><TD>'. $maquina -> getLaboratorio() .
                                '</TD></TR>
				<TR><TD class ="celdagrisclara">
                                        Direcci&oacute;n I.P:</TD><TD>'. $maquina -> getIp() .
                                '</TD></TR>
				<TR><TD class ="celdagrisclara">
					Tipo de incidencia:</TD><TD>'. $this -> tipo_hard . 
				'</TD></TR>				
	';
	
	return $resultado;    
    }
    

    function getTipo () {
	return $this -> tipo_hard;
    }
   
}    
    
?>
