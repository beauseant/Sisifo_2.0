<!DOCTYPE html>
<html lang="es">

<head>
  	<meta charset="UTF-8">
  	<title>Sistema de incidencias Sísifo</title>
  	<!-- Bootstrap core CSS-->
  	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  	<!-- Custom fonts for this template-->
  	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  	<!-- Custom styles for this template-->
  	<link href="css/sb-admin.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="vendor/datatables/datatables.min.css"/> 
	<script type="text/javascript" charset="utf-8" src="vendor/datatables/datatables.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#example').dataTable();
		} );
	</script>
</head>


<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Sísifo 2.0</a>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">





	<?php

	
		session_start(); 

	    require_once("classes/class.SisifoIncidencia.php");
	    require_once("classes/class.SisifoArchivo.php");   	    

	    $sisifoConf  = new Configuracion ( "sisifo.xml" );
	    
	      
	     if(isLoggedIn()) {
	     	#echo 'Conectado como <b>' . $_SESSION ['login'];
			$uid = getUID($_SESSION['login']);
	     }else {
	     	echo"Ha probado a <A href=\"index.php\">registrarse</A>?";
			exit();
	     }


		$SisifoInfo = $sisifoConf -> getSisifoConf ();
		$SisifoArchivo = new SisifoArchivo();
		

		$incidencias = $SisifoArchivo->getAllInciUser ();
		

		if ( $incidencias ) {

			$fila = '';

			$salida = '<table id="example" class="display" cellspacing="0" width="100%">
							<thead><tr><th>Id</th><th>estado</th><th>tipo</th><th>fecha</th><th>fecha resolucion</th><th width="20">descripción</th><th>con copia a</th></tr>
							</thead>
							<tbody>
						';
			foreach ($incidencias as $i) {				
				$fila = $fila. '<tr>' .
									'<td>'. $i['id']. '</td>' .
									'<td>'. $i['estado']. '</td>' .
									'<td>'. $i['tipo']. '</td>' .
									'<td>'. $i['fecha_llegada']. '</td>' .
									'<td>'. $i['fecha_resolucion']. '</td>' .
									'<td>'. $i['desc_breve']. '</td>' .
									'<td>'. $i['cc']. '</td>' .
								'</tr>';
			}
			$salida = $salida . $fila . '</tbody></table>';

			echo $salida;

		}else {		
			echo '<center>Usted aun no ha enviado ninguna incidencia al sistema</center>';
		}		
				  
	?>

        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2018</small>
        </div>
      </div>
    </footer>
  </div>


<script type="text/javascript">
	// For demo to fit into DataTables site builder...
	$('#example')
		.removeClass( 'display' )
		.addClass('tdisplay').dataTable({
  "columns": [
    { "width": "5%" },
    { "width": "5%" },
    { "width": "5%" },
    { "width": "25%" },
    { "width": "25%" },
    { "width": "30%" },
    { "width": "5%" }
  ]			
		});
</script>


	</body>
</html>