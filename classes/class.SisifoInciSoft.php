<?php 

require_once ("class.SisifoMaquina.php");
require_once ("class.SisifoIncidencia.php");




	/**
	* Clase usada para procesar las incidencias de tipo software. Y los diversos
	* subtipos de dicha incidencia, instalacion software, sistema operativo...
	* @package SisifoIncidencia
	*/ 
class SisifoInciSoft extends SisifoIncidencia{
    
    
           /**#@+
   * access private
   * @var object 
   */
   
   /**
   * los datos de la maquina a los que se refiere dicha incidencia.
   */
    var $datos_maquina;
    
    /**
    * el subtipo de incidencia software, instalacion software, sistema operativo...
    */
    var $tipo_soft;
   /**#@-*/
    
    var $sisifoConf;

    
    	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/           
    function SisifoInciSoft ( $id, $crear = false ) {    	
	
	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

	$db = $this -> sisifoConf -> getBd();

	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_soft WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> datos_maquina = new SisifoMaquina ( $resultSet -> fields ['id_equipo']); 
		$tipo_soft_num = $resultSet -> fields ['tipo'];	
		$sql = "SELECT * FROM tipo_soft WHERE id = $tipo_soft_num";
		$resultSet = $db->Execute ( $sql );
		$this -> tipo_soft = $resultSet -> fields ['descripcion'];	
	}
    }    
        
    
    
    /**
    * Metodo para insertar una nueva incidencia de este tipo.
    * @param desc_breve La descripcion breve de la incidencia.
    * @param desc_larga La descripcion larga de la incidencia.
    * @param tipo_soft El subtipo de incidencia software.
    * @param id_maq La identificacion de la maquina a la que se refiere la incidencia.
    */
    function insertar ( $desc_breve, $desc_larga, $tipo_soft, $id_maq, $cc ) {
    	

	$db = $this -> sisifoConf -> getBd();

		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 2, $cc );
			$sql =  "INSERT INTO inci_soft (id, tipo, id_equipo ) VALUES ('";
			$sql .= $last_id . "','" . $tipo_soft . "','" . $id_maq . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    
    }
    

    /**
    * Devuelve los datos de la incidencia, incluidos los de la incidencia padre, 
    * convertidos en una cadena de texto en formato html.
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
					Tipo de incidencia:</TD><TD>'. $this -> tipo_soft . 
				'</TD></TR>				
	';
	
	return $resultado;    
    }
    
   function getTipo () {
	return $this -> tipo_soft;
    }     

    
}    
    
?>
