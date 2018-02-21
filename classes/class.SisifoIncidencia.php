<?php 


//include_once("../lib.php");
    require_once ("mandarcorreo/class.Sisifocorreo.php");
    require_once("anotaciones/class.SisifoArchivoAnotacion.php");
    require_once("class.SisifoUpload.php");

	/**
	* Clase para buscar informacion de una incidencia. Tambien se usa para dar de 
	* baja una incidencia.
	* Esta clase es la clase padre, generica, de las incidencias, por lo que contiene los
	* datos generales de una incidencia, descripcion, fecha, usuario... Que seran heredados
	* por las incidencias concretas, hardware, software... Que añadiran sus datos propios. 
	* @package SisifoIncidencia
	*/      
class SisifoIncidencia {
    
    
   /**#@+
   * access private
   * @var object 
   */
   /**
   * El identificador de la incidencia.
   */           
    var $inciId;
    
   /**
   * La fecha de llegada al sistema.
   */           
    var $inciDateLlegada;
    
   /**
   * La ultima fecha en la que se hizo algo con la inci.
   */           
    var $inciDateRes;

   /**
   * El identificador de la incidencia.
   */
    var $cc;



    
   /**
   * El identificador de la incidencia.
   */           
    var $inciTipo;

   /**
   * Si la incidencia tiene ficheros adjuntos
   */
   var $adjunto;
   /**
   * La descripcion breve de la incidencia.
   */               
    var $inciDescBreve;
    
   /**
   * El identificador largo de la incidencia.
   */               
    var $inciDescLarga;
    
   /**
   * La URL usada para leer los mensajes.
   */               
    var $inciUrlMensaje;

   /**
   * La URL usada para adjuntar archivos a la inci
   */
   var $inciAdj;   
 
   /**
   * La URL para las anotaciones de los mensajes.
   */               
    var $inciUrlAnotacion;
    
   /**
   * La URL de la incidencia.
   */               
    var $inciUrl;
    
   /**
   * El identificador del usuario de la incidencia.
   */               
    var $usrId;  
    
   /**
   * El estado en el que se encuentra la incidencia.
   */               
    var $inciEstado;
    
   /**
   * El numero de mensajes de la incidencia.
   */               
    var $numMensajes;
    
   /**
   * El numero de anotaciones de la incidencia.
   */               
    var $numAnotaciones;
   /**#@-*/     
    
