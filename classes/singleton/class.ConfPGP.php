<?php 
  

 	/**
	* Esta clase se encarga de crear un objeto capaz de firmar y cifrar mensajes
	* mediante PGP. 
	* @package Configuracion
	* @see Configuracion::Configuracion()
	* @see MandarCorreo::Sisifopgp::SisifoPGP()
	*/
	class ConfPGP {
	
	        /**#@+
		  * access private
		  * @var object 
		  */
		/**
		* Objeto que es capaz de firmar y cifrar mensajes de texto con PGP.
		*/
		var $pgp;
		/**#@-*/
		
		/**
		*Constructor.
		* Se encarga de inicializar un objeto que pueda firmar y cifrar mensajes, 
		* gracias alos parametros obtenidos del fichero de configuracion.
		*/		
		function ConfPGP ( $parser ) {
				 
			$this -> usernamepgp 	= $parser -> usernamepgp;
			$this -> pgppath 	= $parser -> pgppath;
			$this -> userpgp 	= $parser -> userpgp;	
			$this -> userpgppath 	= $parser -> userpgppath;
			$this -> commentpgp 	= $parser -> commentpgp;
			
			$this -> pgp = new Sisifopgp ( $this -> usernamepgp, $this ->pgppath,
				 $this -> userpgp, $this -> userpgppath, $this -> commentpgp );

		}
		
		
		/**
		*Devuelve el objeto capaz de firmar y cifrar mensajes.
		*/			
		function getPGP () {
			return ( $this -> pgp  );

		}
	
	}
?>
