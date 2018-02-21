<?php 


require_once ("class.SisifoIncidencia.php");


	/**
	* Clase para buscar informacion de una incidencia relacionada con el alta de un usuario
	* en la base de datos. Tambien se usa para dar de alta una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/  
class SisifoInciAltaUsr extends SisifoIncidencia{
    
    
  /**#@+
   * access private
   * @var object 
   */
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
   
   /**
   * El login sugerido para el nuevo usuario.
   */            
    var	$login_s;
    
   /**
   * El correo de contacto del nuevo usuario, para comunicar datos.
   */    
    var	$correo_con;
    
   /**
   * La contraseña que tendra -es optativo-.
   */           
    var	$passwd;
   
   /**
   * Que rol tendra el nuevo usuario, doctorando, proyectando...
   */            
    var $rol;
    
   /**
   * El identificador del nuevo usuario.
   */           
    var	$id_usr;
    
   /**
   * El Nombre del usuario.
   */           
    var $nombre;
    
   /**
   * El apellido del usuario.
   */    
    var $apellido;
   /**#@-*/ 
    
    var $sisifoConf;

	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/        
    function SisifoInciAltaUsr ( $id, $crear = false ) {    	
    
	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	

	  $db = $this -> sisifoConf -> getBd();
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_altas WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> login_s = $resultSet -> fields ['login_s'];
		$this -> correo_con = $resultSet -> fields ['correo_con'];
		$rol_num = $resultSet -> fields ['rol'];
		$this -> id_usr = $resultSet -> fields ['id_usr'];	
		$this -> nombre = $resultSet -> fields ['nombre'];
		$this -> apellido = $resultSet -> fields ['apellido'];

		$sql = "SELECT * FROM rol WHERE id = $rol_num";
		$resultSet = $db->Execute ( $sql );
		$this -> rol = $resultSet -> fields ['rolact'];
				
		
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
    function insertar ( $desc_breve, $desc_larga, $login, 
    	$correo_con, $nombre, $apellido, $rol, $cc ) {   
	

	   	$db = $this -> sisifoConf -> getBd();
	
		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 3, $cc );
			$sql =  "INSERT INTO inci_altas (id, login_s, correo_con, 
				passwd, rol, id_usr,nombre, apellido ) VALUES ('";
			$sql .= $last_id . "','" . $login . "','" . $correo_con . 
				"','". $pawssd . "','" . $rol . 
				"','" . $id_usr . "','" . $nombre . "','" 
				. $apellido . "')";
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
					Nombre:</TD><TD>'. $this -> nombre . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
				   Apellido:</TD><TD>'. $this -> apellido. 
				'</TD></TR>				
				<TR><TD class ="celdagrisclara">
				   Rol:</TD><TD>'. $this -> rol. 
				'</TD></TR>	
	';
	
	if ( $this -> login_s ) {
		$resultado = $resultado . 
			'<TR><TD class ="celdagrisclara">
				   Login sugerido:</TD><TD>'. $this -> login_s. 
			'</TD></TR>';
	}
	
	if ( $this -> correo_con ) {
		$resultado = $resultado . 
			'<TR><TD class ="celdagrisclara">
				   Correo contacto:</TD><TD>'. $this -> correo_con . 
			'</TD></TR>';	
	}
	return $resultado;    
    }
    

   
}    
    
?>
