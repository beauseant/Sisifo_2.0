<?php 
	//setenv LD_LIBRARY_PATH ${LD_LIBRARY_PATH}:/usr/opt/php/lib
	//phpdoc -t targetdir -o HTML:frames:earthli -d parsedir
	// /usr/opt/php/bin/php ./phpdocwww -i /export/garza2/sblanco/public_html/incidencias/new/adodb/ -t ../doc/ -o HTML:frames:earthli -d /export/garza2/sblanco/public_html/incidencias/new/ -dn "Sisifo" -ti "::Sistema de gestion de incidencias Sisifo:: "        
	//include_once ('class.ConfRutas.php');
	include_once ('class.ConfBD.php');
	include_once ('class.ConfPGP.php');
	include_once ('class.ConfSisifo.php');
	include_once ('class.ConfLDAP.php');
	include_once ('xmlparser/class.XMLParser.php');
		
    
	/**
	* La clase Configuracion es la clase encargada de cargar todos los parametros de 
	* configuracion de la aplicacion Sisifo. La clase se encarga, por lo tanto, de 
	* gestionar los parametros de configuracion de la base de datos, el LDAP, PGP... * 
	* Asi como de inicializar el parser de XML que lee la configuracion.<br>
	* Para implementar la clase de configuracion se ha empleado el patron <b>singleton
	* </b>, que nos permite tener un solo objeto de configuracion en todo el sistema,
	* y de esta forma evitar que, por ejemplo, se abran demasiadas conexiones a la base
	* de datos. Para mas informacion sobre el patron:
	* {@link http://www.phppatterns.com/index.php/article/articleview/6/1/1/}
	* @package Configuracion
	* @see XMLParser::parserIt()
	*/	
	class Configuracion {
	
		 
		 // Variables privadas.
	        /**#@+
		  * access private
		  * @var object 
		  */
		 /**
		 *La base de datos de incidencias.
		 */
		 var $bd;
		 /**
		 *Objeto para firmar y cifrar mensajes con PGP.
		 */		 
		 var $pgp;
		 /**
		 *Configuracion generica, rutas, titulos...
		 */		 
 		 var $confgen;
		 /**
		 *Objeto para realizar consultas en ldap.
		 */		 
 		 var $confldap;
		/**#@-*/
		
		/**
		*<b>Constructor</b> de la clase.Recibe los datos del fichero ya procesados,
		* y se encarga de ir creando los diferentes objetos de configuracion 
		* necesarios, uno por cada elemento necesario (base de datos, PGP...)
		*/
		function Configuracion ( $fichero ) {
		
		//Cargamos la configuracion de Sisifo, rutas de PGP, rutas de la BD...  
		// desde un fichero xml:
		
			/*$parserMaker = new ParserMaker;
			$parser =& $parserMaker -> makeParser( $fichero );
			$datosxml = $parser -> parserIt ();
			*/
			$parser = simplexml_load_file( $fichero );
			//$parser -> parserIt ();
			
			
			$objbd = new ConfBD( $parser->DB );
			$a = $objbd-> getBD();
			$this -> bd = $a;
			
			$objpgp = new ConfPGP( $parser->PGP );
			$a = $objpgp -> getPGP();
			$this -> pgp = $a;
						
			$this -> confgen = new ConfSisifo( $parser->SISIFO );
			
			$this -> confldap = new ConfLDAP( $parser->LDAP );
			
		}		
		
		/**
		* Se encarga de devolver un objeto de base de datos, con la conexion
		* ya realizada, gracias a los datos del fichero de configuracion.
		*/
		function getBd () {
			return ( $this -> bd );
		}

		/**
		* Se encarga de devolver un objeto para manejar (cifrar, firmar..) el PGP, 
		* , gracias a los datos del fichero de configuracion.
		*/				
		function getPGP () {
			return ( $this -> pgp );
		}
		
		/**
		* Se encarga de decirnos si el usuario quiere o no usar PGP en la 
		* aplicacion.
		*/		
		function getUsarpgp() {
			return $this -> confgen -> getUsarpgp();
		}
		
		/**
		* Se encarga de devolver el correo que usara por defecto la aplicacion
		*/		
		function getIncimail() {
			return $this -> confgen -> getIncimail();
		}
		
		/**
		* Se encarga de cerrar la conexion a la base de datos
		*/				
		function closeDb() {
			$this -> bd -> Close ();
		}
		
		/**
		* Se encarga de darnos todos los parametros de configuracion adicionales,
		* tales como las rutas, el formato de la fecha deseado.. Todos esos datos
		* son tomados del fichero de configuracion.
		*/				
		function getSisifoConf(){
			
			return ($this -> confgen);
		
		}
		
		/**
		* Se encarga de devolver un objeto capaz de conectarse y consultar un 
		* servidor de LDAP.
		*/		
		function getConfLDAP() {
		
			return ( $this -> confldap );
			
		}

		function getRutaTmp () {
			return ( $this -> confgen-> getDirupload () );
		}
		
	
	}
    
    
		/**
		* Esta funcion es necesaria para implementar el patron singleton, ya que 
		* en PHP4 no se encuentran soportados los metodos estaticos. Si se usa una
		* version superior se podria meter esta funcion dentro de la clase.
		*/	
	function getConfiguracion () {
	
		//single instance
		static $instance;
	
		//Sino tenemos la instancia la creammos:
		if(!isset($instance)) {
			$instance = new Configuracion ();
		}
		return($instance);
	}
?>
