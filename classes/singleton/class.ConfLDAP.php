<?php 


	/**
	* Esta clase se encarga de gestionar la conexion con el servidor LDAP.
	* @package Configuracion
	* @see Configuracion::Configuracion()
	*/  
	class ConfLDAP {

	        /**#@+
		  * access private
		  * @var object 
		  */
		 /**
		 *El host donde se consultar�el ldap.
		 */					
		var $ldaphost;
		
		 /**
		 *La cadena de conexion del usuario.
		 */				
		var $userbind; 
		
		 /**
		 *La cadena de conexión para saber si es administrador.
		 */						
		var $adminbind; //la cadena de conexi� para saber si es administrador
		
		 /**
		 *Cadena para sacar el correo de un usuario teniendo el login.
		 */								
		var $searchbind; 
		/**#@-*/
		
		/**
		*Constructor.
		* Se encarga de inicializar los parametros del servidor de LDAP.
		* @param XMLParser El parser con los datos de configuracion
		*/		
		function ConfLDAP ( $parser ) {
			
			$this -> ldaphost   = $parser -> ldaphost;
			$this -> userbind   = $parser -> userbind;
			$this -> adminbind  = $parser -> adminbind;
			$this -> searchbind = $parser -> searchbind;
		}
		
		
		/**
		* Devuelve el host en el que se encuentra el LDAP.
		*/
		function getHost () {
		
			return ( $this -> ldaphost  );
		
		}

		/**
		* Devuelve la cadena de conexion del usuario.
		*/		
		function getUsrBind () {
		
			return ( $this -> userbind  );
		
		}

		/**
		* Devuelve la cadena de conexion del administrador
		*/		
		function getAdmBind () {
		
			return ( $this -> adminbind  );
		
		}
		
		/**
		* Devuelve la cadena para sacar el correo de un usuario teniendo el login
		*/
		function getSearchBind () {
		
			return ( $this -> searchbind );
		
		}
				
				
	}
	
?>
