<?php
session_start();

   
    require_once("../lib.php");
    require_once("../classes/class.SisifoIncidencia.php");
    require_once ("../classes/iterator/class.IncidenciaIterator.php");
    require_once ("../classes/iterator/class.TipoIncidenciaIterator.php");
    require_once ("../classes/iterator/class.EstadoIncidenciaIterator.php");
    require_once ("../classes/autenticar/class.SisifoAutenticador.php");
    require_once ("../classes/class.SisifoBuscar.php");
    require_once("libAdmin.php");




    
    include("../header.php");

 

	include ("menu_opc_buscar.php");
	
	$uid = getUID($_SESSION['login']);	
	
	$sisifoConf  = new Configuracion ( $_SESSION ['fichero'] );
	
	$SisifoInfo = $sisifoConf -> getSisifoConf ();	
	$limit_admin = $SisifoInfo -> getLimitAdmin();
	
		

	if( ($uid == 0 ) ) {
		echo 'El usuario no ha sido registrado en el sistema. Por favor <A
		 href="../logout.php">registrese</A>  en el sistema';
		exit();
	}		

     	if (!  esAdmin() ) {
          	echo"Debe ser administrador para ver esta pagina";
		exit();
     	}

	$validacion = new SisifoAutenticadorLdap ( "","");
	
	$mensaje = $_REQUEST['mensaje'];
	$anotacion = $_REQUEST['anotacion'];
	$desc_breve = $_REQUEST['desc_breve'];
	$desc_larga = $_REQUEST['desc_larga'];
	$orden_fecha = $_REQUEST['orden_fecha'];
	$usuario = $_REQUEST['usuario'];
	
	if ( ! $ordenfecha || $ordenfecha == "DESC" ) {
		$fichero_img = "sortdesc.png";
		$ordenfecha = "DESC";
	}else {
		$fichero_img = "sortasc.png";
	}	


	$buscador = new SisifoBuscar ($mensaje, $anotacion,
		$desc_breve, $desc_larga, $validacion -> getId ( $usuario ), $ordenfecha
	 );
	$sql = $buscador -> getSQL();
	

	$_SESSION ['incidencias_totales'] = sacarNumInci ( $sql );
	
	$posInicio = $_REQUEST['posInicio'];
	
	if ((!isset($posInicio)) || ($posInicio == ""))  {		
		 $posInicio = 0;
	}


	$iterator = new IncidenciaIterator ( $sql,
			 $limit_admin, $posInicio  );

?>
<div class="blogbody">

<table cellpadding=0 cellspacing=0 border=0 align="center">
 
	<tr valign="top">		
		<td style="padding-top:4;padding-right:4px;">
			<form name="opciones" action="buscar.php" method=POST>
				<input type="hidden" name="id">
				<input type="hidden" name="posInicio">
				<input type="hidden" name="ordenfecha">
				<table border=0 bgcolor=#B0B0B0 cellpadding=3 cellspacing=3 align="center">
					<th  bgColor="#cccccc" class="small" colspan=3>
						Introduzca el texto a buscar en alguno de los campos:
					</th>
					<tr>
						<td bgColor="#dddddd" style="border:1px solid #999999;">
							Descripcion breve
						</td>
						<td style = "padding-right:44px;">
							<INPUT TYPE ="text" NAME="desc_breve" SIZE = "50" MAXLENGTH = "100" VALUE="<?php  
							echo $desc_breve; ?>">
						</td>
						<td rowspan=4>
							<INPUT NAME="Enviar" VALUE="Buscar" TYPE="SUBMIT" >
						</td>
					</tr>
					<tr>
						<td bgColor="#dddddd" style="border:1px solid #999999;">
							Descripcion larga
						</td>
						<td>
							<INPUT TYPE ="text" NAME="desc_larga" SIZE = "50" MAXLENGTH = "100" VALUE="<?php  
							echo $desc_larga; ?>">
						</td>
					</tr>
					<tr>
						<td bgColor="#dddddd" style="border:1px solid #999999;">
							Anotacion
						</td>
						<td>
							<INPUT TYPE ="text" NAME="anotacion" SIZE = "50" MAXLENGTH = "100" VALUE="<?php  
							echo $anotacion; ?>">
						</td>
					</tr>
					<tr>
						<td bgColor="#dddddd" style="border:1px solid #999999;">
							Mensaje
						</td>
						<td>
							<INPUT TYPE ="text" NAME="mensaje" SIZE = "50" MAXLENGTH = "100" VALUE ="<?php  
							echo $mensaje; ?>">
						</td>
					</tr>
					<tr>
						<td bgColor="#dddddd" style="border:1px solid #999999;">
							Login
						</td>
						<td>
							<INPUT TYPE ="text" NAME="usuario" SIZE = "50" MAXLENGTH = "100" VALUE ="<?php  
							echo $usuario; ?>">
						</td>
					</tr>

				</table>
			</form>


<?php	
		include ("pintarTablaInci.php");	
?>
	
</div>	

<?php		
	
	include ("../footer.php");
				
?>


