<?php



	/**
	* La clase XMLParser es la clase que lee el fichero de configuracion 
	* de la aplicacion. Dicho fichero se encuentra en formato XML, por lo que 
	* hay que crear un parser de XML que guarde dicha configuracion en una  array
	* estructura con forma de arbol.
	* @package XMLParser
	*/
	class XMLParser {
	
	        /**#@+
		  * access private
		  * @var object 
		  */
		 /**
		 *El fichero donde se encuentra la configuracion.
		 */	
		var $fichero;
		
		 /**
		 *El aray donde se guarda la posicion actual.
		 */	
		var $depth = array();
		
		 /**
		 *Cada entrada xml se guarda en una estructura con forma de arbol.
		 *
		 * El padre sera la entrada principal -ej configuracion de la base de 
		 * datos "BD"-, y los hijos los parametros de configuracion -host,user,passwd-
		 */
		var $nodos = array();	
	
		 /**
		 *Variable auxiliar para saber el padre del nodo actual que estamos recorriendo.
		 */		
		var $nombre_hijo;
		
		 /**
		 *Variable auxiliar para saber el hijo del nodo actual que estamos recorriendo.
		 */				
		var $nombre_padre;
		/**#@-*/
		
		/**
		* Constructor que se encarga de recibir la ruta con el fichero de configuracion
		* en XML.
		* @param string fichero la ruta al fichero de configuracion
		*/
		function XMLParser ( $fichero ) {
			$this -> fichero = $fichero;
		}
		
		
		/**
		* Funcion donde comienza el parser de XML.
		* access private
		* @param string parser
		* @param string name 
		* @param string attrs
		*/
		function startElement($parser, $name, $attrs) {
			
			//¿Es el primer elemento?
			$this -> primero = false;
			
			//Los elementos padres -es decir, los primeros- empiezan por CONFIG en nuestro caso:
			if ( $name == "CONFIG" ) {
				$this -> primero = true;
			}
			
			//Si tiene algún valor más:
			if (sizeof($attrs)) {
				//Los recorremos:
				while (list($k, $v) = each($attrs)) {
					//Creamos el nodo padre:
					if ( $this -> primero) {
						$this -> nombre_padre = $v;
						$this -> primero = false;
						$this -> nodos[$this -> nombre_padre] = 
						new nodo();
					//y vamos dando los valores de los hijos, para cuando
					// haya que insertarlos,
					//eso se hará en characterData:
					}else {
						$this -> nombre_hijo = $v;
					}
			}       
			} 
			//Seguimos avanzando.
			$this -> depth[$parser]++;
		}
		
		/**
		* Funcion que se llama cada final de elemento.
		* access private
		*/
		function endElement($parser, $name) {			
			$this -> depth[$parser]--;
		}
		
		/**
		* Funcion que se llama cada final de elemento.
		* access private
		*/		
		function characterData($parser, $data) {
				
				//Si tenemos algún dato se inserta en el padre y se crea el 
				//hijo:
				if ( strlen ( $data ) > 2 ) {
					$this -> nodos[ $this -> nombre_padre ] ->
						 hijos[$this -> nombre_hijo] = $data;
				}
				$this -> depth[$parser]++;
			
			}
			
		/**
		* Funcion que se llama para comenzar el parser.
		*/		
		function parserIt () {
		
			$xml_parser = xml_parser_create();
			
			//Al estar dentro de un objeto la llamada debe ser:
			xml_set_element_handler( $xml_parser, array(&$this,"startElement"),
				 array(&$this,"endElement") );
			
				 
				//En vez de:
			//xml_set_element_handler($xml_parser, "$this->startElement", "$this->endElement");
			//xml_set_character_data_handler($xml_parser, "$this->characterData");
			xml_set_character_data_handler ($xml_parser,
				 array(&$this,"characterData") );
				 
			
			if (!($fp = fopen($this ->fichero, "r"))) {
				die("Error al abrir el fichero de configuracion " . 
				$this -> fichero.".");
			}
			
			while ($data = fread($fp, 4096)) {
			if (!xml_parse($xml_parser, $data, feof($fp))) {
			die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
			}
			}
			xml_parser_free($xml_parser);
			
			return $this -> nodos;	
		}

		/**
		* Funcion que devuelve los datos del arbol XML creado.
		* 
		* El padre sera la entrada 
		* principal -ej configuracion de la base de datos "BD"-, y los hijos los
		* parametros de configuracion -host,user,passwd-
		*/				
		function getEntry ( $padre, $hijo ) {
		
			return ( $this -> nodos [ $padre ] -> hijos[ $hijo ] );
		
		}
		
	} //XMLParser
	
	/**
	* Esta clase se usa como una clase auxiliar para guardar una estructura en forma de arbol
	* que contenga la informacion del fichero. El padre sera la entrada principal -ej
	* configuracion de la base de datos "BD"-, y los hijos los parametros de 
	* configuracion -host,user,passwd-
	* @package XMLParser
	*/	
	class Nodo {
		var $hijos = array();	
	}
	
	/**
	* Esta clase se usa para gestionar la creacion del parser xml mediante el patron 
	* <b>factory</b>, que nos permite abstraer la creacion del parser de su gestion.
	* Para mas informacion sobre el patron:
	* {@link http://www.phppatterns.com/index.php/article/articleview/49/1/1/}
	* @package XMLParser	
	*/
	class ParserMaker {
		// The factory method...
		function & makeParser ( $fichero  ) {
			
			return new XMLParser ( $fichero ); 
    		}	
	
	}



?>