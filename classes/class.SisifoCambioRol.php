<?php 


require_once ("class.SisifoIncidencia.php");

	/**
	* Clase para buscar informacion de una incidencia relacionada con el cambio de status
	* de un usuario en la base de datos. Tambien se usa para insertar una incidencia de esas
	* caracteristicas. 
	* @package SisifoIncidencia
	*/  
class SisifoCambioRol extends SisifoIncidencia {

      /**#@+
   * access private
   * @var object 
   */
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
    
   /**
   * El login del usuario.
   */    
    var	$login;
       
   /**
   * El nombre del usuario.
   */           
    var $nombre;

   /**
   * El apellido del usuario.
   */               
    var $apellido;   
    
   /**
   * El rol que tenía.
   */       
    var $rol_act;

   /**
   * El nuevo rol que tendra en formato texto, no el id.
   */           
    var $rol_actTxt;
    
        
   /**
   * El nuevo rol que tendra.
   */       
    var $rol_nuevo;
     
   /**
   * El nuevo rol que tendra en formato texto, no el id.
   */           
    var $rol_nuevoTxt;
   /**#@-*/     
    

   
 var $sisifoConf;
    
	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos, o bien se 
	* indica que se quiere insertar una nueva.
	* @param id el identificador de la incidencia a buscar.
	* @param crear si se trata de un alta o de una insercion.
	*/          
	function SisifoCambioRol ( $id, $crear = false ) {
		$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	
		$db = $this -> sisifoConf -> getBd();
		
		if ( ! $crear ) {
			parent::inicializar ( $id );
			$sql = "SELECT * FROM inci_cambiorol WHERE id ='" . $id ."'";
			$resultSet = $db->Execute ( $sql );
			$this -> inciId = $resultSet -> fields ['id'];	
			$this -> login = $resultSet -> fields ['login'];
			$this -> nombre = $resultSet -> fields ['nombre'];
			$this -> apellido = $resultSet -> fields ['apellido'];
			$this -> rol_act = $resultSet -> fields ['rol_ant'];
			$this -> rol_nuevo = $resultSet -> fields ['rol_nuevo'];
			
			$sql = "SELECT * FROM rol WHERE id = ' " . $this -> rol_act . "'";
			$resultSet = $db->Execute ( $sql );
			$this -> rol_actTxt = $resultSet -> fields ['rolact'];
			$resultSet = $db->Execute ( $sql );
			$sql = "SELECT * FROM rol WHERE id = ' " . $this -> rol_nuevo . "'";
			$resultSet = $db->Execute ( $sql );
			$this -> rol_nuevoTxt = $resultSet -> fields ['rolact'];
			
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
		$rol_ant, $rol_nuevo, $nombre, $apellido, $cc ) {
	
		$db = $this -> sisifoConf -> getBd();
		
			$db -> StartTrans();
				$last_id = parent::insertar ($desc_breve, $desc_larga, 6, $cc );
				$sql =  "INSERT INTO inci_cambiorol (id, nombre, apellido, 
					login,rol_ant, rol_nuevo) VALUES ('";
				$sql .= $last_id . "','" . $nombre . "','" . $apellido .  
					"','" . $login . "','" . $rol_ant . "','" 
					. $rol_nuevo . "')";
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
				<TR><TD class ="celdagrisclara">
				   Rol actual:</TD><TD>'. $this -> rol_actTxt. 
				'</TD></TR>	
				<TR><TD class ="celdagrisclara">
				   Rol nuevo:</TD><TD>'. $this -> rol_nuevoTxt. 
				'</TD></TR>	
											
	';
	return $resultado;
    }
    		
	
	
	
	
}	
	
	       