   var $sisifoConf;

   
   	/**
	* Constructor.
	* Se busca la incidencia solicitada en la base de datos.
	* @param id_inci el identificador de la nueva incidencia.
	*/      
    function SisifoIncidencia ( $id_inci ) {
    

         	$this -> sisifoConf = new Configuracion ( 
			$_SESSION ['fichero'] );
		//Sacamos la tabla en la que se encuentra la incidencia. Si es de tipo hardware
		//estar�en la tabla inci_hard, por ejemplo.
		$db = $this -> sisifoConf -> getBd();
		$sql = "SELECT * FROM incidencia WHERE id='" . $id_inci ."'";	
		$rs = $db -> Execute ( $sql );
		
		$this->addDatos ( $rs );
				
		$id_usuario = $rs -> fields ['id_usuario'];	


    }

    
    	/**
	* Se busca la incidencia solicitada en la base de datos.
	* @param id el identificador de la nueva incidencia.
	*/         
    function inicializar ( $id_inci ) {

		$db = $this -> sisifoConf -> getBd();
	
		//Sacamos la tabla en la que se encuentra la incidencia. Si es de tipo hardware
		//estar�en la tabla inci_hard, por ejemplo.
		$sql = "SELECT * FROM incidencia WHERE id='" . $id_inci ."'";	
		$rs = $db -> Execute ( $sql );
		
		$this->addDatos ( $rs );
				
		$id_usuario = $rs -> fields ['id_usuario'];
		
		
		$sql = "SELECT id, tabla FROM tipo_incidencia WHERE id=' " . $rs -> fields ['tipo'] ."'";		
		$rs = $db -> Execute ( $sql );
		
		$tabla = $rs -> fields ['tabla'];    

                $this -> adjunto = new SisifoUpload ();

    }

    
	/**
	* Se añaden los datos buscados en la BD, y se asignan a las variables del objeto
	* @param resulSet El registro de la BD con los datos.
	*/            
    function addDatos ( $resultSet ) {   
    
        global $baseurl;

	$db = $this -> sisifoConf -> getBd();
		
    		
		$this -> inciId = $resultSet -> fields ['id'];
		
		$this -> inciDateLlegada 	= $resultSet -> fields ['fecha_llegada'];
		$this -> inciDateRes 		= $resultSet -> fields ['fecha_resolucion'];	
		$this -> inciDescBreve 		= $resultSet -> fields ['desc_breve'];
		$this -> inciDescLarga 		= $resultSet -> fields ['desc_larga'];
		$this -> usrId 			= $resultSet -> fields ['id_usuario'];
		$this -> cc 			= $resultSet -> fields ['cc'];
	

		//El tipo se muestra como nombre (hardware, teclado.. No con nmero).
		$id_tipo =  $resultSet -> fields ['tipo'];
		
		$sql = "SELECT * FROM tipo_incidencia WHERE id = $id_tipo";
		
		$rs = $db->Execute($sql);
		$this -> inciTipo = $rs-> fields ['descripcion'];	
	
		$this -> inciUrlMensaje = "$baseurl/mensaje.php?pid=$this->inciId";
		$this -> inciUrl = "$baseurl/detalles.php?pid=". $this->inciId ."&tipo_incidencia=" . $this -> inciTipo;
		$this -> inciAdj = "$baseurl/adjuntar.php?pid=". $this->inciId . "&tipo_incidencia=" . $this -> inciTipo;		
			
		$sql = "SELECT * FROM estado_inci WHERE id_estado_in=" . $resultSet -> fields ['id_estado'];
		$rs = $db -> Execute ( $sql );  
		$this -> inciEstado = $rs -> fields ['descripcion'];
		
		$sql = "SELECT COUNT(*) as \"numMensajes\" FROM mensaje WHERE id_incidencia='". $this ->inciId . "'";
		$rs = $db -> Execute ( $sql );  
		$this -> numMensajes = $rs -> fields ['numMensajes'];

		$sql = "SELECT COUNT(*) as \"numAnotaciones\" FROM anotacion WHERE id_incidencia='". $this ->inciId . "'";
		$rs = $db -> Execute ( $sql );  
		$this -> numAnotaciones = $rs -> fields ['numAnotaciones'];
    
    }
    

    
    /*function insertar ( $desc_breve, $desc_larga, $tipo_soft, $cc ) {
    	echo $uid = getUID($_SESSION['login']);
    }*/

