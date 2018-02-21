<?php 


require_once ("class.SisifoIncidencia.php");

	/**
	* Clase para buscar informacion de una incidencia relacionada con baja de un usuario
	* en la base de datos. Tambien se usa para dar de baja una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/  
class SisifoInciBajaUsr extends SisifoIncidencia{
    
    
      /**#@+
   * access private
   * @var object 
   */
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
    
   /**
   * El login del usuario a dar de baja.
   */    
    var	$login;
    
   /**
   * El correo de contacto del usuario.
   */           
    var	$correo_con;
    
   /**
   * El identificador del usuario.
   */           
    var	$id_usr;
    
   /**
   * El nombre del usuario a dar de baja.
   */           
    var $nombre;

   /**
   * El apellido del usuario.
   */               
    var $apellido;   
    
   /**
   * El rol que tenía.
   */       
    var $rol;
   /**#@-*/     
    
    var $sisifoConf;
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/          
    function SisifoInciBajaUsr ( $id, $crear = false ) {    	

    
    	$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );

	$db = $this -> sisifoConf -> getBd();
	
	   if ( ! $crear ) {
		parent::inicializar ( $id );
		$sql = "SELECT * FROM inci_bajas WHERE id ='" . $id ."'";
		$resultSet = $db->Execute ( $sql );
    		$this -> inciId = $resultSet -> fields ['id'];	
		$this -> login = $resultSet -> fields ['login'];
		$this -> correo_con = $resultSet -> fields ['correo_con'];
		$this -> id_usr = $resultSet -> fields ['id_usr'];	
		$this -> nombre = $resultSet -> fields ['nombre'];
		$this -> apellido = $resultSet -> fields ['apellido'];
		$this -> rol = $resultSet -> fields ['rol'];
	}
    }
    
    
	/**
	* Metodo para insertar una nueva incidencia en la base de datos.
	* @param desc_breve descripcion breve.
	* @param desc_larga la descripcion larga.
	* @param login el login del usuario
	* @param correo_con el correo de contacto
	* @param nombre el nombre
	* @param apellido el apellido
	* @param rol el rol del usuario.
	* @param id_usr el identificador del usuario.	
	*/             
    function insertar ( $desc_breve, $desc_larga, $login, 
    	$correo_con, $id_usr, $nombre, $apellido, $rol, $cc ) {   
	


	$db = $this -> sisifoConf -> getBd();
	
	
		$db -> StartTrans();
			$last_id = parent::insertar ($desc_breve, $desc_larga, 4, $cc );
			$sql =  "INSERT INTO inci_bajas (id, login, correo_con, 
				id_usr,nombre, apellido, rol ) VALUES ('";
			$sql .= $last_id . "','" . $login . "','" . $correo_con .  
				"','" . $id_usr . "','" . $nombre . "','" 
				. $apellido . "','" . $rol . "')";
			$res = $db-> Execute ($sql);
		$db -> CompleteTrans();
		return $last_id;
    }
     
	/**
	* Metodo para convertir la incidencia en una cadena que se pueda presentar en pantala.
	*/     
    function toStr () {    
    	
	$resultado = parent::toStr() .
	 '
		<BR>
				<TR><TD class ="celdagrisclara">
					Nombre:</TD><TD>'. $this -> nombre . 
				'</TD></TR>
				<TR><TD class ="celdagrisclara">
				   Apellido:</TD><TD>'. $this -> apellido. 
				'</TD></TR>				
				<TR><TD class ="celdagrisclara">
				   Login:</TD><TD>'. $this -> login. 
				'</TD></TR>	
							
	';
	
	
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
