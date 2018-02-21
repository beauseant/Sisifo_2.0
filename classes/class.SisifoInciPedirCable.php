<?php 


require_once ("class.SisifoIncidencia.php");


	/**
	* Clase para buscar informacion de una incidencia relacionada con el alta de un usuario
	* en la base de datos. Tambien se usa para dar de alta una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/  
class SisifoInciPedirCable extends SisifoIncidencia{
    
    
  /**#@+
   * access private
   * @var object 
   */
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
   
   /**
   * La cantidad solicitada.
   */            
    var	$cantidad;
    
   
   /**
   * Tipo de cable pedido 
   */            
    var $tipo;
    
   /**#@-*/ 
    
    var $sisifoConf;

	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/        
    function SisifoInciPedirCable ( $id, $crear = false ) {    	
    
	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	

	  $db = $this -> sisifoConf -> getBd();
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_cables WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> cantidad = $resultSet -> fields ['cantidad'];	
		$tipo_num = $resultSet -> fields ['tipo']; 
		

		$sql = "SELECT * FROM tipocable WHERE id = $tipo_num";
		$resultSet = $db->Execute ( $sql );
		$this -> tipo = $resultSet -> fields ['descripcion'];
				
		
	}
    }

    
	/**
	* Metodo para insertar una nueva incidencia en la base de datos.
	* @param desc_breve descripcion breve.
	* @param desc_larga la descripcion larga.
	* @param login el login sugerido para el nuevo usuario
	* @param correo_con el correo de contacto
	* @param nombre el nombre
	* @param apellido el apellido
	* @param rol el rol del nuevo usuario.
	*/              
    function insertar ( $desc_breve, $desc_larga, $cantidad
		,$tipo, $cc) {   
	


	   	$db = $this -> sisifoConf -> getBd();
	
		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 9, $cc );
			$sql =  "INSERT INTO inci_cables (id, cantidad,
				tipo ) VALUES ('";
			$sql .= $last_id . "','" . $cantidad . "','" . $tipo . 
				 $apellido . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    }
     
    
	/**
	* Metodo para convertir la incidencia en una cadena que se pueda presentar en pantala.
	*/    
    function toStr () {    
    	
	$resultado = parent::toStr();
	$resultado = $resultado . 
	 '
		<BR>
				<TR><TD class ="celdagrisclara">
					Tipo:</TD><TD>'. $this -> tipo . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
				   Cantidad:</TD><TD>'. $this -> cantidad. 
				'</TD></TR>				
	';
	
	return $resultado;    
    }
    

   
}    
    
?>