	/**
	* Se inserta en la BD una incidencia generica, no los datos concretos de cada incidencia.
	* Ademas se envia un correo al usuario y al administrador comunicando la insercion.
	* @param desc_breve la descripcion breve de la incidencia.
	* @param desc_larga la descripcion larga de la incidencia.
	* @param tipo el tipo de incidencia a insertar.
	*/     
    function insertar ( $desc_breve, $desc_larga, $tipo, $cc ) {

	$db = $this -> sisifoConf -> getBd();
     
		$conf = $this -> sisifoConf -> getSisifoConf();		
		$template = $conf -> getTemplateMail();
	
		$id = getUID ($_SESSION['login']);
		
		$sql = "INSERT INTO incidencia (fecha_llegada, fecha_resolucion,tipo, id_usuario, desc_breve,
		 desc_larga, cc ) VALUES (";
		$sql .=  "'now()','now()',$tipo,$id,'$desc_breve','$desc_larga', '$cc')";
		$res = $db->Execute($sql);
			
		$sql = "SELECT last_value FROM incidencia_id_seq";
		$res = $db->Execute ($sql);
		$last_id = $res -> fields ['last_value'];
		
		//Mandamos un correo avisando de la incidencia:
		
		$inci_mail = $this -> sisifoConf -> getIncimail();
		
		//Se le envia al usuario:
		$texto = aplicar_temp_mail (stripslashes( $template ),
			$desc_larga, $last_id );

		$subject = "Incidencia " . $last_id . " enviada (" . $desc_breve . ")";
		$mymail = new Sisifocorreo ( "noreply@tsc.uc3m.es", $_SESSION['mail'], "", $subject, $texto ); 
		$mymail -> enviar();

		//Ponemos en copia al cc si existe:
		if ( $cc ) {
			$texto = "\n ( incidencia enviada por " . $_SESSION['mail'] . " con copia a usted ) \n \n" . $texto . "\n";
	                $mymail = new Sisifocorreo ( "noreply@tsc.uc3m.es", $cc, "", $subject, $texto );
                	$mymail -> enviar();
		}

		
		//Y al administrador:
		$texto = aplicar_temp_mail (stripslashes( $template ),
		$desc_larga, $last_id );
		$subject = "Incidencia " . $last_id . " enviada (" . $desc_breve . ")";
		$mymail = new Sisifocorreo ($_SESSION['mail'] , $inci_mail, "", $subject, $texto ); 
		
		$mymail -> enviar();	

		
		
		return $last_id;

		       
    }



     function setEstado ( $estadoinci, $usr ) {

	$db = $this -> sisifoConf -> getBd();


	$sql = "SELECT * FROM estado_inci WHERE id_estado_in=" . $estadoinci;
        $rs = $db -> Execute ( $sql );
        $estadoincitexto = $rs -> fields ['descripcion'];
	if ($estadoincitexto != $this -> inciEstado ) { 
 	       $insertar = true;
		$texto = "El nuevo estado de la incidencia es: <b>".$estadoincitexto."<b>";
       		 $anotacion = new SisifoAnotacion ( $this -> inciId, $usr, "", $texto, $insertar );

		$sql = "UPDATE incidencia SET id_estado ='" . $estadoinci . 
			"', fecha_resolucion='now()' WHERE id='" . $this -> inciId ."'";
		$res = $db->Execute($sql);
		$this -> inicializar ( $this -> inciId );
	}
     }

    /**
    * devuelve el Id de la incidencia
    */
    function getId () {
    	
    	return $this -> inciId;
    
    }

    function getCC () {
	return $this -> cc;
    } 

   
    /**
    * devuelve la descripcion breve de la incidencia
    */     
    function getDescBreve () {
    
    	return $this -> inciDescBreve;
    
    }

    /**
    * devuelve el id del usuario
    */        
    function getIdUsuario () {    
    	return $this -> usrId;    
    }

    /**
    * devuelve el estado de la incidencia
    */    
    function getEstado () {    
    	return $this -> inciEstado;    
    }

    /**
    * devuelve el tipo de la incidencia
    */        
    function getTipo () {
    	return $this -> inciTipo;
    }
    
    /**
    * devuelve la fecha de llegada de la incidencia
    */       
    function getFechaLlegada () {
        $res_date=new DateTime( $this -> inciDateLlegada,new DateTimeZone('GMT'));
        $res_date->setTimeZone(new DateTimeZone('Europe/Madrid'));
        return $res_date->format ('Y-m-d H:i:s');

    }
    
    /**
    * devuelve la descripcion larga de la incidencia
    */        
    function getDescLarga () {
    	return $this -> inciDescLarga;
    }
    
    /**
    * devuelve la fecha del ultimo acceso a la incidencia.
    */        
     function getFechaRes () {
	$res_date=new DateTime( $this -> inciDateRes,new DateTimeZone('GMT'));
        $res_date->setTimeZone(new DateTimeZone('Europe/Madrid'));
    	return $res_date->format ('Y-m-d H:i:s');
    }
    
