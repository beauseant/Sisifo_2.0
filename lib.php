<?PHP
##
##
## lib.php
##
	require_once ("classes/mandarcorreo/class.Sisifopgp.php");
	require_once ("classes/autenticar/class.SisifoAutenticador.php");
	require_once ("classes/singleton/class.Configuracion.php");
	require_once("adodb/adodb-errorhandler.inc.php");
	require_once("adodb/adodb.inc.php");

	

$res = array();

#if you are using php 4.0.6 and earlier, uncomment this next line
#pre41vars();



function cleanQuery($string)
{
  if(get_magic_quotes_gpc())  // prevents duplicate backslashes
  {
    echo "strip";
    $string = stripslashes($string);
  }
  $badWords = array("/delete/i", "/update/i","/union/i","/insert/i","/drop/i","/http/i","/--/i");
  $string = preg_replace($badWords, "", $string);
  $string = mysql_escape_string($string);
  return $string;
}

  
function file_size($size)
      {
      		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      		return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
      }


function gethost($ip)
{
   /*$host = `host $ip`;
   $host=end(explode(' ',$host));
   $host=substr($host,0,strlen($host)-1);
   $chk=split("\(",$host);
   if($chk[1]) return $ip." (".$chk[1].")";
   else return $host;*/
   return $ip;
}


function esAdmin() {

	return $_SESSION['admin'];

}


#
# auth - authenticates the user based on the session
#
function auth() {

	//global $_SESSION, $_SERVER;

	if(!session_is_registered("login")) { #if login is ! in the session		
		header("Location: index.php?login\n\n");
	} elseif(!session_is_registered("ip")) { # if the ip is ! in the session
		header("Location: index.php?ip\n\n");
	} elseif($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) { # if the ip in session is != to the ip of the client
		header("Location: index.php?hijack\n\n");
		error_log($_SERVER['REMOTE_ADDR']." - attempted session hijack\n",3,"security.log"); #log attempt
	}

} 

#
# isLoggedIn - sees if user is logged in based on the session
#
function isLoggedIn() {

    //global $_SESSION, $_SERVER;
    
	if (empty($_SESSION ['login'])) {
		return 0;
	}

    if($_SESSION ['login'] and ($_SESSION['myip'] == $_SERVER['REMOTE_ADDR'])) { 
    //if($_SESSION ['login'] ) { 
		return 1;	
    } else {
		return 0;
    }

}


#
# getUID - gets id of user
#

function getUID($login) {

	//global $db;
	
	$login = trim ($login);
	//$res = $db->Execute("SELECT id FROM usuario WHERE login='$login'");
	//return $res->fields['id'];
	return $_SESSION['uid'];

}





#
# use_new_vars - for <= php4.0.6 to set all PHP variables to use $_ style in php > 4.1.x
#

function pre41vars() {

	global $_REQUEST, $HTTP_GET_VARS, $_SESSION, $HTTP_COOKIE_VARS, $HTTP_ENV_VARS, $HTTP_SERVER_VARS, $HTTP_POST_FILES, $_REQUEST, $_SESSION, $_SERVER, $_ENV, $_COOKIE, $_POST, $_GET, $_FILES;

	$_COOKIE = $HTTP_COOKIE_VARS;
	$_SESSION = $HTTP_SESSION_VARS;
	$_ENV = $HTTP_ENV_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_FILES = $HTTP_POST_FILES;
	

	if($HTTP_SERVER_VARS['REQUEST_METHOD'] == "GET") {
		$_REQUEST = $HTTP_GET_VARS;
	} else {
		$_REQUEST = $HTTP_POST_VARS;
	}

}


#
# format_date - UNIX timestamp to a readable format.
#
function format_date($datetime) {
	//$date = strftime("%m/%d/%y %I:%M %p", strtotime($datetime));
	//$date = strftime("%Y-%-%d %I:%M %p", strtotime($datetime));
	//return $date;
	return $datetime;
}

#
# short_date - converts unix timestamp to just a date
#
function short_date($datetime) {
 
     $date = strftime("%m/%d/%y", strtotime($datetime));
																 
     return $date;
}

#
# short_date - converts unix timestamp to just a date
#
function short_time($datetime) {
	 
     $time = strftime("%I:%M %p", strtotime($datetime));

     return $time;
}


