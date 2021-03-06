<?php

//require_once ("class.SisifoUsuario.php" );




	/**
	* Esta clase se encarga de implementar los procedimientos adecuados para
	* la autenticacion del usuario en el sistema. En principio dicha autenticacion
	* se realiza sobre un servidor de LDAP, pero se ha dado la posibilidad de hacerlo
	* contra una base de datos. Para lograr esa flexibilidad se ha usado el patron 
	* Strategy.
	* @package Autenticar
	* {@link http://www.phppatterns.com/index.php/article/articleview/6/1/1/}
	*/   
class SisifoAutenticador {

	
        /**#@+
	  * access private
	  * @var object 
	  */
	/**
	* El login del usuario.
	*/
	var $login;	
	
	/**
	* La contrasenna del usuario.
	*/
	var $password;
	
	var $sisifoConf;
	

	/**
	* Constructor.
	* Se encarga de inicializar los datos de entrada del usuario.
	* @param log el login del usuario.
	* @param passwd la contraseña del usuario.
	*/
	function SisifoAutenticador ( $log , $passwd ) {

		$this -> login = $log;
		$this -> password = $passwd;

        }

	/**
	* Metodo que realiza la validacion, bien contra LDAP o bien contra una BD.
	* Solo es el esqueleto, ya que la funcion en si se encuentra implementado en las
	* clases hijas.
	*/
	function valida () {
		return 0;
	}
	
	/**
	*  Metodo para iniciar los datos del usuario.
	*/	
	function iniciar ( $log , $passwd ) {

		$this -> login = $log;
		$this -> password = stripslashes ($passwd);
		$this -> sisifoConf = new Configuracion ( 
			$_SESSION ['fichero'] );		
	
	}
	
	/**
	* Metodo que devuelve el login del usuario, lo busca bien contra 
	* LDAP o bien contra una BD.
	* Solo es el esqueleto, ya que la funcion en si se encuentra implementado en las
	* clases hijas.
	*/
	function getLogin ( $id ) {
		return 0;
	}
	
	
	/**
	* Metodo que busca el login del usuario, lo busca bien contra 
	* LDAP o bien contra una BD. Devuelve su mail, o bien nulo sino se encuentra.
	* Solo es el esqueleto, ya que la funcion en si se encuentra implementado en las
	* clases hijas.
	*/	
	function buscar (  $login ) {
		return 0;
	}
	
}


	/**
	* Esta clase se encarga de implementar los procedimientos adecuados para
	* la autenticacion del usuario en el sistema. Esta clase solo autentica contra
	* un servidor de LDAP.
	*/   
class SisifoAutenticadorLdap extends SisifoAutenticador {


	/**
	* Constructor.
	* Se encarga de inicializar los datos de entrada del usuario.
	* @param log el login del usuario.
	* @param passwd la contraseña del usuario.
	*/
	function SisifoAutenticadorLdap ( $log , $passwd ) {
		
		parent::iniciar ( $log , $passwd  );
	
	}

	
	/**
	* Metodo que realiza la validacion contra LDAP 
	*/	
	function valida () {
		
			
	    	$ldap = $this -> sisifoConf  -> getConfLDAP();
			$admin = false; //Es administrador el usuario?
			$ds=ldap_connect($ldap -> getHost() );
        	$result = false;
			
		if ($ds) {		
			//Intentamos conectarnos con el login y la contrase� suministradas:
			$new_userbind = str_replace ( "--userlogin--", $this -> login, $ldap -> getUsrBind() );

			//Si lo conseguimos (el usuario est�correctamente autenticado):
			$strtmp = (string)$new_userbind;
			
			$result = @ldap_bind($ds, $strtmp, (string)$this -> password);
			
			if ($result && ($this -> login != "") && ($this -> password != "") ) {
			
				/*$strtmp = $ldap -> getAdmBind();
                                $strtmp2 = "memberuid=" . $this -> login;
			        echo  $strtmp . "/////" . $strtmp2;    
			        //Comprobamos si es administrador:
			        $sr = ldap_search($ds, strval ($strtmp),$strtmp2);
				echo "cadenas fijas";
				$sr = ldap_search ($ds,$strtmp,$strtmp2);
				echo "------------------------------------_____"; exit();	
					*/
				//Sacamos la informaci� del usuario:
				$sr = ldap_search($ds,$new_userbind, "uid=" . $this -> login );
				$info = ldap_get_entries($ds, $sr);			
				
				$_SESSION['uid'] = $info[0]["uidnumber"][0];
				$_SESSION['mail'] = $info[0]["mail"][0];
				$_SESSION['gecos'] = $info[0]["gecos"][0];
				
				
				$strtmp = $ldap -> getAdmBind();
				$strtmp2 = "memberuid=" . $this -> login;
				//Comprobamos si es administrador:
                                $sr=ldap_search($ds,strval($strtmp), $strtmp2);
				$info = ldap_get_entries($ds, $sr);
    				if ($info["count"] > 0) {
					 $admin = true;
				}
				$_SESSION['admin'] = $admin;
			}else {
				$result = false;
			}			
		}
		
		ldap_close($ds);
		return $result;
	}
	