    /**
    * devuelve la url para leer los mensajes.
    */        
    function getURLMens () {
    	return $this -> inciUrlMensaje;
    }

    /**
    * devuelve la url para adjuntar archivos.
    */
    function getURLAdj () {
        return $this -> inciAdj;
    }




    /**
    * devuelve el numero de mensajes de la incidencia
    */            
    function  getNumMens () {    
    	return $this -> numMensajes;
    }

    /**
    * devuelve el numero de anotaciones de la incidencia.
    */            
    function getNumAnot () {
    	return $this -> numAnotaciones;
    }
    
    /**
    * devuelve la URL para poder ver la incidencia.
    */        
    function getURL () {
    	return $this -> inciUrl;
    }
 
    /**
    * devuelve una cadena que puede ser presentada en pantalla con los datos de la incidencia.
    */         
    function toStr () {
        $alta_date=new DateTime( $this -> inciDateLlegada,new DateTimeZone('GMT'));
        $alta_date->setTimeZone(new DateTimeZone('Europe/Madrid'));

        $up_date=new DateTime( $this -> inciDateRes,new DateTimeZone('GMT'));
        $up_date->setTimeZone(new DateTimeZone('Europe/Madrid'));


	
	$resultado ='
		<TR> <TD class ="celdagrisclara"> CC:</TD><TD>' . $this -> cc . '</TD></TR>
		<TR> <TD class ="celdagrisclara"> Fecha de llegada:</TD><TD>' . $alta_date->format('Y-m-d H:i:s') . '</TD></TR>
		<TR><TD class ="celdagrisclara"> Ultima actualizaci&oacute;n:</TD><TD>' . $up_date->format('Y-m-d H:i:s') . '</TD></TR>
		<TR><TD class ="celdagrisclara"> Descripci&oacute;n breve:</TD><TD>' . nl2br ($this -> inciDescBreve) . '</TD></TR>		
		<TR><TD class ="celdagrisclara"> Descripci&oacute;n:</TD><TD>' . nl2br ($this -> inciDescLarga) . '</TD></TR>
	';
	$adjuntos = $this -> adjunto -> sacarAdjunto ( $this -> inciId );

	
	$resultado = $resultado . "<TR> <TD class =\"celdagrisclara\"> Fichero(s) adjunto(s):</TD>";

	foreach ( $adjuntos as $datos ) {

                $nombre  =  $datos["nombre"];
                $size    =  $datos["size"];
                $tipo    =  $datos["tipo"];


		//$ruta = $this -> sisifoConf -> getRutaTmp () . str_replace ( " ", "_" , $nombre );

                $ruta    =   "/incidencias/adjuntos/" . str_replace (" ", "_", $nombre);

                $resultado = $resultado . 
                        "<TR><TD></TD><TD><a target=\"_blank\" href=\"" . $ruta . "\">$nombre ( $size y tipo $tipo)</a><TD>";
	}		


        /*if ( $this -> adjunto -> sacarAdjunto ( $this -> inciId ) ) {
                $nombre  =  $this -> adjunto -> getNombre ();
                $size    =  $this -> adjunto -> getSize ();
                $tipo    =  $this -> adjunto -> getTipo ();

                $ruta    =   "../tmp/" . str_replace (" ", "_", $nombre);

                $resultado = $resultado . "<TR> <TD class =\"celdagrisclara\"> Fichero adjunto:</TD><TD>$nombre de $size y tipo $tipo</TD></TR>" .
                        "<TR><TD></TD><TD><a target=\"_blank\" href=\"" . $ruta . "\">descargar adjunto</a><TD>";

        } else {
                $resultado = $resultado . "<TR> <TD class =\"celdagrisclara\"> Fichero adjunto:</TD><TD> No hay ficheros adjuntos</TD></TR>";
        }
	*/
	return $resultado;
    }    
        
    

}

?>