#
# marker_sub - does substitution for markers, links, emails in templates
#
//function aplicar_temp ($line,&$incidencia,&$sisifoInfo) {
function aplicar_temp ($line,&$incidencia,&$sisifoInfo) {


	$incidencia->inciDescLarga = ereg_replace("\n","<br>",$incidencia->inciDescLarga);
	$line = ereg_replace ( "--id--", $incidencia->inciId ,$line );
	$line = ereg_replace ( "--descbreve--",$incidencia->getDescBreve(),$line );	
	$line = ereg_replace ( "--dateini--",$incidencia->getFechaLlegada(),$line );
	$line = ereg_replace ( "--dateact--",$incidencia->getFechaRes(),$line );
	$line = ereg_replace ( "--tipo--",$incidencia->getTipo(),$line );
	$line = ereg_replace ( "--desclarga--",$incidencia->getDescLarga(),$line );
	$line = ereg_replace ( "--mensajes--",$incidencia->getURLMens(),$line );
	$line = ereg_replace ( "--numMens--",$incidencia->getNumMens(),$line );
	$line = ereg_replace ( "--detalles--",$incidencia->getURL(),$line );	
        $line = ereg_replace ( "--adjuntar--",$incidencia->getURLAdj(),$line );
	$line = ereg_replace ( "--estado--",$incidencia-> getEstado(),$line );	
	//$line = ereg_replace ( "--dateini--",date("Y-m-d H:i",time //($incidencia->getFechaLlegada())),$line );

    	return $line;
}

function aplicar_temp_mail ($line,$desc_larga,$id_incidencia) {


	$line = ereg_replace ( "--idinci--", $id_incidencia,$line );
	$line = ereg_replace ( "--desclarga--",$desc_larga,$line );
    	return $line;
}



#
# do_smilies - substitute smiley for image
#

function do_smilies($body) {

	$body = ereg_replace(">:\(","<img src=\"images/smile/icon_evil.gif\">",$body);
        $body = ereg_replace(">:\)","<img src=\"images/smile/icon_evil.gif\">",$body);
	$body = ereg_replace(":D","<img src=\"images/smile/icon_biggrin.gif\">",$body);
	$body = ereg_replace(":-D","<img src=\"images/smile/icon_biggrin.gif\">",$body);
	$body = ereg_replace(":\)","<img src=\"images/smile/icon_smile.gif\">",$body);
	$body = ereg_replace(":-\)","<img src=\"images/smile/icon_smile.gif\">",$body);
	$body = ereg_replace(":\(","<img src=\"images/smile/icon_sad.gif\">",$body);
        $body = ereg_replace(":-\(","<img src=\"images/smile/icon_sad.gif\">",$body);
	$body = ereg_replace(":o","<img src=\"images/smile/icon_surprised.gif\">",$body);
        $body = ereg_replace(":-o","<img src=\"images/smile/icon_surprised.gif\">",$body);
        $body = ereg_replace(":\?","<img src=\"images/smile/icon_confused.gif\">",$body);
        $body = ereg_replace(":-\?","<img src=\"images/smile/icon_confused.gif\">",$body);
	$body = ereg_replace("8\)","<img src=\"images/smile/icon_cool.gif\">",$body);
        $body = ereg_replace("8-\)","<img src=\"images/smile/icon_cool.gif\">",$body);
        $body = ereg_replace(":x","<img src=\"images/smile/icon_mad.gif\">",$body);
        $body = ereg_replace(":-x","<img src=\"images/smile/icon_mad.gif\">",$body);
	$body = ereg_replace(":P","<img src=\"images/smile/icon_razz.gif\">",$body);
        $body = ereg_replace(":-P","<img src=\"images/smile/icon_razz.gif\">",$body);
        $body = ereg_replace(";\)","<img src=\"images/smile/icon_wink.gif\">",$body);
        $body = ereg_replace(";-\)","<img src=\"images/smile/icon_wink.gif\">",$body);
	$body = ereg_replace(":\|","<img src=\"images/smile/icon_neutral.gif\">",$body);
        $body = ereg_replace(":-\|","<img src=\"images/smile/icon_neutral.gif\">",$body);
        $body = ereg_replace(":'\(","<img src=\"images/smile/icon_cry.gif\">",$body);

	return $body;

}