	/**
	* Metodo que devuelve el login del usuario, lo busca contra LDAP.
	*/	
	function getLogin ( $id ) {   
	    
    
	    	$ldap = $this -> sisifoConf  -> getConfLDAP();   
		$ds=ldap_connect($ldap -> getHost() );
        	
		if ($ds) {
		
			//Intentamos conectarnos de forma anonima al servidor:			
            		$result = ( ldap_bind($ds) );			
			if ($result) {		

	            		$new_userbind = $ldap -> getSearchBind();			
				//Sacamos la informaci� del usuario:
				$sr = ldap_search( $ds,(string)$new_userbind,"uidnumber=" . $id );
				$info = ldap_get_entries($ds, $sr);			

				$mail = '';
				if (isset ($info[0]["uid"][0])){
					$mail = $info[0]["uid"][0];
				}
			}
		}else {
			$result = $ds;
		}
		ldap_close($ds);
		return $mail;
	
	}


	/**
	* Metodo que devuelve el id del usuario, lo busca contra LDAP.
	*/	

	function getId ( $login ) {   
	    
    
	    	$ldap = $this -> sisifoConf  -> getConfLDAP();   
		$ds=ldap_connect($ldap -> getHost() );
        	
		if ($ds) {
		
			//Intentamos conectarnos de forma anonima al servidor:			
            		$result = ( ldap_bind($ds) );			
			
			if ($result) {		

	            		$new_userbind = $ldap -> getSearchBind();			
				//Sacamos la informaci� del usuario:
				$sr = ldap_search( $ds,(string)$new_userbind,"uid=" . $login );
				$info = ldap_get_entries($ds, $sr);			
			
				$id = $info[0]["uidnumber"][0];			
			}
		}else {
			$result = $ds;
		}
		ldap_close($ds);
		return $id;
	
	}
	


	/**
	* Metodo que busca el login del usuario, contra 
	* LDAP . Devuelve su mail, o bien nulo sino se encuentra.
	*/		
	function buscar ( $login ) {

	       
    
	    	$ldap = $this -> sisifoConf  -> getConfLDAP();   
		$ds=ldap_connect($ldap -> getHost() );
        	
		if ($ds) {
		
			//Intentamos conectarnos de forma anonima al servidor:
            		$result = ( ldap_bind($ds) );			
			if ($result) {		

	            		$new_userbind = $ldap -> getSearchBind();			
				//Sacamos la informaci� del usuario:
				$sr = ldap_search( $ds,(string)$new_userbind,"uid=" . $login );
				$info = ldap_get_entries($ds, $sr);
				$mail = $info[0]["uid"][0];			
			}
		}
		ldap_close($ds);
		return $mail;	
	}
	
	

}


	/**
	* Esta clase se encarga de implementar los procedimientos adecuados para
	* la autenticacion del usuario en el sistema. Esta clase solo autentica contra
	* un servidor de BD.
	*/   
class SisifoAutenticadorBD extends SisifoAutenticador {

	function valida () {

		$enc = md5($_REQUEST[password]);
		$mysql = "SELECT * from blog_users where login='" . escape($_REQUEST[ulogin]);
	 	$mysql = $mysql."' AND password='$enc'";
        	$res = $db->Execute($mysql);
		$loginbd = trim ($res -> fields['login']);

        	return ( $login == $login ); 


	}

}

?>
