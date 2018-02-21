<?php

	require_once ( "class.Sisifopgp.php" );
	require_once ( "phpMailer/class.phpmailer.php" );

	
/**
* Esta clase se encarga de enviar mensajes de correo al usuario deseado.
* Opcionalmente permite la firma de dichos correos mediante PGP. 
* @package MandarCorreo
*/		
class Sisifocorreo {


	/**#@+
		* access private
		* @var string 
		*/
	/**
	* de quien viene el correo.
	*/
	var $from;
	
	/**
	* a quien va el correo.
	*/	
	var $to;


        /**
        * cc del correo.
        */
        var $cc;

	
	/**
	* asunto del correo.
	*/	
	var $subject;
	
	/**
	* el cuerpo del mensaje de correo.
	*/	
	var $texto;
	
	/**
	* ¿usaremos pgp?.
	*/
	var $usarpgp;
	/**#@-*/
	
	var $sisifoConf;


	/**
	* Constructor.
	* se encarga de inicializar los valores del correo que queremos mandar.
	* @param string from el from del correo.
	* @param string to el to del correo.
	* @param string subject el subject del correo.
	* @param string	texto el cuerpo del correo.
	*/
	function Sisifocorreo ( $from, $to, $cc, $subject, $cuerpo ) {
	
			$this -> sisifoConf  = new Configuracion ( 
				$_SESSION ['fichero'] );

			$this -> from 		= $from;
			$this -> to 		= $to;
			$this -> cc 		= $cc;
			$this -> subject 	= $subject;
			$this -> texto 		= $cuerpo;
			$this -> usarpgp 	= $this -> sisifoConf -> getUsarpgp();
			
        }


	/**
	*funcion para enviar el correo inicializado en el constructor.
	*/
	function enviar () {
		
       		//$this -> sisifoConf;	
	
		if ( $this -> usarpgp ) {
			$mypgp = $this -> sisifoConf -> getPGP();
			if ( $mypgp ) {
			  $message = $mypgp -> firmar ( $this -> texto );		
			  if ( $message == "" )
			    $message  = $this -> texto;
			} else {
			  $message = $this -> texto;
			}
		}else {
			$message = $this -> texto;
		}

		$sisifoInfo = $this -> sisifoConf  -> getSisifoConf ();

		$mail = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true;                // enable SMTP authentication
		$mail->SMTPSecure = "tls";              // sets the prefix to the servier
	 	$mail->Port = 25; 	
		$mail->Host = $sisifoInfo -> getSmtphost(); // SMTP server
		$mail->From = $this -> from;
		$mail->FromName = $this -> from;;
		$mail->AddAddress( $this -> to );
		if ( $this -> cc ) {
			$dirs = explode (",", $this -> cc );
			foreach ( $dirs as $d ) {
                		$mail->AddAddress( $d );
			}
		}
		$mail->Subject = $this -> subject ;
		$mail->Body = $message;
                $mail->Send();
        
	 	//mail ( $this -> to, $this -> subject , $mensaje,"From:" . $this -> from );
	}
	
	
}