#
# mk_drawCalendar - builds calander for archive script
#
function mk_drawCalendar($m, $y, $userid, $search=1)
{
    $sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	 
    if ((!$m) || (!$y))
    {
         $m = date("n",mktime());
         $y = date("Y",mktime());
    }
								  
   /*== get what weekday the first is on ==*/
   $tmpd = getdate(mktime(0,0,0,$m,1,$y));
   $month = $tmpd["month"];
   $firstwday= $tmpd["wday"];
   $today = date("Ymd",mktime());
								   
   $lastday = mk_getLastDayofMonth($m,$y);


?>
<table><tr>
<td style="padding-left:12px;padding-right:12px;padding-top:4px;padding-bottom:4px;border:1px solid #999999;background-color:#eeeeee;">
		<table cellspacing="0" cellpadding="2" border="0">
					<tr>
						<td colspan="7" align="center"><b><?php echo "$month $y"?></b>
						</td>
					</tr>
					<tr>

						<td width="19" align="center" class="calday">Dom</td>
						<td width="19" align="center" class="calday">Lun</td>
						<td width="19" align="center" class="calday">Mar</td>
						<td width="19" align="center" class="calday">Mie</td>
						<td width="19" align="center" class="calday">Jue</td>
						<td width="19" align="center" class="calday">Vie</td>
						<td width="19" align="center" class="calday">Sab</td>
					</tr>
<?php  $d = 1;
    $wday = $firstwday;
    $firstweek = true;

	 /*== loop through all the days of the month ==*/
	 while ( $d <= $lastday)
	 {
				 
	    /*== set up blank days for first week ==*/
	    if ($firstweek) {
	    	print "<tr>";
	    	for ($i=1; $i<=$firstwday; $i++)
	    	{ print "<td>&nbsp;</td>"; }
	    	$firstweek = false;
	    }
																						  
       /*== Sunday start week with <tr> ==*/
       if ($wday==0) { print "<tr>"; }
															   
															    
       $mo = $m;
       if($mo <10) {
           if(!preg_match("/0\d/",$mo)) {
                $mo = "0".$mo;
           }
       }
																																								 
       $da = $d;
       if($da <10) {
            if(!preg_match("/0\d/",$da)) {
                 $da = "0".$da;
            }
       }
																																																						  
 		/*== Look for blog entries for this day ==*/
	
	   $db = $sisifoConf -> getBd();
	   $sql = "select count(*) as count from incidencia where id_usuario = $userid AND date_trunc('day',fecha_llegada) = '$y-$mo-$da%'";
	   $res = $db->Execute($sql);

	  /*== check for event ==*/
      $showdate = $y.$mo.$da;

	  print "<td align=center class=calday";
      if($showdate == $today) {
	       print " bgcolor=gainsboro";	       
	  } 
	  print ">";
	  /*== if entries are found, output link to that days entries ==*/
	  
	  if($res->fields['count'] > 0) {
	       print "<a href=\"archivo.php?m=$mo&d=$da&y=$y\">$d</a>";
	  } else {
	       print $d;
	  }
	  print "</td>\n";

	  /*== Saturday end week with </tr> ==*/
      if ($wday==6) { print "</tr>\n"; }
	   
      $wday++;
      $wday = $wday % 7;
      $d++;
	}

	if($wday != 0) {
		for($i=$wday; $i <7; $i++) {
			echo "<td></td>\n";
		}
		echo "</tr>\n";
	}

	#determine next and previous month
	if(($m-1)<1) { $pm = 12; } else { $pm = $m-1; }
	if(($m+1)>12) { $nm = 1; } else { $nm = $m+1; }

	if(strlen($pm) == 1) { $pm = "0".$pm; };
	if(strlen($nm) == 1) { $nm = "0".$nm; };
?>
<tr><td colspan=3 align=right>
<b><a href="archivo.php?m=<?php echo '$pm&y='.((($m-1)<1) ? $y-1 : $y ).'">'.getPrevMo($mo);?></a></b>
</td><td><br></td>
<td colspan=3 align=left><b><a href="archivo.php?m=<?php echo $nm.'&y='.((($m+1)>12) ? $y+1 : $y).'">'.getNextMo($mo);?></b></a></td></tr>
</table>


</div>
</td></tr></table><br>

<?php 
/*== end drawCalendar function ==*/
}
   
function getPrevMo($mo) {

	$mo--;

	if($mo == 0) {
		$mo = 12;
	}

	switch($mo) {
		case 1:
			return "Ene";
			break;
		case 2:
			return "Feb";
			break;
		case 3: 
			return "Mar";
			break;
		case 4:
			return "Abr";
			break;
		case 5:
			return "May";
			break;
		case 6:
			return "Jun";
			break;
		case 7:
			return "Jul";
			break;
		case 8:
			return "Ago";
			break;
		case 9:
			return "Sep";
			break;
		case 10:
			return "Oct";
			break;
		case 11:
			return "Nov";
			break;
		case 12:
			return "Dic";
			break;
		default:
			return "???";
			break;
	}
}
   

