<?php 

	require_once("adodb/adodb-errorhandler.inc.php");
	require_once("adodb/adodb.inc.php");


  
	/**
	* Esta clase se encarga de gestionar la base de datos del sistema.
	* Para ello crea un objeto de base de datos a partir de los datos de
	* configuracion obtenidos del fichero de configuracion. 
	* @package Configuracion
	* @see Configuracion::Configuracion()
	*/
	class ConfBD {

		 // Variables privadas.
	        /**#@+
		  * access private
		  * @var object 
		  */
		 /**
		 *La base de datos de incidencias.
		 */		
		var $db;
		/**#@-*/
		
		/**
		*Constructor.
		* Se encarga de inicializar un objeto de base de datos con los parametros
		* obtenidos del fichero de configuracion.
		* @param XMLParser El parser con los datos de configuracion
		*/
		function ConfBD ( $parser ) {
			
			$host   = $parser -> host;
			$dbase  = $parser -> dbase;
			$user   = $parser -> user;
			$passwd = $parser -> passwd;
			$dbtype = $parser -> dbtype;			

			$dbtmp = NewADOConnection ( $dbtype );
			$dbtmp -> Connect( $host,$user,$passwd, $dbase );
			$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;		
			
			$this -> db = $dbtmp;
			$this -> db->setCharset('utf8');


			
		}
		
		
		/**
		*Devuelve la base de datos que se usara en el sistema.
		*/		
		function getBD () {
		
			return ( $this -> db  );
		
		}
	}
?>
