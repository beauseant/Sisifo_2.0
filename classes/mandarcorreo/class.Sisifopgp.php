<?php
/**
* Esta clase se encarga de firmar y cifrar mensajes mediante PGP. 
* @package MandarCorreo
*/
	
class Sisifopgp {


	
	/**#@+
		* access private
		* @var string 
		*/
	/**
	* el usuario que tiene la clave publica utilizada
	*/
	var $username;
	
	/**
	* La ruta en la que se encuentra el PGP.
	*/	
	var $pgppath;
	
	/**
	* El nombre del usuario de la clave publica
	*/	
	var $user;
	
	/**
	* La ruta al home de dicho usuario.
	*/	
	var $userhome;
	
	/**
	* El comentario que se pondra al final de cada firma / cifrado.
	*/	
	var $comment;
	/**#@-*/
	
	
	/**
	*Constructor.
	* Recibe los datos de configuracion -ruta, usuario...- y los inicializa.
	* @param string username el usuario que tiene la clave publica utilizada
	* @param string pgppath La ruta en la que se encuentra el PGP.
	* @param string user El nombre del usuario de la clave publica
	* @param string userhome La ruta al home de dicho usuario.
	* @param string comment El comentario que se pondra al final de cada firma / cifrado
	*/
	function SisifoPGP ( $username, $pgppath, $user, $userhome, $comment ) {

		$this -> username = $username;
		$this -> pgppath = $pgppath;
		$this -> user = $user;
		$this -> userhome = $userhome;
		$this -> comment = $comment;
        }


	/**
	* Cifra el mensaje pasado como parametro.
	* @todo esta funcion no se utiliza en esta aplicacion.
	* @param string datos Datos a cifrar
	*/
	function cifrar ( $datos ) {
	}
	
	
	/**
	* Firma los datos pasados como parametros. 
	* @param bool enhtml Nos indica si la salida debe ser, o no, en html.
	*/
	function firmar ( $datos, $enhtml = false ) {
	

		$oldhome = getEnv("HOME");

		$ruta = $this -> userhome . $this -> username;
		putenv("HOME=". $ruta );
		
		$com = "'" . $this -> comment ."'";

		$command = 'echo "'.$datos.'" | '.$this -> pgppath.
			' --comment ' . $com . ' --batch   --clearsign --no-use-agent -a --always-trust --no-secmem-warning -u "'.
			$this -> user.'"';

		$result = exec ($command, $resultado, $errorcode);

		putenv("HOME=". $oldhome );

		if ( $enhtml ) {		
			$message = implode("<br>", $resultado ); //Para html
		}else{
			$message = implode("\n", $resultado );
		}
	
		return $message;
	}
	
	function getClavePublica ( $enhtml = false ) {
		$oldhome = getEnv("HOME");

		$ruta = $this -> userhome . $this -> username;
		putenv("HOME=". $ruta );
		$command = $this -> pgppath . " -a -u " .  $this -> user . " --export";
		$result = exec ($command, $resultado, $errorcode);
		putenv("HOME=". $oldhome );

		if ( $enhtml ) {		
			$message = implode("<br>", $resultado ); //Para html
		}else{
			$message = implode("\n", $resultado );
		}
		
		return $message;
	
	}
	
}
?>
