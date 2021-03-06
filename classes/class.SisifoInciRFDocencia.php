<?php 

require_once ("class.SisifoIncidencia.php");
require_once ("class.SisifoUpload.php");


	/**
	* Clase para buscar informacion de una incidencia generica, es decir, que no sea,
	* hardware, software... Tambien se usa para dar de alta una incidencia de
	* esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/ 


class SisifoInciRFDocencia extends SisifoIncidencia{

    
       /**#@+
   * access private
   * @var object 
   */
   /**
    
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
   
    var $rutatmp;
 
    /**#@-*/
    
    var $sisifoConf;
    var $nombreal;
    var $tipotrabajo;
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/           
    function SisifoInciRFDocencia ( $id, $crear = false ) {    	
    	

	$this -> sisifoConf  	= new Configuracion ( $_SESSION ['fichero'] );
	$db 			= $this -> sisifoConf -> getBd();
	//$confg 			= $this -> sisifoConf -> getSisifoConf;
	$this -> rutatmp	= $this -> sisifoConf -> getRutaTmp(); 
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_rf_doc WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );

    		$this -> inciId = $id;	
		$this -> adjunto = new SisifoUpload ();

		$sql = "SELECT * FROM inci_rf_doc WHERE id = '" . $id . "'";
                $resultSet = $db->Execute ( $sql );
		$this -> nombreal = $resultSet -> fields ['alumnos']; 	
                $this -> tipotrabajo = $resultSet -> fields ['tipotrabajo'];        
	}
    }
    
    
    /**
    * Metodo para insertar una nueva incidencia de este tipo.
    * @param desc_breve La descripcion breve de la incidencia.
    * @param desc_larga La descripcion larga de la incidencia.
    */
    function insertar ( $tipotrabajo, $alumnos, $descripcion, $cc ) {

	$db = $this -> sisifoConf -> getBd();

		$db -> StartTrans();
			$desc_breve = "Trabajo RF docente ( " . $tipotrabajo . ")";
			$last_id = parent::insertar ($desc_breve, $descripcion, 11, $cc );
			$sql =  "INSERT INTO inci_rf_doc (id, tipotrabajo, alumnos ) VALUES ('";
                        $sql .= $last_id . "','" . $tipotrabajo . "','" . $alumnos ."')";
                        $res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    }
     
    
    
    /**
    * Devuelve los datos de la incidencia, incluidos los de la incidencia padre, 
    * convertidos en una cadena de texto en formato html.
    */
    function toStr () {
	
	$id = $this->inciId;

        $resultado = parent::toStr();

        $nombrea 	=  $this -> nombreal;
	$tipotrabajo 	=  $this -> tipotrabajo;

        $resultado = $resultado .
           "<TR> <TD class =\"celdagrisclara\"> Nombre del alumno:</TD><TD>$nombrea<TD></TR>" .
	   "<TR> <TD class =\"celdagrisclara\"> Tipo de trabajo:</TD><TD>$tipotrabajo<TD></TR>";


	return $resultado;    
    }
   
}    
    
?>
