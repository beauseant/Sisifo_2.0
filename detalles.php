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

require_once("classes/mensajes/class.SisifoArchivoMensaje.php");
require_once ("config.php");
require_once ("classes/mandarcorreo/class.Sisifocorreo.php");
require_once ("classes/class.SisifoIncidencia.php");


require ("lib.php");



$pid = $_REQUEST['pid'];

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

	
	$inci_uid = $Incidencia -> getIdUsuario();
	
	$uid = getUID($_SESSION['login']);
	

	if( isLoggedIn()  ) {
		if ($inci_uid != $uid )  {		
			echo '
	              <div class="alert alert-danger">
	                    El usuario ' . getUID($_SESSION['login']) . ' No tiene permiso para ver esa incidencia....
	              </div>
	          ';
			exit();
		}
	}else{
          echo '
              <div class="alert alert-warning">
                    <strong>Acceso no autorizado</strong> ¿Ha probado a <A href="index.php">registrarse</A>?.
              </div>
          ';
		   exit();
	}
?>

<?PHP

	$datos = $Incidencia -> toArray();
	
	echo '
       <div class="">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="table-responsive mr-5"><h1>Detalles de la incidencia ' . $inci_uid . '</h1><hr></div>
              		<table class="table-striped">
              			<thead><tr><th width="25%"></th><th></th></tr></thead>
              			<tbody>
	              			<tr><td><b><i class="fa fa-fw fa-calendar"></i></b></td><td>' . $datos['alta']->format('Y-m-d H:i:s') .'</td></tr>
	              			<tr><td><b><i class="fa fa-fw fa-calendar"></i></b></td><td>' . $datos['update']->format('Y-m-d H:i:s') .'</td></tr>
	              			<tr><td><b><i class="fa fa-fw fa-info-circle"></i></b></td><td>' . $datos['estado'] .'</td></tr>
	              			<tr><td><b><i class="fa fa-fw fa-angle-double-right"></i></b></td><td>' . str_replace ('\r\n','<br>',$datos['descbreve']) .'</td></tr>
							<tr><td ><b><i class="fa fa-fw fa-align-right"></i></b></td><td>' . str_replace ('\r\n','<br>',$datos['desclarga']) .'</td></tr>
						</tbody>
              		</table>
              </div>
            </div>
        </div>
    ';

	#Mostramos los mensajes de la incidencia
	include ('includes/mensaje.php');

	include ('includes/enviarmsg.php')


?>

          </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>


    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

    <script type="text/javascript">
      // For demo to fit into DataTables site builder...
      $('#example')
        .removeClass( 'display' )
        .addClass('tdisplay').dataTable({
      "columns": [
        { "width": "16%" },
        { "width": "5%" },
        { "width": "5%" },
        { "width": "5%" },
        { "width": "65%" },
      ],
      "order":[[0,'desc']],
      "language":{
      		emptyTable: "No se han enviado mensajes en esta incidencia"
      	}
        });
    </script>


        </div>
      </div>
    </div>
    

