<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . '../');
require ("../includes/lib.php");
session_start(); 
include("includes/generic_page.php");

require_once ("../classes/class.SisifoInciHard.php");
require_once ("../classes/class.SisifoInciAltaUsr.php");
require_once ("../classes/class.SisifoInciBajaUsr.php");
require_once ("../classes/class.SisifoInciSoft.php");
require_once ("../classes/class.SisifoInciLlave.php");
require_once ("../classes/class.SisifoCambioRol.php");
require_once ("../classes/class.SisifoInciOtras.php");
require_once ("../classes/class.SisifoInciMaquina.php");
require_once ("../classes/class.SisifoInciCluster.php");

require_once("../classes/mensajes/class.SisifoArchivoMensaje.php");
require_once ("../config.php");
require_once ("../classes/mandarcorreo/class.Sisifocorreo.php");
require_once ("../classes/class.SisifoIncidencia.php");




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
	

	if(! esAdmin()  ) {
		if ($inci_uid != $uid )  {		
			echo '
	              <div class="alert alert-danger">
	                    El usuario ' . getUID($_SESSION['login']) . ' No tiene permiso para ver esa incidencia....
	              </div>
	          ';
			exit();
		}
	}

	if(! isLoggedIn()  ) {
          echo '
              <div class="alert alert-warning">
                    <strong>Acceso no autorizado</strong> ¿Ha probado a <A href="index.php">registrarse</A>?.
              </div>
          ';
		   exit();
	}
?>



<?PHP
	#
	# Tenemos algún mensaje para insertar:
	#

	if (isset ($_REQUEST['texto'])){

		if ($_REQUEST['texto'] <> ''){



			$nuevo_msg = True;
			$de = $_SESSION['uid'];
			$a = "0";
			$cc = $_REQUEST['texto'];
			$inci_mail = $_REQUEST['inci_mail'];			

			$mensaje = new SisifoMensaje ( $pid, $de, $a, "", $_REQUEST['texto'], "", $nuevo_msg );

			

			#adjuntamos archivo con ese mensaje
			if ($_FILES['adjunto']['name']<>'') {
				include ("includes/adjuntar.php");
			}

			
			$subject = "Mensaje de la incidencia ". $Incidencia ->getId() . " (" . $Incidencia ->getDescBreve() . ")";

			$mymail = new Sisifocorreo ( $_SESSION['mail'], $inci_mail, $cc, $subject,$_REQUEST['texto'] ); 

			$mymail -> enviar();



		}else{
			echo '
		      <div class="alert alert-danger">
		            Esta muy feo enviar mensajes sin contenido...
		      </div>
		    ';

		}
	}


?>

<?PHP

	$datos = $Incidencia -> toArray();
	
	echo '
       <div class="">
          <div class="card text-white o-hidden h-100" style="background-color:#576574;">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="table-responsive mr-5"><h1>Detalles de la incidencia ' . $inci_uid . '</h1><hr></div>
              		<table class="table-striped">
              			<thead><tr><th width="15%"></th><th width="1500"></th></tr></thead>
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
		        { "width": "3%" },
		        { "width": "3%" },
		        { "width": "3%" },
		        { "width": "3%" },
		        { "width": "100%" },
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

    <?php
      include ("includes/logout_modal.php");
      include ("includes/generic_footer.html");
    ?>

    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>

