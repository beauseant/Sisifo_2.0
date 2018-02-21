<?php include("includes/generic_page.html"); ?>

<?PHP
session_start(); 

require_once ("classes/class.SisifoInciHard.php");
require_once ("classes/class.SisifoInciAltaUsr.php");
require_once ("classes/class.SisifoInciBajaUsr.php");
require_once ("classes/class.SisifoInciSoft.php");
require_once ("classes/class.SisifoInciLlave.php");
require_once ("classes/class.SisifoCambioRol.php");
require_once ("classes/class.SisifoInciOtras.php");
require_once ("classes/class.SisifoInciMaquina.php");
require_once ("classes/class.SisifoInciCluster.php");
require ("lib.php");



$pid = $_REQUEST['pid'];

print '---';
print $pid;
$tipo_incidencia = $_REQUEST['tipo_incidencia'];

	switch($tipo_incidencia) {
                case "HARDWARE":
			$Incidencia = new SisifoInciHard ( $pid );
			break;
                case "SOFTWARE":
			$Incidencia = new SisifoInciSoft ( $pid );
			break;
		case "ALTAS USUARIO":
			$Incidencia = new SisifoInciAltaUsr ( $pid );
			break;
		case "BAJAS USUARIO":
			$Incidencia = new SisifoInciBajaUsr ( $pid );
			break;
		case "LLAVES";
			$Incidencia = new SisifoInciLlave ( $pid );
			break;
		case "CAMBIO ROL";
			$Incidencia = new SisifoCambioRol ( $pid );
			break;
		case "OTRAS";
			$Incidencia = new SisifoInciOtras ( $pid );
			break;			
		case "ALTA MAQUINA";
			$Incidencia = new SisifoInciMaquina ( $pid );
			break;			
		case "CLUSTER";
			$Incidencia = new SisifoInciCluster ( $pid );
			break;
		default:
			echo "Imposible mostrar la incidencia...";
			exit();			
			break;	
	
	}
	//SisifoInciLlave

	//$Incidencia = new SisifoIncidencia ( $pid );
	
	//Para que pueda ver los detalles de una incidencia el usuario:
	//	Debe estar autenticado en la sesi�.
	//	El user id debe ser el mismo que el de la incidencia.

	print '---';
	$inci_uid = $Incidencia -> getIdUsuario();
	
	$uid = getUID($_SESSION['login']);
	

	if( isLoggedIn()  ) {
		if ($inci_uid != $uid )  {		
			echo "El usuario " . getUID($_SESSION['login']) . " No tiene permiso para ver esa incidencia....";
			exit();
		}
	}else{
		echo "No tiene permiso para ver...";
		exit();
	}
?>

          </div>
        </div>
      </div>
    </div>
    

