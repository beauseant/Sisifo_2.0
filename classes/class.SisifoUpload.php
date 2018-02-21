<?php 




	/**
	* Clase para subir archivos desde el sistema de el ordenador del
	* usuario hasta la pagina de incidencias.
	* @package SisifoIncidencia
	*/ 
	
class SisifoUpload {

    
       /**#@+
   * access private
   * @var object 
   */
   /**
    
   /**
   * El identificador de la incidencia.
   */       
    var $inciId;
    
    /**#@-*/
    
    var $sisifoConf;

    //array con los ficheros adjuntos, cada posicion del mismo es
    // un array con el nombre el tipo y el tamanno
    var $adjuntos;
    //borrar estos    
    var $name;
    var $size;
    var $type;

    function SisifoUpload ( ) {
	$this -> adjuntos = array ();

    }
    
	/**
	* insertar el fichero adjunto en la base de datos.
	* @param id_inci el identificador de la incidencia a buscar.
	* @param uploadfile fichero a subir.
        * @param size size del fichero a subir.
        * @param name nombre fichero a subir.
        * @param type tipo mime del fichero.

	*/           
    function insertar ( $id_inci, $uploadfile, $size, $name, $type  ) {    	
    	

		$this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
		$db = $this -> sisifoConf -> getBd();

		$cadena =  "INSERT INTO upload ( name,type,size,content) VALUES ('$name','$type','$size',lo_import ('$uploadfile' ))"; 	
		$resultSet = $db->Execute ( $cadena );

		$cadena = "SELECT currval('upload_id_seq')";
                $resultSet = $db->Execute ( $cadena );
    		$id = $resultSet -> fields ['currval'];	

		$cadena = "INSERT INTO inci_upload (id_inci, id_upload) VALUES ('$id_inci','$id')";

                $resultSet = $db->Execute ( $cadena );
    }
   
    function sacarAdjunto ( $id_inci ) {
	$datos = array ();

                $this -> sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
                $db = $this -> sisifoConf -> getBd();

                $cadena 	=  "SELECT * FROM inci_upload WHERE ( id_inci = '$id_inci' )";
                $resultSet 	= $db->Execute ( $cadena );


		while (!$resultSet->EOF) {

	                   $id_upload = $resultSet -> fields ['id_upload'];

	                   $cadena 		=  "SELECT * FROM upload WHERE ( id = '$id_upload' )";
       			   $resultSetadj 	= $db->Execute ( $cadena );


       			   while (!$resultSetadj->EOF) {
			    	$datos ["nombre"] 	= $resultSetadj -> fields ['name'];
                            	$datos ["tipo"] 	= $resultSetadj -> fields ['type'];
                            	$datos ["size"] 	= $resultSetadj -> fields ['size'];


			    	$temp = $this -> sisifoConf -> getRutaTmp () . str_replace ( " ", "_" , $datos[ nombre ] );

                            	$cadena         = "select lo_export(content, '$temp') from upload where id = '$id_upload'";
				//echo $cadena; //exit();
                            	$resultSetData  =  $db->Execute ( $cadena );
                            	$datos ["bytes"] =  $resultSet -> fields ['lo_export'];
  
			    	array_push ( $this -> adjuntos, $datos );

				$resultSetadj->MoveNext();
			    }

			    $resultSet->MoveNext();
		}

		return $this -> adjuntos;



    } 
  
    function getNombre () {
		return $this -> nombre; 
    }

    function getTipo () {
                return $this -> tipo; 
    }   
    function getSize () {
                return $this -> size; 
    }   

   
 
}    
    
?>