function getNextMo($mo) {

	$mo++;

    if($mo == 13) {
        $mo = 1;
    }

    switch($mo) {
        case 1:
            return "Ene";
            break;
        case 2:
            return "Feb";
            break;
        case 3:
            return "Mar";
            break;
        case 4:
            return "Abr";
            break;
        case 5:
            return "May";
            break;
        case 6:
            return "Jun";
            break;
        case 7:
            return "Jul";
            break;
        case 8:
            return "Ago";
            break;
        case 9:
            return "Sep";
            break;
        case 10:
            return "Oct";
            break;
        case 11:
            return "Nov";
            break;
        case 12:
            return "Dic";
            break;
        default:
			break;
	}
}

function getThisMo($mo) {

    switch($mo) {
        case 1:
            return "Enero";
            break;
        case 2:
            return "Febrero";
            break;
        case 3:
            return "Marzo";
            break;
        case 4:
            return "Abril";
            break;
        case 5:
            return "Mayo";
            break;
        case 6:
            return "Junio";
            break;
        case 7:
            return "Julio";
            break;
        case 8:
            return "Agosto";
            break;
        case 9:
            return "Septiembre";
            break;
        case 10:
            return "Octubre";
            break;
        case 11:
            return "Noviembre";
            break;
        case 12:
            return "Diciembre";
            break;
        default:
            break;
    }
}

/*== get the last day of the month ==*/
function mk_getLastDayofMonth($mon,$year)
{
    for ($tday=28; $tday <= 31; $tday++)
    {
        $tdate = getdate(mktime(0,0,0,$mon,$tday,$year));
        if ($tdate["mon"] != $mon)
	        { break; }
							 
    }
    $tday--;
								  
    return $tday;
}

/*== Clean up user input ==*/
function safeHTML($html, $tags = "b|br|i|u|ul|ol|li|p|a|blockquote|em|strong") {
// removes all tags that are considered unsafe
// Adapted from a function posted in the comments about the strip_tags()
// function on the php.net web site.
//
// This function is not perfect! It can be bypassed!
// Remove any nulls from the input
	$html = preg_replace('/\0/', '', $html);
 
	// convert the ampersands to null characters (to save for later)
	$html = preg_replace('/&/', '\0', $html);
  
	// convert the sharp brackets to their html code and escape special characters such as "
	$html=htmlspecialchars($html);
   
    // restore the tags that are considered safe
    if ($tags) {
    	// Fix start tags
        $html = preg_replace("/&lt;(($tags).*?)&gt;/i", '<$1>', $html);
        // Fix end tags
        $html = preg_replace("/&lt;\/($tags)&gt;/i", '</$1>', $html);
        // Fix quotes
        $html = preg_replace("/&quot;/", '"', $html);
        $html = addslashes($html);
        // Don't allow, e.g. <a href="javascript:evil_code">
        $html = preg_replace("/<($tags)([^>]*)>/ie", "'<$1' . stripslashes(str_replace('javascript','hackerscript','$2')) .'>'", $html);
        // Don't allow, e.g. <img src="foo.gif" onmouseover="evil_javascript">
        $html = preg_replace("/<($tags)([^>]*)>/ie", "'<$1' . stripslashes(str_replace(' on',' off','$2')) .'>'", $html);
        $html = stripslashes($html);
																		    
	}
																									 
	// restore the ampersands
	$html = preg_replace('/\0/', '&', $html);
		  
	return($html);
} // safeHTML


function now() {
    $date = date("Y-m-d H:i:s",time());
    return $date;
}

// I don't like how the PHP count() function returns 1 if
// you pass it a scalar. So this is my custom function that
// will return 0 if the argument isn't an array.
function array_count($arr) {
    if (!is_array($arr)) {
        return 0;
    }

    return count($arr);
}



function lista_estados_inci () {

	require_once("classes/iterator/EstadoInciIterator.php");
	$estadoi = new EstadoInciIterator();
					
	$cadena =  " <SELECT name=\"estadoinci\">";
	

	while ( !$estadoi -> EOF() ) {
		$cadena = $cadena .   $estadoi -> fetch ();	
	}

	$cadena = $cadena . "<OPTION value=\"\" SELECTED> TODAS
			</SELECT>
		<input class=search type=submit value=\"Mostrar\">";
	

	return $cadena;
}


function lista_estados_inci_sin () {

	require_once("classes/iterator/EstadoInciIterator.php");
	$estadoi = new EstadoInciIterator();
					
	$cadena =  " <SELECT name=\"estadoinci\">";

	while ( !$estadoi -> EOF() ) {
		$cadena = $cadena .   $estadoi -> fetch ();	
	}

	$cadena = $cadena . "
			</SELECT>";
	

	return $cadena;
}


?>
