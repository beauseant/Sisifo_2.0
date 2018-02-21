<?php 
  
	/**
	* Esta clase se encarga cargar la configuracion generica de la aplicacion,
	* directorio, formatos de fecha. Dicha configuracion se encuentra en un fichero
	* XML.
	* @package Configuracion
	* @see Configuracion::Configuracion()
	*/  
	class ConfSisifo {
	
	 	/**#@+
		  * access private
		  * @var string 
		  */
		
		/**
		* Numero de incidencias a mostrar en pantalla para el usuario:
		*/
		var $limit;
		
		/**
		* Numero de incidencias a mostrar en pantalla para el administrador:
		*/
		var $limit_admin;
		
		/**
		* Formato de la fecha
		*/
		var $dateformat;
		 
		/**
		* Vigilar html en los mensajes y correos.
		*/
		var $safe_comments;
		
		/**
		* Usamos pgp?
		*/
		var $usarpgp;
		
		/** 
		* Direccion de correo del sistema de incidencias:
		*/
		var $incimail;
		
		/**
		* URL de la web principal
		*/
		var $baseurl;
		
		/**
		* directorio donde se encuentra:
		*/
		var $basepath; 

		/**
		* servidor de correo que usaremos:
		*/		
		var $smtphost;

		/**
		* directorio para los adjuntos temporales
		var $dirupload;
		*/

		/**#@-*/ 
		
		/**
		*Constructor.
		* Se encarga de inicializar los parametros de configuracion.
		* @param XMLParser El parser con los datos de configuracion
		*/
		var $sisifoConf;
		
		function ConfSisifo ( $parser ) {
		
			/*$this -> usarpgp = false;
			$this -> safe_comments = false;
			
			if ( $parser -> getEntry ("PGP","usarpgp") == "true" ) {
				$this -> usarpgp = true;
			}else {
				$this -> usarpgp = false;
			}
			
			if ( $parser -> getEntry ("SISIFO","safe_comments") == "true" ) {
				$this -> safe_comments = true;
			}				
			*/
			$this -> usarpgp = true;
			$this -> safe_comments = true;
			
			
			$this -> limit = substr ( $parser -> limit,1,2);
			$this -> limit_admin = substr ( $parser -> limit_admin,1,2);
			
			$this -> dateformat = $parser -> dateformat;
			$this -> incimail   = $parser -> incimail;
			$this -> baseurl    = $parser -> baseurl;

			$this -> basepath   = $parser -> basepath;

			$this -> smtphost   = $parser -> smtphost;
			$this -> dirupload  = $parser -> dirupload;
		}
		
		
		/**
		* Devuelve si queremos usar o no PGP.
		*/				
		function getUsarpgp() {
			return (string) $this -> usarpgp;
		}
		
		/**
		* Devuelve el correo de la pagina de incidencias.
		*/						
		function getIncimail() {
			return $this -> incimail;
		}
		
		/**
		* Devuelve el numero de incidencias que se muestran en pantalla para el usuario.
		*/						
		function getLimit () {
		
			return ( $this -> limit  );
		
		}
		
		/**
		* Devuelve el numero de incidencias que se muestran en pantalla para el admin.
		*/		
		function getLimitAdmin () {
		
			return ( $this -> limit_admin  );
		}

		/**
		* Devuelve el formato de fecha que se usara.
		*/		
		function getDateFormat () {
		
			return ( $this -> dateformat  );
		
		}

		/**
		* Devuelve si queremos comentarios sin HTML malicioso.
		*/		
		function getSafeComments () {
		
			return ( $this -> safe_comments  );		
		}
		
		/**
		* Devuelve la plantilla que se usara para mostrar incidencias.
		* Esa plantilla se encuentra guardada en la base de datos.
		*/		
		function getTemplate() {
			//global $sisifoConf;
			$this -> sisifoConf  = new Configuracion ( 
				$_SESSION ['fichero'] );
				
			$db = $this -> sisifoConf -> getBd();	
			$sql = "SELECT * FROM template WHERE descripcion='general'";
			$rs = $db->Execute($sql);
			$template = $rs->fields['template'];
			return $template;
		}		

		/**
		* Devuelve la plantilla que se usara para mostrar los correos.
		* Esa plantilla se encuentra guardada en la base de datos.
		*/				
		function getTemplateMail() {
			
			$this -> sisifoConf  = new Configuracion ( 
				$_SESSION['fichero'] );
		
			$db = $this -> sisifoConf -> getBd();	
			$sql = "SELECT * FROM template WHERE
				 descripcion='correoinci'";
			$rs = $db->Execute($sql);
			$template = $rs->fields['template'];
			return $template;
		}		
		

		/**
		* Devuelve url donde se encuentra la aplicacion.
		*/						
		function getBaseurl () {		
			return (string) $this -> baseurl;		
		}
		
		/**
		* Devuelve el path donde se encuentra la aplicacion.
		*/								
		function getBasepath() {
			return $this -> basepath;	
		}
	
		function getSmtphost () {
			return $this -> smtphost;
		}

		function getDirupload () {
			return $this -> dirupload;
		}
	}
	
?>
