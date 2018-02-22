<?php 



//********************************************************
// Configuraci� web:
//********************************************************

#$weburl = "http://localhost/~breakthoven/incidencias/new/index"; //change this
#$baseurl = "http://localhost/~breakthoven/incidencias/new/";  //change this - omit the trailing slash
#$basepath = "/home/breakthoven/incidencias/new/";  //change this

#$weburl = "http://www.tsc.uc3m.es/~sblanco/incidencias/new/index"; //change this
#$baseurl = "http://www.tsc.uc3m.es/~sblanco/incidencias/new";  //change this - omit the trailing slash
#$basepath = "/export/garza2/sblanco/incidencias/new";  //change this
//$weburl = "https://www.tsc.uc3m.es/~sblanco/incidencias/new/index"; //change this
//$baseurl = "https://www.tsc.uc3m.es/~sblanco/incidencias/new";  //change this - omit the trailing slash
//$basepath = "/export/garza2/sblanco/incidencias/new";  //change this

/*$host = "localhost";
$dbase = "sisifo";
$user = "nobody";
$passwd = "";
$dbtype = "postgres";  //  set to 'postgres or mysql'
$title = "Sistema de gesti� de incidencias S�ifo";
*/




//********************************************************
// Autenticaci� contra ldap
//********************************************************

//***Nota en esta versi� s�o se contempla la autenticaci� mediante LDAP.

//Si la autenticaci� de los usuarios se realiza mediante un servidor de ldap hay que rellenar los siguientes datos:
//$ldaphost = "localhost"; //El host donde se consultar�el ldap.
//$userbind = "uid = --userlogin--, ou=People, dc=tsc, dc=uc3m,dc=es"; //La cadena de conexi� de los usuarios
//$adminbind = "cn=sysadmin, ou=Group,DC=tsc,DC=uc3m,DC=es"; 
//la cadena de conexi� para saber si es administrador

//********************************************************

//********************************************************
// Queremos firmar los correos con PGP?
//********************************************************
/*$usarpgp = true;
//Rellenar estos campos s�o si queremos usar PGP, sino ignorar.
$usernamepgp = "www";
$pgppath="/usr/bin/gpg2";
$userpgp="www";
//No se olvide poner la / al final del todo!!!!
$userpgppath = "/home/www/";
//Los firmados / cifrados de pgp pueden llevar un comentario adiccional:
$commentpgp = "Firmado por sistema de gesti� de incidencias Sisifo";
*/
//***************************


//Nmero de incidencias a mostrar en pantalla para el usuario:
//$limit = 5;

//Nmero de incidencias a mostrar en pantalla para el administrador:
//$limit_admin = 10;

//Permanencia en cach�
//$timeout = 1; //cache timeout, in minutes

//Formato de la fecha
//$dateformat = "m/d/Y h:i:s a";


// setting these to 1 may cause long load times when users save entries
//$enable_smilies = 1; //use smilies

//$safe_comments = 1; //strip out unsafe HTML in user comments(recommended)

//$comment_win = 1; //pop comments up in a new window

?>
